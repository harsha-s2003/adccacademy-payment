<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'libraries/lib/Utility.php');
require_once(APPPATH.'libraries/lib/config.php');
error_reporting(0);
class Welcome extends CI_Controller {

	public function student_fees()
	{
		//print_r($_SESSION);
		$getSchool =  $this->Common_model->get_data("mgs_employees","","","","school");
		$getAcademicYear =  $this->Common_model->get_data("mgs_employees","","","","academic_year");
		//print_r($getAcademicYear);exit;
		$data_array=array("title"=>"adcc academy| other fees","description"=>"","keyword"=>"","getSchool"=>$getSchool,"getAcademicYear"=>$getAcademicYear);
		$this->load->view('header');
		$this->load->view('index',$data_array);
		$this->load->view('footer');
	}

	public function index()
	{
		//print_r("expression");exit;
		//$this->load->view('header');
		$this->load->view('home');
		//$this->load->view('footer');
	}

	public function login()
	{
		$this->load->view('header');
		$this->load->view('login');
		$this->load->view('footer');
	}

	


// public function getProgramData()
// {
// 	$getclasD =  $this->Common_model->GetData("class_prog_mapping","class,program_id","class='".$_POST['class']."'","","","","1");
// if(!empty($getclasD->program_id))
// {
// 	$pid = $getclasD->program_id;
// }
// else {
// 	$pid = 0;
// }
// 	$getProgram =  $this->Common_model->GetData("student_program","program_name","id IN($pid) and status='A'","","","","");
// 	foreach($getProgram as $getProgramRow) {
// 		$Hdata = "<li><label><b><input name='program_name[]' type='checkbox' class'form-control' value=".$getProgramRow->program_name." id='geproc'>$getProgramRow->program_name</label></b></li>";
//      // $Hdata = "<option value=".$getProgramRow->program_name.">$getProgramRow->program_name</option>";
//       echo  $Hdata;       
//               }   
//          exit;     
// }

public function getProgramData()
{
    $class = $this->input->post('class');

    // 1️⃣ Get program IDs for class
    $mapRows = $this->Common_model->GetData(
        'class_prog_mapping',
        'program_id',
        "class='".$class."'"
    );

    if (empty($mapRows)) {
        echo "<p>No Program Found</p>";
        exit;
    }

    // 2️⃣ Convert program_id to comma list
    $ids = [];
    foreach ($mapRows as $row) {
        $ids[] = $row->program_id;
    }
    $idList = implode(',', $ids);

    // 3️⃣ Get program names
    $programs = $this->Common_model->GetData(
        'student_program',
        'id, program_name',
        "id IN ($idList)"
    );

    // 4️⃣ Output simple checkbox list
    foreach ($programs as $p) {
        echo '
        <div>
            <label>
                <input type="checkbox" name="program_name[]" value="'.$p->program_name.'">
                '.$p->program_name.'
            </label>
        </div>';
    }

    exit;
}





	public function register()
	{
		$getSchool =  $this->Common_model->get_data("mst_schools","status='A'","","","school_name");
		$getclass =  $this->Common_model->get_data("class_prog_mapping","","","","");
		$data_array=array("title"=>"adcc academy| EPAY",'getSchool'=>$getSchool,'getclass'=>$getclass);
		$this->load->view('header');
		$this->load->view('register',$data_array);
		$this->load->view('footer');
	}

	// public function student_login()
	// {
	// 	//print_r($_POST);exit;
	// 	$cond = "mobile='".$_POST['mobile']."' and status='A'";
	// 	$getData = $this->Common_model->GetData('student_reg','',$cond,'','','','1');
	// 	if(!empty($getData))
	// 	{
	// 		$otp = rand(100000,999999); 
	// 		$sms_mobile = "91" . $getData->mobile;
	// 		$sms_text = urlencode("Dear User, use this One-Time Password ".$otp." for verification. This OTP will be valid for the next 5 minutes. ADCC ACADEMY PVT LTD");
	// 		$req ="http://sms.oriontele.co.in/api/mt/SendSMS?user=adccac&password=innoserv&senderid=ADCCAC&channel=Trans&DCS=0&flashsms=0&number=$sms_mobile&text=$sms_text&route=07&Peid=1001261267227770429&DLTTemplateId=1007073398191054489";
	// 		$curl = curl_init();
	// 		 curl_setopt_array($curl, array(
	//           CURLOPT_URL => $req,
	//           CURLOPT_RETURNTRANSFER => true,
	//           CURLOPT_ENCODING => '',
	//           CURLOPT_MAXREDIRS => 10,
	//           CURLOPT_TIMEOUT => 0,
	//           CURLOPT_FOLLOWLOCATION => true,
	//           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	//           CURLOPT_CUSTOMREQUEST => 'GET',
	//         ));
	//         $response = curl_exec($curl);
	//         curl_close($curl);
	//         $response=json_decode($response,true);
	//         $adata = array("otp" => $otp);
	// 		$this->Common_model->SaveData('student_reg',$adata,"mobile='".$_POST['mobile']."'");
	// 		redirect(site_url('otp-verify'));		
	// 	}
	// 	else {
	// 		//echo "<script>alert('Your mobile number does not exist. Please try again.');</script>";
	// 		redirect('login');
	// 	}
		
		
	// }

