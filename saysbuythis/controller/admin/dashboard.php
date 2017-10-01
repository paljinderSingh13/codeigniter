<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller{


    public function __construct(){	
		parent::__construct();
		$this->load->helper('url');	
		$this->load->library('session');


	}
	
	
	public function index(){
		$this->middle = 'dashboard'; // passing middle to function. change this for different views.
		$this->layout();
		
	}




}



?>