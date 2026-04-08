<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    private $merchantId;
    private $aggregatorId;
    private $secretKey;
    private $initiateUrl;
    private $returnUrl;
    private $currencyCode;
    private $payType;
    private $transactionType;

    public function __construct()
    {
        parent::__construct();

        // Load payment configuration based on environment
        $config = [];
        $baseConfigFile = dirname(__FILE__) . '/../config/payment.php';
        $envConfigFile = dirname(__FILE__) . '/../config/' . ENVIRONMENT . '/payment.php';

        // Load base config
        if (file_exists($baseConfigFile)) {
            include $baseConfigFile;
        }

        // Load environment-specific config (overrides base)
        if (file_exists($envConfigFile)) {
            include $envConfigFile;
        }

        if (!isset($config) || !is_array($config)) {
            show_error('Payment configuration is invalid.', 500);
            return;
        }

        $this->merchantId      = isset($config['merchantId']) ? $config['merchantId'] : '';
        $this->aggregatorId    = isset($config['aggregatorId']) ? $config['aggregatorId'] : '';
        $this->secretKey       = isset($config['secretKey']) ? $config['secretKey'] : '';
        $this->initiateUrl     = isset($config['initiateUrl']) ? $config['initiateUrl'] : '';
        $this->returnUrl       = isset($config['returnURL']) ? $config['returnURL'] : '';
        $this->currencyCode    = isset($config['currencyCode']) ? $config['currencyCode'] : '';
        $this->payType         = isset($config['payType']) ? $config['payType'] : '0';
        $this->transactionType = isset($config['transactionType']) ? $config['transactionType'] : '';
    }

    public function pay()
    {
        $orderId = trim($this->input->post('TxnRefNo', true));
        $amountRaw = trim($this->input->post('Amount', true));
        $sessionUser = isset($_SESSION['adccepay']) ? $_SESSION['adccepay'] : null;

        if (empty($orderId) || empty($amountRaw) || !is_numeric($amountRaw) || (float)$amountRaw <= 0) {
            show_error('Invalid payment request.', 400);
            return;
        }

        if (empty($sessionUser) || empty($sessionUser->id)) {
            show_error('Session expired or invalid. Please login again.', 401);
            return;
        }

        $requiredConfig = [
            'merchantId' => $this->merchantId,
            'aggregatorId' => $this->aggregatorId,
            'secretKey' => $this->secretKey,
            'initiateUrl' => $this->initiateUrl,
            'returnUrl' => $this->returnUrl,
            'currencyCode' => $this->currencyCode,
            'payType' => $this->payType,
            'transactionType' => $this->transactionType,
        ];

        foreach ($requiredConfig as $key => $value) {
            if (!isset($value) || $value === null || $value === '') {
                show_error('Payment gateway configuration missing: ' . $key, 500);
                return;
            }
        }

        $amountFormatted = number_format((float)$amountRaw, 2, '.', '');
        $txnDate = date('YmdHis');

        // Check if transaction already exists
        $existingTransaction = $this->Common_model->GetData('student_fee_details', '', "transation_id = '" . $orderId . "'", '', '', '1');
        if (!empty($existingTransaction)) {
            // If transaction already exists and is not failed, don't create duplicate
            if ($existingTransaction->payment_status !== 'Failed') {
                show_error('Transaction already initiated. Please check your payment history.', 400);
                return;
            }
            // If it was failed, we'll update it below
        }

        $feeData = [
            'program' => isset($sessionUser->program) ? $sessionUser->program : '',
            'fee_amt' => $amountFormatted,
            'student_id' => $sessionUser->id,
            'mobile' => isset($sessionUser->mobile) ? $sessionUser->mobile : '',
            'transation_id' => $orderId,
            'payment_status' => 'Pending',
            'payment_date' => date('d-m-Y H:i'),
            'bank_remark' => 'Payment initiated'
        ];

        // Insert new record or update existing failed one
        if (empty($existingTransaction)) {
            $this->Common_model->SaveData('student_fee_details', $feeData);
        } else {
            $this->Common_model->SaveData('student_fee_details', $feeData, "transation_id = '" . $orderId . "'");
        }

        $customerEmail = !empty($sessionUser->email) ? $sessionUser->email : 'customer@example.com';
        $customerMobile = !empty($sessionUser->mobile) ? $sessionUser->mobile : '9999999999';
        $customerName = !empty($sessionUser->name) ? $sessionUser->name : 'Customer';
        $addlParam1 = $this->input->post('addlParam1', true) ?: '';
        $addlParam2 = $this->input->post('addlParam2', true) ?: '';

        $requestData = [
            'merchantId' => $this->merchantId,
            'aggregatorID' => $this->aggregatorId,
            'merchantTxnNo' => $orderId,
            'amount' => $amountFormatted,
            'currencyCode' => $this->currencyCode,
            'payType' => $this->payType,
            'customerEmailID' => $customerEmail,
            'transactionType' => $this->transactionType,
            'returnURL' => $this->returnUrl,
            'txnDate' => $txnDate,
            'customerMobileNo' => $customerMobile,
            'customerName' => $customerName,
            'addlParam1' => $addlParam1,
            'addlParam2' => $addlParam2,
        ];

        $hashString =
            $requestData['addlParam1'] .
            $requestData['addlParam2'] .
            $requestData['aggregatorID'] .
            $requestData['amount'] .
            $requestData['currencyCode'] .
            $requestData['customerEmailID'] .
            $requestData['customerMobileNo'] .
            $requestData['customerName'] .
            $requestData['merchantId'] .
            $requestData['merchantTxnNo'] .
            $requestData['payType'] .
            $requestData['returnURL'] .
            $requestData['transactionType'] .
            $requestData['txnDate'];

        $requestData['secureHash'] = hash_hmac('sha256', $hashString, $this->secretKey);

        $curlResult = $this->sendJsonRequest($this->initiateUrl, $requestData);
        if ($curlResult['error']) {
            log_message('error', 'Payment gateway request failed: ' . $curlResult['message'] . ' | HTTP Code: ' . $curlResult['http_code']);
            show_error('Payment gateway request failed: ' . $curlResult['message'], 502);
            return;
        }

        $result = json_decode($curlResult['body'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'Payment gateway JSON decode error: ' . json_last_error_msg() . ' | Response: ' . substr($curlResult['body'], 0, 500));
            // For debugging in development, show the actual response
            if (ENVIRONMENT === 'development') {
                echo '<h3>Gateway Response (Debug):</h3><pre>' . htmlspecialchars(substr($curlResult['body'], 0, 1000)) . '</pre>';
            }
            show_error('Invalid response format from payment gateway. Please try again.', 502);
            return;
        }

        if (!is_array($result)) {
            log_message('error', 'Payment gateway response is not an array: ' . print_r($result, true));
            show_error('Unexpected response format from payment gateway.', 502);
            return;
        }

        if (isset($result['responseCode']) && $result['responseCode'] === 'R1000' && !empty($result['redirectURI']) && !empty($result['tranCtx'])) {
            $redirectUrl = $result['redirectURI'] . '?tranCtx=' . urlencode($result['tranCtx']);
            header('Location: ' . $redirectUrl);
            exit;
        }

        log_message('error', 'Payment gateway response missing redirect or invalid success code: ' . print_r($result, true));
        show_error('Unable to proceed to payment gateway. Please try again later.', 502);
    }

    private function sendJsonRequest($url, $payload)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Add timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // Add connection timeout

        $body = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_errno($ch) ? curl_error($ch) : null;
        curl_close($ch);

        return [
            'error' => !empty($error) || $httpCode >= 400,
            'message' => $error ?: 'HTTP ' . $httpCode,
            'body' => $body,
            'http_code' => $httpCode,
        ];
    }

    // RESPONSE HANDLER
    public function response()
    {
        $data = $_POST;

        $merchant_txn_no = isset($data['merchantTxnNo']) ? $data['merchantTxnNo'] : '';
        if (empty($merchant_txn_no)) {
            log_message('error', 'Payment response missing merchantTxnNo: ' . print_r($data, true));
            show_error('Payment response is invalid.', 400);
            return;
        }

        $existingRecord = $this->Common_model->GetData('student_fee_details', '', "transation_id = '" . $merchant_txn_no . "'", '', '', '1');
        if (!empty($existingRecord) && $existingRecord->payment_status === 'Done') {
            redirect(site_url('payment-history'));
            return;
        }

        if (isset($data['responseCode']) && ($data['responseCode'] == '0000' || $data['responseCode'] == '000')) {
            $payment_date = '';
            if (isset($data['paymentDateTime']) && !empty($data['paymentDateTime']) && strlen($data['paymentDateTime']) == 14) {
                $payment_date = substr($data['paymentDateTime'], 6, 2) . '-' . substr($data['paymentDateTime'], 4, 2) . '-' . substr($data['paymentDateTime'], 0, 4) . ' ' . substr($data['paymentDateTime'], 8, 2) . ':' . substr($data['paymentDateTime'], 10, 2);
            }
            if (empty($payment_date)) {
                $payment_date = date('d-m-Y H:i');
            }

            $update_data = array(
                'bank_trans_id' => isset($data['txnID']) ? $data['txnID'] : '',
                'payment_status' => 'Done',
                'payment_date' => $payment_date,
                'bank_remark' => isset($data['respDescription']) ? $data['respDescription'] : 'Transaction Successful'
            );

            $this->Common_model->SaveData('student_fee_details', $update_data, "transation_id = '" . $merchant_txn_no . "'");
            redirect(site_url('payment-history'));
            return;
        }

        // Handle failed payment
        $update_data = array(
            'payment_status' => 'Failed',
             'bank_remark' => isset($data['respDescription']) ? $data['respDescription'] : 'Transaction Failed'
        );
        $this->Common_model->SaveData('student_fee_details', $update_data, "transation_id = '" . $merchant_txn_no . "'");
        $this->session->set_flashdata('error', 'Payment failed. ' . (isset($data['respDescription']) ? $data['respDescription'] : 'Please try again.'));
        redirect(site_url('dashboard'));
        return;
    }
}