	public function student_login()
	{
		$mobile = trim($_POST['mobile']);
		$academic_sess = trim($_POST['academic_sess']);

		// MOBILE + YEAR CHECK
		$cond = "mobile='".$mobile."' 
				AND session='".$academic_sess."' 
				AND status='A'";

		$getData = $this->Common_model->GetData(
			'student_reg',
			'',
			$cond,
			'',
			'',
			'',
			'1'
		);

		if (!empty($getData)) {

			$otp = rand(100000,999999);

			// SMS
			$sms_mobile = "91" . $getData->mobile;
			$sms_text = urlencode(
				"Dear User, use this One-Time Password ".$otp." for verification. This OTP will be valid for the next 5 minutes. ADCC ACADEMY PVT LTD"
			);

			// SMS API call (same as old code)

			
			$this->Common_model->SaveData(
				'student_reg',
				['otp' => $otp],
				"id='".$getData->id."'"
			);

			
			$_SESSION['otp_user_id'] = $getData->id;

			redirect(site_url('otp-verify'));

		} else {
			redirect(site_url('login'));
		}
	}


	public function otp_verify()
	{
		$this->load->view('header');
		$this->load->view('otp');
		$this->load->view('footer');
	}

	// public function otp_verification()
	// {
	// 	$cond = "otp='".$_POST['otp']."'";
	// 	$getData = $this->Common_model->GetData('student_reg','',$cond,'','','','1');
	// 	if (!empty($getData)) {
	// 		$_SESSION['adccepay'] = $getData;
	// 		redirect(site_url('dashboard'));
	// 	}
	// 	else {
	// 	//	echo "<script>alert('OTP is incorrect. Please try again')</script>";
	// 		redirect(site_url('login'));
	// 	}
	// }

	public function otp_verification()
	{
		$otp = trim($_POST['otp']);

		//  OTP user id session check
		if (empty($_SESSION['otp_user_id'])) {
			redirect(site_url('login'));
		}

		$user_id = $_SESSION['otp_user_id'];

		
		$cond = "id='".$user_id."' AND otp='".$otp."'";

		$getData = $this->Common_model->GetData(
			'student_reg',
			'',
			$cond,
			'',
			'',
			'',
			'1'
		);

		if (!empty($getData)) {

			
			$_SESSION['adccepay'] = $getData;

			
			unset($_SESSION['otp_user_id']);

			redirect(site_url('dashboard'));

		} else {
			
			redirect(site_url('otp-verify'));
		}
	}

	public function order_pay()
	{
		if(!empty($_POST['TxnRefNo']))
		{
			$data_Arr = array(
				'program' => $_POST['program'],
				'fee_amt'=>$_POST['Amount'],
				'student_id'=>$_SESSION['adccepay']->id,
				'mobile'=>$_SESSION['adccepay']->mobile,
				'transation_id'=>$_POST['TxnRefNo']
			);
			
			$this->Common_model->SaveData('student_fee_details',$data_Arr);

		} else {
			redirect('dashboard');
		}
	}

    public function response()
    {
        $response = $_POST;

        if ($response['responseCode'] == '0000') {
            $data['txnId'] = $response['txnID'];
            $data['amount'] = $response['amount'];

            $this->load->view('payment_success', $data);

        } else {

           
            $this->load->view('payment_failed');
        }
    }



