<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends CI_Controller {

	/* List Page */
	public function form_enquiry()
	{
		$data['enquiryData'] = $this->Common_model->get_multiple_record("enquiry_form","","id DESC");
		$this->load->view('common/header');
		$this->load->view('enquiry/list',$data);
		$this->load->view('common/footer');
	}

	
	
}