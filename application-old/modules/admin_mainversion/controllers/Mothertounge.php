<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mothertounge extends CI_Controller {
	
	public $headerPage = 'admin_header';
	public $addPage    = 'mothertounge-add';	   
	public $editPage   = 'mothertounge-edit';   
	public $listPage   = 'mothertounge';		  

	public $listPage_redirect = '/admin/Mothertounge';		 
	public $addPage_redirect  = '/admin/Mothertounge/add/';	
	public $editPage_redirect = '/admin/Mothertounge/edit/';  

	public function __construct() 
	{
        parent::__construct();
  		$this->load->model('Mothertounge_model','my_model');  
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		error_reporting(0);
		ini_set('display_errors','off'); 
    }

	public function index()
	{ 	
		$data['record'] = $this->my_model->get_all_records();	
		$this->load->view($this->headerPage);
		$this->load->view($this->listPage,$data);
	}

    public function add()
	{ 
		$data['msg'] ='';
		if($this->input->post('submit') != '')
		{
	
				$result = $this->my_model->add_record();
				if($result){
					$this->session->set_flashdata('msg_succ', 'added Successfully...');
					redirect($this->listPage_redirect);
					} else {
						$data['msg'] = "please try again...";
					}
		}
		$this->load->view($this->headerPage);
		$this->load->view($this->addPage,$data);
	}


	public function edit($id)
	{
		$data['record'] = $this->my_model->get_single_record($id);
		$data['msg'] ='';
		if($this->input->post('submit') != '')
		{
			    $result = $this->my_model->update_record($id);
			    if($result)
			    {
				
			    $this->session->set_flashdata('msg_succ', 'updated Successfully...');
				redirect($this->listPage_redirect);
				} else 
				{
						
					$data['msg'] = "please try again...";
				}	
		    }
		$this->load->view($this->headerPage);
		$this->load->view($this->editPage,$data);
	}


	public function delete($id)
	{ 
		$data['msg'] ='';
		if($id)
		{
			$result = $this->my_model->delete_record($id);
			if($result)
			{
				$this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
				redirect($this->listPage_redirect);
			} else 
			{
				$data['msg'] = "Not Deleted...";
			}
		}
	}

	public function delete_selected()
	{
		$data['msg'] ='';
		if($this->input->post('selected_ids') != '')
		{
			$delete_ids = $this->input->post('selected_ids');
			for($i=0;$i<count($delete_ids);$i++)
			{
				$result = $this->my_model->delete_record($delete_ids[$i]);
			}
			if($result)
			{
				$this->session->set_flashdata('msg_succ', 'Deleted Successfully...');
				redirect($this->listPage_redirect);
			}else
			{
				$this->session->set_flashdata('msg_succ', 'Not Deleted...');
				redirect($this->listPage_redirect);
			}
		}
		else
		{
			$this->session->set_flashdata('msg_succ', 'Select any Check Box...');
			redirect($this->listPage_redirect);
		}
	}
	
	
	public function status($id,$status)
	{
		$data['msg'] ='';
		$statu = ($status == 1 ? 'Deactive' : 'Active');
		if($id)
		{
			$result = $this->my_model->status_record($id,$status);
			if($result)
			{
				$this->session->set_flashdata('msg_succ', $statu.' Successfully...');
				redirect($this->listPage_redirect);
			} else
			{
				$data['msg'] = " Status Not Updated...";
			}
		}
	}
}
?>