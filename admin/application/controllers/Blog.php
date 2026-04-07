<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

	/* List Page */
	public function index()
	{
		$data['blogData'] = $this->Common_model->get_multiple_record("blog","","id DESC");
		$this->load->view('common/header');
		$this->load->view('blog/list',$data);
		$this->load->view('common/footer');
	}

	public function addBlog()
	{
		$data = array(
					"id"=>set_value("id"),
					"title"=>set_value("title"),
					"description"=>set_value("description"),
					"attachment"=>set_value("attachment"),
					"date"=>set_value("date"),
					"author"=>set_value("author"),
					"author_designation"=>set_value("author_designation"),
					"status"=>set_value("status"),
					"meta_title"=>set_value("meta_title"),
					"meta_desc"=>set_value("meta_desc"),
					"btn"=>"Create",
					"heading"=>"Add Blog",
					"action"=>site_url('Blog/addBlogAction'),
				);
		$this->load->view('common/header');
		$this->load->view('blog/form',$data);
		$this->load->view('common/footer');
	}

	public function addBlogAction()
	{
		if(isset($_SESSION[session_name]['userid']))
		{
			//print_r($_POST);exit;
			$journalName = str_replace(' ', '-', $this->input->post('title'));
			if(!empty($_FILES['attachment']['name']))
			{
				$new_doc_name = date('d-h-s').'-'.$_FILES["attachment"]['name'];
				$config['file_name'] = $new_doc_name;
				$config['upload_path']          = './../assets/img';
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
				$data_Arr['title'] = $this->input->post('title');
				$data_Arr['slug_name'] = strtolower($journalName);
				$data_Arr['author'] = $this->input->post('author');
				$data_Arr['author_designation'] = $this->input->post('author_designation');
				$data_Arr['date'] = $this->input->post('date');
				$data_Arr['status'] = $this->input->post('status');		
				$data_Arr['description'] = $this->input->post('description');
				$data_Arr['meta_title'] = $this->input->post('meta_title');	
				$data_Arr['meta_desc'] = $this->input->post('meta_desc');	
				$data_Arr['created'] = date('Y-m-d H:i:s');	
				$this->db->insert("blog",$data_Arr);
				$this->session->set_flashdata('message', 'Record has been created successfully.');
				redirect('blog');
			
		}else
		{
			redirect('auth');
		}
		
	}

	public function delBlog($blogId='')
	{
		
		if(isset($_SESSION[session_name]['userid']))
		{
			if(!empty($blogId))
			{
				$getBlogData =  $this->Common_model->get_single_record("blog","id='".$blogId."'");
				if($getBlogData)
				{
					unlink('./../assets/img/'.$getBlogData->attachment);

					$this->db->delete("blog","id='".$blogId."'");
					$this->session->set_flashdata('message', 'Record has been deleted successfully.');
					redirect('Blog');
				}
				
			}else
			{
				redirect('blog');
			}
			
		}else
		{
			redirect('auth');
		}
	}


	/* edit blog */
	public function editBlog($blog_id='')
	{
		if(isset($_SESSION[session_name]['userid']))
		{	
			if(!empty($blog_id))
			{
			    
				$row = $this->Common_model->get_single_record("blog","id='".$blog_id."'");

				$data = array(
					"id"=>set_value("id",$row->id),
					"title"=>set_value("title",$row->title),
					"author"=>set_value("author",$row->author),
					"author_designation"=>set_value("author_designation",$row->author_designation),
					"date"=>set_value("date",$row->date),
					"description"=>set_value("description",$row->description),
					"attachment"=>set_value("attachment",$row->attachment),
					"status"=>set_value("status",$row->status),
					"meta_title"=>set_value("meta_title",$row->meta_title),
					"meta_desc"=>set_value("meta_desc",$row->meta_desc),
					"btn"=>"Update",
					"heading"=>"Edit Blog",
					"action"=>site_url('Blog/editBlogAction'),
					);

					$this->load->view('common/header');
					$this->load->view('blog/form',$data);
					$this->load->view('common/footer');
			}else
			{
				redirect('blog');
			}
		}else
		{
			redirect('auth');
		}
	}

	/* Delete edit attachment onclick */
	public function deleteAttachment($blogId="")
	{
		if(isset($_SESSION[session_name]['userid']))
		{
			if($blogId)
			{
				$row = $this->Common_model->get_single_record("blog","id='".$blogId."'");
				if($row)
				{
					unlink('./../assets/img/'.$row->attachment);
					$updateImgArray = array("attachment"=>'');
					$this->db->update("blog",$updateImgArray,"id='".$blogId."'");
					$this->session->set_flashdata('message', 'Record has been deleted successfully.');
					redirect('Blog/editBlog/'.$blogId);
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

	public function editBlogAction()
	{
		/*print_r($_POST);exit;*/
		if(isset($_SESSION[session_name]['userid']))
		{
			if(!empty($_POST['id']))
			{	
			    $journalName = str_replace(' ', '-', $this->input->post('title'));
				if(!empty($_FILES['attachment']['name']))
				{
					$new_doc_name = date('d-h-s').'-'.$_FILES["attachment"]['name'];
					$config['file_name'] = $new_doc_name;
					$config['upload_path']          = './../assets/img';
					$config['allowed_types']        = 'jpg|jpeg|png';
					$config['max_size']      = '5120';
					
					$config['c']    = TRUE;
						//$config['encrypt_name']    = TRUE;
					$this->load->library('upload');
					$this->upload->initialize($config);
					if ($this->upload->do_upload('attachment'))
					{
						$docdata = array('upload_data' => $this->upload->data());
						$catImg = $this->Common_model->get_single_record("blog","id='".$_POST['id']."'");
						if(!empty($catImg->attachment))
						{
							unlink('./../assets/img/'.$catImg->attachment);
						}
						
						$data_Arr['attachment'] = $docdata['upload_data']['file_name'];
						
					}
					else
					{
						$data_Arr['attachment'] = '';
					}
				}

				$data_Arr['title'] = $this->input->post('title');
				$data_Arr['slug_name'] = strtolower($journalName);
				$data_Arr['author'] = $this->input->post('author');
				$data_Arr['author_designation'] = $this->input->post('author_designation');
				$data_Arr['date'] = $this->input->post('date');
				$data_Arr['status'] = $this->input->post('status');		
				$data_Arr['description'] = $this->input->post('description');	
				$data_Arr['meta_title'] = $this->input->post('meta_title');	
				$data_Arr['meta_desc'] = $this->input->post('meta_desc');
				//$data_Arr['created'] = date('Y-m-d H:i:s');	
				/*$this->db->insert("blog",$data_Arr);
				$this->session->set_flashdata('message', 'Record has been updated successfully.');*/
				
				$this->db->update("blog",$data_Arr,"id='".$_POST['id']."'");
				$this->session->set_flashdata('message', 'Record has been updated successfully.');
				redirect('Blog');
			}
			else
			{
				redirect("Blog");
			}
			
		}else
		{
			redirect('auth');
		}
	}
}
