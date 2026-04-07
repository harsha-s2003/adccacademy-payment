<?php
defined('BASEPATH') OR exit('No direct script access allowed');




$route['404_override'] = '';
$default_controller = 'Welcome';
$route['default_controller'] = "$default_controller";
$route['translate_uri_dashes'] = TRUE;
$route['payment'] = 'payment/index';
$route['payment/pay'] = 'payment/pay';
$route['payment/response'] = 'payment/response';


$controller_exceptions = array("save-form-data","getInstructionData","online-payment","payment-history","print-invoice","view-history","search-employee","payment-online-booking","payment-response","payment-history-user","login","register",
  "student-fees","save-registration-data","student-login","getProgramData","otp-verify","otp-verification","dashboard","logout","order-pay","response","resstatus","about-us","contact-us","privacy-policy","cancalation-refund-policy","shiping-delivery-policy","term-condition","payment-history","payment-invoice"); // here signup is controller function name. You can add as many as controller function names.

foreach($controller_exceptions as $v) {
  $route[$v] = "$default_controller/".$v;
  $route[$v."/(.*)"] = "$default_controller/".$v.'/$1';
}