<?php 

class Product_setting extends MY_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
	    $this->load->library('session');
		if(empty($this->session->userdata('user_id'))){
			redirect('admin/login/logout');
		}
		$this->load->model('backend/setting_model');
		$this->load->helper(array('form', 'url'));
	}
	
public function index()
{
$this->product_display_setting();

}

public function product_display_setting()
{
	//echo "product_display_setting";
	$setting_row =	$this->setting_model->get_product_setting_val();
	$this->data['pro_display_setting_val'] = $setting_row['featured_or_recommed'];

	$this->middle='products/setting';
	$this->layout();
}

public function product_display_action()
{
	print_r($_POST);

	$val =	$_POST['featured_or_recommed'];
	$this->setting_model->product_display_setting($val);
			
}



}

?>