	public function dashboard()
	{
		if (!empty($_SESSION['adccepay'])) {

			$getData = $this->Common_model->GetData(
				'student_reg',
				'',
				"id='".$_SESSION['adccepay']->id."'",
				'',
				'',
				'',
				'1'
			);

			$data['studentfeeD'] = $getData;

			$this->load->view('header');
			$this->load->view('dashboard', $data);
			$this->load->view('footer');

		} else {
			redirect(site_url('login'));
		}
	}
public function logout()
{
	unset($_SESSION['adccepay']);
	redirect(site_url('login'));
}
	public function save_registration_data()
	{
		$pp = implode(",",$_POST['program_name']);
		$name = trim($_POST['name']);
		$mobile = trim($_POST['mobile']);
		$school = trim($_POST['school']);
		$program_name = $_POST['program_name'];
		$class = trim($_POST['class']);
		$academic_sess = trim($_POST['academic_sess']);
		// $cond = "mobile='".$_POST['mobile']."'";
		$cond = "mobile='".$mobile."' AND session='".$academic_sess."'";
		$getData = $this->Common_model->GetData('student_reg','',$cond,'','','','1');
		if(empty($getData)) { 
		$otp = rand(100000,999999); 
			$sms_mobile = "91" . $mobile;
			$sms_text = urlencode("Dear User, use this One-Time Password ".$otp." for verification. This OTP will be valid for the next 5 minutes. ADCC ACADEMY PVT LTD");
			$req ="http://sms.oriontele.co.in/api/mt/SendSMS?user=adccac&password=innoserv&senderid=ADCCAC&channel=Trans&DCS=0&flashsms=0&number=$sms_mobile&text=$sms_text&route=07&Peid=1001261267227770429&DLTTemplateId=1007073398191054489";
			$curl = curl_init();
			 curl_setopt_array($curl, array(
	          CURLOPT_URL => $req,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => '',
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 0,
	          CURLOPT_FOLLOWLOCATION => true,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => 'GET',
	        ));
	        $response = curl_exec($curl);
	        curl_close($curl);
	        $response=json_decode($response,true);
	        $arrayR = array('name' => $name,'mobile'=>$mobile,'school'=>$school,'program'=>$pp,'class'=>$class,'otp'=>$otp,'session'=>$academic_sess);
		    $this->Common_model->SaveData('student_reg',$arrayR);
	    	redirect(site_url('login'));
		} else {
	    	//echo "<script>alert('Your Mobile No Already exist!')</script>";
	    	redirect(site_url('login'));
	    }
	}
public function payment_history()
{

	if(!empty($_SESSION['adccepay']))
	{
		$getData = $this->Common_model->GetData('student_fee_details','',"student_id='".$_SESSION['adccepay']->id."' and bank_trans_id!=''",'','','','');
		
		$data['studentfeeD'] = $getData;
		$this->load->view('header');
	    $this->load->view('payment-history',$data);
	    $this->load->view('footer');	
	}
	else {
		redirect(site_url('login'));
	}	
}

public function payment_invoice($sid)
{
	if (!empty($_SESSION['adccepay'])) {
		$getData = $this->Common_model->GetData('student_fee_details','',"id='".$sid."'",'','','','1');
		if (empty($getData)) {
			show_404();
			return;
		}
		
		$getSchData = $this->Common_model->GetData('student_reg','',"id='".$getData->student_id."'",'','','','1');
		$getProgramData = $this->Common_model->GetData('student_program','',"program_name='".$getSchData->program."'",'','','','1');
		
		$getAmountNumber = $this->convert_number($getData->fee_amt);
		$data['studentfeeD'] = $getData;
		$data['school'] = $getSchData;
		$data['program'] = $getProgramData;
		$data['word'] = $getAmountNumber;
		$this->load->view('invoice',$data);
	} else {
		redirect(site_url('login'));
	}
}
public function about_us()
{
	$this->load->view('header');
	$this->load->view('about-us');
	$this->load->view('footer');
}

public function contact_us()
{
	$this->load->view('header');
	$this->load->view('contact-us');
	$this->load->view('footer');
}
public function term_condition()
{
	$this->load->view('header');
	$this->load->view('term-condition');
	$this->load->view('footer');
}
public function privacy_policy()
{
	$this->load->view('header');
	$this->load->view('privacy-policy');
	$this->load->view('footer');
}
public function cancalation_refund_policy()
{
	$this->load->view('header');
	$this->load->view('refund-policy');
	$this->load->view('footer');
}


public function convert_number($number) {
		if (($number < 0) || ($number > 999999999)) {
			throw new Exception("Number is out of range");
		}

		$Gn = floor($number / 1000000);
		/* Millions (giga) */
		$number -= $Gn * 1000000;
		$kn = floor($number / 1000);
		/* Thousands (kilo) */
		$number -= $kn * 1000;
		$Hn = floor($number / 100);
		/* Hundreds (hecto) */
		$number -= $Hn * 100;
		$Dn = floor($number / 10);
		/* Tens (deca) */
		$n = $number % 10;
		/* Ones */

		$res = "";

		if ($Gn) {
			$res .= $this->convert_number($Gn) .  "Million";
		}

		if ($kn) {
			$res .= (empty($res) ? "" : " ") .$this->convert_number($kn) . " Thousand";
		}

		if ($Hn) {
			$res .= (empty($res) ? "" : " ") .$this->convert_number($Hn) . " Hundred";
		}

		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");

		if ($Dn || $n) {
			if (!empty($res)) {
				$res .= " and ";
			}

			if ($Dn < 2) {
				$res .= $ones[$Dn * 10 + $n];
			} else {
				$res .= $tens[$Dn];

				if ($n) {
					$res .= "-" . $ones[$n];
				}
			}
		}

		if (empty($res)) {
			$res = "zero";
		}

		return $res;
	}

}