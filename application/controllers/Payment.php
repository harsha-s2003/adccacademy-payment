<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    private $merchantId = "100000000007164";
    private $aggregatorId = "A100000000007164";
    private $secretKey = "db06cca0-838b-4e01-8b20-6ac446ffb6bd";

    private $initiateUrl = "https://pgpayuat.icicibank.com/tsp/pg/api/v2/initiateSale";

    public function pay()
    {


    
        $orderId = $this->input->post('TxnRefNo');
        $amount  = $this->input->post('Amount');

        if(empty($orderId) || empty($amount)){
            echo "Invalid Request";
            exit;
        }

        // FORMAT AMOUNT
        $amountFormatted = number_format($amount, 2, '.', '');

        // FIXED RETURN URL (VERY IMPORTANT)
        $returnUrl = "http://localhost/epay/epay/payment/response";

        $txnDate = date('YmdHis');

        // REQUEST DATA
        // $data = [
        //     "merchantId" => $this->merchantId,
        //     "aggregatorID" => $this->aggregatorId,
        //     "merchantTxnNo" => $orderId,
        //     "amount" => $amountFormatted,
        //     "currencyCode" => "356",
        //     "payType" => "0",
        //     "customerEmailID" => "Dummyemail@icicibank.com",
        //     "transactionType" => "SALE",
        //     "returnURL" => $returnUrl,
        //     "txnDate" => $txnDate,
        //     "customerMobileNo" => "9876543210",
        //     "customerName" => "Manish",
        //     "addlParam1" => "ABCD",
        //     "addlParam2" => "111"
        // ];
        $data = [
            "merchantId" => "100000000007164",
            "aggregatorID" => "A100000000007164",
            "merchantTxnNo" => "757585887575",
            "amount" => "100.00",
            "currencyCode" => "356",
            "payType" => "0",
            "customerEmailID" => "Dummyemail@icicibank.com",
            "transactionType" => "SALE",
            "returnURL" => "https://pgpayuat.icicibank.com/tsp/pg/api/merchant",
            "txnDate" => "20241121115413",
            "customerMobileNo" => "9876543210",
            "customerName" => "Manish",
            "addlParam1" => "ABCD",
            "addlParam2" => "111"
        ];

        // HASH GENERATION (EXACT ORDER)
        $hashString =
        $data['addlParam1'] .
        $data['addlParam2'] .
        $data['aggregatorID'] .
        $data['amount'] .
        $data['currencyCode'] .
        $data['customerEmailID'] .
        $data['customerMobileNo'] .
        $data['customerName'] .
        $data['merchantId'] .
        $data['merchantTxnNo'] .
        $data['payType'] .
        $data['returnURL'] .
        $data['transactionType'] .
        $data['txnDate'];

        $data['secureHash'] = hash('sha256', $hashString . $this->secretKey);


        //  DEBUG 
        // echo "<pre>";

        // echo "POST DATA:\n";
        // print_r($_POST);

        // echo "\n\nFINAL DATA:\n";
        // print_r($data);

        // echo "\n\nHASH STRING:\n";
        // echo $hashString;

        // echo "\n\nHASH:\n";
        // echo $data['secureHash'];

        // exit;

        // CURL CALL
        $ch = curl_init($this->initiateUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // LOCALHOST FIX
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);

        if(curl_errno($ch)){
            echo "Curl Error: " . curl_error($ch);
            exit;
        }

        curl_close($ch);

        if(empty($response)){
            echo "Empty response from ICICI";
            exit;
        }

        $result = json_decode($response, true);

        if(!$result){
            echo "Invalid JSON Response";
            print_r($response);
            exit;
        }

        // SUCCESS REDIRECT
        if (isset($result['responseCode']) && $result['responseCode'] == 'R1000') {

            $redirectUrl = $result['redirectURI'] . "?tranCtx=" . $result['tranCtx'];

            header("Location: " . $redirectUrl);
            exit;

        } else {
            echo "<pre>";
            print_r($result);
        }
    }

    // RESPONSE HANDLER
    public function response()
    {
        $data = $_POST;

        echo "<h2>Payment Response</h2>";
        echo "<pre>";
        print_r($data);

        if(isset($data['responseCode']) && ($data['responseCode'] == '0000' || $data['responseCode'] == '000')){
            echo "<h3 style='color:green;'>Payment Successful </h3>";
        } else {
            echo "<h3 style='color:red;'>Payment Failed </h3>";
        }
    }
}