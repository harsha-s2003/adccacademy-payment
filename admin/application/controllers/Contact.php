<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	/* List Page */
	public function contact_list()
	{
		$data['ContactData'] = $this->Common_model->get_multiple_record("contact_form","","id DESC");
		$this->load->view('common/header');
		$this->load->view('Contact/list',$data);
		$this->load->view('common/footer');
	}

	
	
}