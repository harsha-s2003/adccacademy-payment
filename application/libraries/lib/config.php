<?php
/*
* PHP Kit for Icici Merchant Solutions
* Version: 1.0.5
*/

/*Enter UAT kit parameters */
//define('ENC_KEY', '1FF49170C8CCECFF1345B38F971CABBD'); 
define('ENC_KEY', '34BFF1B30633C9EECD60C7BAA7BAE8F9'); 
//define('SECURE_SECRET', '5FF1003BD85EC13EDDE106AC235F58AD'); 
define('SECURE_SECRET', 'F65D0C5F6232FE7C89D08E55B65ECFE1'); 
define('VERSION', '1'); 
//define('PASSCODE', 'ABCD1234'); //Must be 8 digit only. No special characters allowed
define('PASSCODE', 'VMKJ4787'); //Must be 8 digit only. No special characters allowed
//define('MERCHANTID', '100000000005859'); //This is not being used in kit but for your reference in case of use it as global
define('MERCHANTID', '1000000000394904'); //This is not being used in kit but for your reference in case of use it as global
//define('TERMINALID', 'EG000488'); //This is not being used in kit but for your reference in case of use it as global
define('TERMINALID', 'EG003806'); //This is not being used in kit but for your reference in case of use it as global
define('BANKID', '24520'); //Must be 6 digit only. No special characters allowed
//define('MCC', '8641'); //Must be 4 digit only. No special characters allowed
define('MCC', '8299'); //Must be 4 digit only. No special characters allowed
// define('GATEWAYURL', 'https://paypg.icicibank.com/accesspoint/angularBackEnd/requestproxypass'); 
// define('REFUNDURL', 'https://paypg.icicibank.com/accesspoint/v1/24520/createRefundFromMerchantKit'); 
// define('STATUSURL', 'https://paypg.icicibank.com/accesspoint/v1/24520/checkStatusMerchantKit');

define('GATEWAYURL', 'https://pgpay.icicibank.com/pg/api/v2/initiateSale'); 
define('REFUNDURL', 'https://pgpay.icicibank.com/pg/api/commandt'); 
define('STATUSURL', 'https://pgpay.icicibank.com/pg/api/command');
define('RETURNURL', 'https://adccacademy.com/epay/response'); // define('RETURNURL', 'YOUR_DOMAIN/ICICI_MS/responseSale.

?>