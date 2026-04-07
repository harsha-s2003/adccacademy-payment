<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

	/* List Page */
	public function index()
	{
		$data['gallryCategory'] = $this->Common_model->get_multiple_record("gallery_category","","id DESC");
		$this->load->view('common/header');
		$this->load->view('gallery/list',$data);
		$this->load->view('common/footer');
	}

	public function addGallery()
	{
		$data = array(
					"id"=>set_value("id"),
					"title"=>set_value("title"),
					"attachment"=>set_value("attachment"),
					"status"=>set_value("status"),
					"btn"=>"Create",
					"heading"=>"Add Gallery Category",
					"action"=>site_url('Gallery/addCategoryAction'),
				);
		$this->load->view('common/header');
		$this->load->view('gallery/form',$data);
		$this->load->view('common/footer');
	}

	public function editCatGallery($category_id='')
	{
		if(isset($_SESSION[session_name]['userid']))
		{	
			if(!empty($category_id))
			{
				$row = $this->Common_model->get_single_record("gallery_category","id='".$category_id."'");
				//print_r($row);exit;

				$data = array(
					"id"=>set_value("id",$row->id),
					"title"=>set_value("title",$row->title),
					"attachment"=>set_value("attachment",$row->attachment),
					"status"=>set_value("status",$row->status),
					"btn"=>"Update",
					"heading"=>"Edit Gallery Category",
					"action"=>site_url('Gallery/editCategoryAction'),
					);
					$this->load->view('common/header');
					$this->load->view('gallery/form',$data);
					$this->load->view('common/footer');
			}else
			{
				redirect('gallery');
			}
		}else
		{
			redirect('auth');
		}
	}

	public function editCategoryAction()
	{
		if(isset($_SESSION[session_name]['userid']))
		{
			if(!empty($_POST['id']))
			{	
				if(!empty($_FILES['attachment']['name']))
				{
					$new_doc_name = date('d-h-s').'-'.$_FILES["attachment"]['name'];
					$config['file_name'] = $new_doc_name;
					$config['upload_path']          = './assets/uploads/gallery_category';
					$config['allowed_types']        = 'jpg|jpeg|png';
					$config['max_size']      = '5120';
					
					$config['c']    = TRUE;
						//$config['encrypt_name']    = TRUE;
					$this->load->library('upload');
					$this->upload->initialize($config);
					if ($this->upload->do_upload('attachment'))
					{
						$docdata = array('upload_data' => $this->upload->data());
						$catImg = $this->Common_model->get_single_record("gallery_category","id='".$_POST['id']."'");
						if(!empty($catImg->attachment))
						{
							unlink('./assets/uploads/gallery_category/'.$catImg->attachment);
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
				
				$this->db->update("gallery_category",$data_Arr,"id='".$_POST['id']."'");
				$this->session->set_flashdata('message', 'Record has been updated successfully.');
				redirect('Gallery');
				
			}
			else
			{
				redirect("Gallery");
			}
			
		}else
		{
			redirect('auth');
		}
	}

	public function addCategoryAction()
	{
		if(isset($_SESSION[session_name]['userid']))
		{
			if(!empty($_FILES['attachment']['name']))
			{
				$new_doc_name = date('d-h-s').'-'.$_FILES["attachment"]['name'];
				$config['file_name'] = $new_doc_name;
				$config['upload_path']          = './assets/uploads/gallery_category';
				$config['allowed_types']        = 'jpg|jpeg|png';
				$config['max_size']      = '5120';
				
				$config['c']    = TRUE;
					//$config['encrypt_name']    = TRUE;
				$this->load->library('upload');
				$this->upload->initialize($config);
				if ($this->upload->do_upload('attachment'))
				{
					$docdata = array('upload_data' => $this->upload->data());
					/*$del_doc=get_image_name('news_events_quicklinks','attachment','id',$news_id);
					if(!empty($del_doc[0]['attachment']))
					{
						unlink('./uploads/news/'.$del_doc[0]['attachment']);
					}*/
					/*if(!empty($_POST['id'])){
						$del_file=get_image_name('gallery_category','file','id',$_POST['id']);
						if(!empty($del_file[0]['file']))
						{
							
							unlink('./uploads/gallery_category/'.$del_file[0]['file']);
						}
					}*/

					$data_Arr['attachment'] = $docdata['upload_data']['file_name'];
					//print_r($dtInsert['file']);exit;

				}
				else
				{
					$data_Arr['attachment'] = '';
				}
			}
			else
			{
				$data_Arr['attachment'] = '';
			}
				$data_Arr['title'] = $this->input->post('title');
				$data_Arr['status'] = $this->input->post('status');		
				$data_Arr['created'] = date('Y-m-d H:i:s');	
				$this->db->insert("gallery_category",$data_Arr);
				$this->session->set_flashdata('message', 'Record has been created successfully.');
				redirect('Gallery');
		}
		else
		{
			redirect('auth');
		}	
		
	}

	public function addImg($category_id='')
	{
		$data = array(
					"id"=>set_value("id"),
					"category_id"=>$category_id,
					"title"=>set_value("title"),
					"attachment"=>set_value("attachment"),
					"status"=>set_value("status"),
					"btn"=>"Create",
					"heading"=>"Add Gallery",
					"action"=>site_url('Gallery/addGalleryAction'),
				);
		$this->load->view('common/header');
		$this->load->view('gallery/add_gallery',$data);
		$this->load->view('common/footer');
		
	}

	public function addGalleryAction()
	{
		if(isset($_SESSION[session_name]['userid']))
		{
			
			if(!empty($_FILES['attachment']['name']))
			{
				$new_doc_name = date('d-h-s').'-'.$_FILES["attachment"]['name'];
				$config['file_name'] = $new_doc_name;
				$config['upload_path']          = './assets/uploads/gallery_category';
				$config['allowed_types']        = 'jpg|jpeg|png';
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
				$category_id = $this->input->post('category_id');
				$data_Arr['category_id'] = $this->input->post('category_id');
				$data_Arr['title'] = $this->input->post('title');
				$data_Arr['status'] = $this->input->post('status');		
				$data_Arr['created'] = date('Y-m-d H:i:s');	
				$this->db->insert("gallery",$data_Arr);
				$this->session->set_flashdata('message', 'Record has been created successfully.');
				redirect('Gallery/galleryList/'.$category_id);
			
		}
		else
		{
			redirect('auth');
		}
		
	}

	public function galleryList($category_id='')
	{
		//print_r($category_id);exit;
		if(isset($_SESSION[session_name]['userid']))
		{
			$data['galleryRecord'] = $this->Common_model->get_multiple_record("gallery","category_id='".$category_id."'");
			$data['gCategoryName'] = $this->Common_model->get_single_record("gallery_category","id='".$category_id."'");
			//print_r($data['gCategoryName']);exit;
			$this->load->view('common/header');
			$this->load->view('gallery/gallery_list',$data);
			$this->load->view('common/footer');
		}
		else
		{
			redirect('auth');
		}
	}

	/* delete gallery images */
	public function deleteImg($galleryId = '',$category_id='')
	{
		if(isset($_SESSION[session_name]['userid']))
		{
			if(!empty($galleryId) && !empty($category_id))
			{
				$getGalleryData =  $this->Common_model->get_single_record("gallery","id='".$galleryId."'");
				if($getGalleryData)
				{
					unlink('./assets/uploads/gallery_category/'.$getGalleryData->attachment);

					$this->db->delete("gallery","id='".$galleryId."'");
					$this->session->set_flashdata('message', 'Record has been deleted successfully.');
					redirect('Gallery/galleryList/'.$category_id);
				}
				
			}else
			{
				redirect('Gallery');
			}
			
		}else
		{
			redirect('auth');
		}

	}

	/* delete category as well as gallery images */

	public function delCatGallery($category_id='')
	{
		if(isset($_SESSION[session_name]['userid']))
		{
			if(!empty($category_id))
			{
				$getGalleryData =  $this->Common_model->get_single_record("gallery_category","id='".$category_id."'");
				
				if($getGalleryData)
				{
					
					$getGallery =  $this->Common_model->get_multiple_record("gallery","category_id='".$category_id."'");
					foreach($getGallery as $gallery){
						unlink('./assets/uploads/gallery_category/'.$gallery->attachment);
						$this->db->delete("gallery","id='".$gallery->id."'");
					}
					unlink('./assets/uploads/gallery_category/'.$getGalleryData->attachment);
					$this->db->delete("gallery_category","id='".$category_id."'");
					$this->session->set_flashdata('message', 'Record has been deleted successfully.');
					redirect('Gallery');
				}
				
			}else
			{
				redirect('Gallery');
			}
			
		}else
		{
			redirect('auth');
		}
		
	}



}
