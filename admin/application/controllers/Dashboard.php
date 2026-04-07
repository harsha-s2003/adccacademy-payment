<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	
	public function index()
	{
		$dynamic['title'] = "dashboard";
		$this->load->view('common/header',$dynamic);
		$this->load->view('dashboard/dashboard');
		$this->load->view('common/footer');
	}
}
