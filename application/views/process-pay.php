<!-- <php
set_time_limit(0);

if(!$_POST) {
  exit;
}

require_once(APPPATH.'libraries/lib/Utility.php');
require_once(APPPATH.'libraries/lib/config.php');
$utility = new Utility();

$logFilePath = 'sale_log.log';

$EncKey = ENC_KEY;
$SECURE_SECRET = SECURE_SECRET;
$gatewayURL = GATEWAYURL;

$utility->validate(); 


$data = $_POST;

$data['Version'] = VERSION;
$data['PassCode'] = PASSCODE;
$data['BankId'] = BANKID;

$data['MCC'] = MCC;

$data['ReturnURL'] = RETURNURL;
$data['Amount'] = $data['Amount']*100;

unset($data["SubButL"]);

ksort($data);

$dataToPostToPG="";
foreach ($data as $key => $value) 
{
  if("" == trim($value) && $value === NULL){
  
  } else {
    $dataToPostToPG=$dataToPostToPG.$key."||".($value)."::";
  }
}


$SecureHash = $utility->generateSecurehash($data);

$dataToPostToPG="SecureHash||".urlencode($SecureHash)."::".$dataToPostToPG;)
$dataToPostToPG=substr($dataToPostToPG, 0, -2);

$dataArray = explode("::", $dataToPostToPG);
$currentTime = date('d-m-Y H:i:s'); 
$logRequest = 'Request:'."[$currentTime]"; 
$logRequest .= json_encode($dataArray);
$logFile = fopen($logFilePath, 'a');
fwrite($logFile, $logRequest . PHP_EOL.PHP_EOL);
fclose($logFile);


$EncData=$utility->encrypt($dataToPostToPG, $EncKey);
?>

<form action="<php echo $gatewayURL;?>" method="post" name="server_request" id="sales-api-form" target="_top">
    <input type="hidden" name="EncData" id="EncData" value="?php echo  $EncData; ?>">
    <input type="hidden" name="MerchantId" id="MerchantId" value="<php echo $data['MerchantId']; ?>" />
    <input type="hidden" name="BankId" id="BankId" value="<php echo $data['BankId']; ?>" />
    <input type="hidden" name="TerminalId" id="TerminalId" value="<php echo $data['TerminalId']; ?>">
    <input type="hidden" name="Version" id="Version" value="?php echo $data['Version']; ?>">
</form>
<script type="text/javascript">
document.server_request.submit();
</script> -->