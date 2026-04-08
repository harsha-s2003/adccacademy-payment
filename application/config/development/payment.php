<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['merchantId']      = '100000000007164';
$config['aggregatorId']    = 'A100000000007164';
$config['secretKey']       = 'db06cca0-838b-4e01-8b20-6ac446ffb6bd';
$config['initiateUrl']     = 'https://pgpayuat.icicibank.com/tsp/pg/api/v2/initiateSale';
$config['returnURL']       = site_url('payment/response');
$config['currencyCode']    = '356';
$config['payType']         = '0';
$config['transactionType'] = 'SALE';
