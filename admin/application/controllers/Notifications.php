<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {

	/* List Page */
	public function index()
	{
		$data['notificationsData'] = $this->Common_model->get_multiple_record("notifications","","id DESC");
		$this->load->view('common/header');
		$this->load->view('notifications/list',$data);
		$this->load->view('common/footer');
	}

	public function addNotification()
	{
		$data = array(
					"id"=>set_value("id"),
					"title"=>set_value("title"),
					"description"=>set_value("description"),
					"attachment"=>set_value("attachment"),
					/*"date"=>set_value("date"),
					"author"=>set_value("author"),
					"author_designation"=>set_value("author_designation"),*/
					"status"=>set_value("status"),
					"btn"=>"Create",
					"heading"=>"Add Notification",
					"action"=>site_url('Notifications/addNotificationAction'),
				);
		$this->load->view('common/header');
		$this->load->view('notifications/form',$data);
		$this->load->view('common/footer');
	}


	public function addNotificationAction()
	{
		if(isset($_SESSION[session_name]['userid']))
		{
			/*print_r($_POST);exit;*/
			if(!empty($_FILES['attachment']['name']))
			{
				$new_doc_name = date('d-h-s').'-'.$_FILES["attachment"]['name'];
				$config['file_name'] = $new_doc_name;
				$config['upload_path']          = './assets/uploads/notifications';
				$config['allowed_types']        = '*';
				$config['max_size']      = '5120';
				
				$config['c']    = TRUE;
					//$config['encrypt_name']    = TRUE;
				$this->load->library('upload');
				$this->upload->initialize($config);
				if ($this->upload->do_upload('attachment'))
				{
					$docdata = array('upload_data' => $this->upload->data());

					$data_Arr['attachment'] = $docdata['upload_data']['file_name'];

				}
				else
				{
					$data_Arr['attachment'] = '';
				}
			}

				$data_Arr['title'] = $this->input->post('title');
				$data_Arr['status'] = $this->input->post('status');		
				$data_Arr['description'] = $this->input->post('description');		
				$data_Arr['created'] = date('Y-m-d H:i:s');	
				$this->db->insert("notifications",$data_Arr);
				$this->session->set_flashdata('message', 'Record has been created successfully.');
				redirect('Notifications');
		}
		else
		{
			redirect('auth');
		}
		
	}

	public function delNotification($id='')
	{
		if(isset($_SESSION[session_name]['userid']))
		{
			if(!empty($id))
			{
				$getNotifyData =  $this->Common_model->get_single_record("notifications","id='".$id."'");
				if($getNotifyData)
				{
					unlink('./assets/uploads/notifications/'.$getNotifyData->attachment);

					$this->db->delete("notifications","id='".$id."'");
					$this->session->set_flashdata('message', 'Record has been deleted successfully.');
					redirect('Notifications');
				}
				
			}else
			{
				redirect('Notifications');
			}
			
		}else
		{
			redirect('auth');
		}
	}


	public function editNotification($id='')
	{
		if(isset($_SESSION[session_name]['userid']))
		{
			if(!empty($id))
			{
				$row = $this->Common_model->get_single_record("notifications","id='".$id."'");

				$data = array(
					"id"=>set_value("id",$row->id),
					"title"=>set_value("title",$row->title),					
					"description"=>set_value("description",$row->description),
					"attachment"=>set_value("attachment",$row->attachment),
					"status"=>set_value("status",$row->status),
					"btn"=>"Update",
					"heading"=>"Edit Notification",
					"action"=>site_url('Notifications/editNotifyAction'),
					);

					$this->load->view('common/header');
					$this->load->view('notifications/form',$data);
					$this->load->view('common/footer');
			}else
			{
				redirect('Notifications');
			}
		}else
		{
			redirect('auth');
		}
	}

	public function editNotifyAction()
	{
		if(isset($_SESSION[session_name]['userid']))
		{
			
			if(!empty($_FILES['attachment']['name']))
			{
				$new_doc_name = date('d-h-s').'-'.$_FILES["attachment"]['name'];
				$config['file_name'] = $new_doc_name;
				$config['upload_path']          = './assets/uploads/notifications';
				$config['allowed_types']        = '*';
				$config['max_size']      = '5120';
				
				$config['c']    = TRUE;
					//$config['encrypt_name']    = TRUE;
				$this->load->library('upload');
				$this->upload->initialize($config);
				if ($this->upload->do_upload('attachment'))
				{
					$docdata = array('upload_data' => $this->upload->data());

					$data_Arr['attachment'] = $docdata['upload_data']['file_name'];


						$catImg = $this->Common_model->get_single_record("notifications","id='".$_POST['id']."'");
						if(!empty($catImg->attachment))
						{
							unlink('./assets/uploads/notifications/'.$catImg->attachment);
						}
						
						$data_Arr['attachment'] = $docdata['upload_data']['file_name'];

				}
				else
				{
					$data_Arr['attachment'] = '';
				}
			}

				$data_Arr['title'] = $this->input->post('title');
				$data_Arr['status'] = $this->input->post('status');		
				$data_Arr['description'] = $this->input->post('description');		
				//$data_Arr['created'] = date('Y-m-d H:i:s');	
				$this->db->update("notifications",$data_Arr,"id='".$_POST['id']."'");
				$this->session->set_flashdata('message', 'Record has been updated successfully.');

				//$this->db->insert("notifications",$data_Arr);
				//$this->session->set_flashdata('message', 'Record has been created successfully.');
				redirect('Notifications');
		}
		else
		{
			redirect('auth');
		}
	}

	/* Delete edit attachment onclick */
	public function deleteAttachment($id="")
	{
		if(isset($_SESSION[session_name]['userid']))
		{
			if($id)
			{
				$row = $this->Common_model->get_single_record("notifications","id='".$id."'");
				if($row)
				{
					unlink('./assets/uploads/notifications/'.$row->attachment);
					$updateImgArray = array("attachment"=>'');
					$this->db->update("notifications",$updateImgArray,"id='".$id."'");
					$this->session->set_flashdata('message', 'Record has been deleted successfully.');
					redirect('Notifications/editNotification/'.$id);
				}
			}else
			{
				resdirect("blog");
			}
		}else
		{
			redirect('auth');
		}
	}

	
}