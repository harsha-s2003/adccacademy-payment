<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['merchantId']      = 'PROD_MERCHANT_ID';
$config['aggregatorId']    = 'PROD_AGGREGATOR_ID';
$config['secretKey']       = 'PROD_SECRET_KEY';
$config['initiateUrl']     = 'https://prod-url.example.com/tsp/pg/api/v2/initiateSale';
$config['returnURL']       = site_url('payment/response');
$config['currencyCode']    = '356';
$config['payType']         = '0';
$config['transactionType'] = 'SALE';
