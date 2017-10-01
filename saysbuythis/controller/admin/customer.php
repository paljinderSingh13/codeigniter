<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller{
	
	
	public function __construct(){
		parent::__construct();
	    $this->load->helper('url');
	    $this->load->library('session');
	    $this->load->model('common_model');
		$this->load->model('backend/CustomerModel');
		if(empty($this->session->userdata('user_id'))){
			redirect('admin/login/logout');
		}
	}
	
	function index(){
		//$data = array('index' => 'customer/view');	
		/* $this->load->view('layout',$data);	 */	

		 date('Y-m-d H:i:s'); 
		$this->data['user_data'] =	$this->CustomerModel->getUser();
		//echo "<pre>";
	//	print_r($this->data['user_data']);
	//die;
		$this->middle = 'customer/view';
		$this->layout();
	}
	public function user_status()
	{	
	//print_r($_POST);
		$status_val =	$_POST['status_val'];
		$u_id = $_POST['user_id'];
		
		if($status_val ==0 )
		{
				$is_active ='1';
		}
		else if($status_val ==1)
		{
			$is_active ='0';
		}
		    //$u_id = $this->uri->segment(4);
			$this->CustomerModel->user_status($u_id,$is_active);
	}
	
	public function addnewcustomer(){
		if($this->uri->segment(4))
				{
					$this->data['temp_user_id'] = $this->uri->segment(4);
				}
		$this->data['user_role_list'] = $this->CustomerModel->user_role_list();
	   $this->data['countries_list'] = $this->common_model->countries_list();

		$this->middle = 'customer/addcustomer';
		$this->layout();
	   
		
	}
	
	public function useraddress(){	
		$data = array('content' => 'customer/useraddress');
		$this->load->view('layout', $data);
	}
	
	public function adduser(){
		//print_r($_POST);
		$first_name = $this->input->post('first_name');
		$middle_name = $this->input->post('middle_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$pass = $this->input->post('pass');
		$status = 1;
		$ary = array_filter($_POST);
		$ary['created_on'] = date('Y-m-d H:i:s');
		$id = $this->CustomerModel->add($ary);
		redirect("admin/customer/addnewcustomer/$id");
	}

	public function edit(){
		
	    $id = $this->input->get('id', TRUE);
	    $this->data['countries_list'] = $this->common_model->countries_list();
		$this->data['user_role_list'] = $this->CustomerModel->user_role_list();
		$this->data['user_edit_data'] = $this->CustomerModel->edit_user($id);
		
		//print_r($this->data['user_edit_data']);
		$this->middle = 'customer/edit';
		$this->layout();
		//print_r($result);
		//$this->load->view('layout',$data,array($result));
	}
	public function update_user()
	{

		$ary = array_filter($_POST);
		$ary['updated_on'] = date('Y-m-d H:i:s');
		$this->CustomerModel->update_user($ary);
		redirect('admin/customer');
	}
	
	public function update_password()
	{

		$u_id = $this->input->post('user_id');
		$n_pwd = $this->input->post('password');
		$this->CustomerModel->update_pwd($u_id , $n_pwd);
		redirect('admin/customer');
	}

	 public function update_user_address()
	 {

	 	$ary	= array_filter($_POST);
		$this->CustomerModel->update_personal_info($ary);
		redirect('admin/customer');
	 }
	
	
	
	
	
}	
	
	
?>