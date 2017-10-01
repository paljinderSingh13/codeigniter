<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
	
	public function __construct(){	
	 parent::__construct();		
	   $this->load->helper('url');
	   $this->load->library('session');
	   $this->load->model('backend/Adminlogin');

	}
	
	public function index(){	
	 if(!empty($this->session->userdata('user_id'))){
		 redirect('admin/dashboard');
	   }
		$this->load->view('admin/login');
	}
	
	public function signIn(){	

	$user = $this->input->post('username');
	$pass = $this->input->post('password');
	$data = array('username'=>$user,'password'=>$pass);
	$result = $this->Adminlogin->check_user($data);
	
	 if(!empty($result)){
		//print_r($result);
		$user_id = $result[0]->user_id;
		$username = $result[0]->username;
		$userdata = array('user_id' => $user_id,'username' => $username);
		$this->session->set_userdata($userdata);
		redirect('admin/dashboard');	
	  }else{
		redirect('admin/login');
	  }

	}
	
	function logout(){
	  $this->session->sess_destroy();
	  $this->index();
	}
	
	
	










	
}




?>