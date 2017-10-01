<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller{
	
	
	public function __construct(){
		parent::__construct();
	    $this->load->model('backend/CategoryModel');
		if(empty($this->session->userdata('user_id'))){
			redirect('admin/login/logout');
		}
	}
	
	public function index(){
		$this->data['catlist'] = $this->CategoryModel->getCatList();
		$this->middle = 'category/view';
		$this->layout();
/* 		
		$this->load->view('admin/header');
		$this->load->view('admin/category/view',$data);
		$this->load->view('admin/footer'); */
	}
	
	public function addcategory(){
		
		$this->load->view('admin/header');
		$this->load->view('admin/category/addcategory');
		$this->load->view('admin/footer');
		//$data = array('content' => 'category/addcategory');
		//$this->load->view('layout', $data);	
	}
	
	public function addnewcat(){
		 $cat_name         = $this->input->post('cat_name');
		 $is_active        = $this->input->post('is_active');
		 $description      = $this->input->post('description');
		 $category_img     = $this->input->post('category_img');
		 $meta_keyword     = $this->input->post('meta_keyword');
		 $meta_description = $this->input->post('meta_description');
		 $ptCategory = $this->input->post('parent_id');
		 $is_nav = $this->input->post('is_nav');
		$data = array('cat_name' => $cat_name,	
		'is_active' => $is_active,
		'description' => $description,
		'category_img' => $category_img,
		'meta_keyword' => $meta_keyword,
		'parent_id' => $ptCategory,
		'meta_description' => $meta_description,
		'is_nav' => $is_nav,
		);
		
		$this->CategoryModel->AddCategory($data);
	}
	
	
	// public function deleteCat(){
	// 	$id = $this->input->get('id',TRUE);
	// 	$this->CategoryModel->row_delete($id);
	// }
	
	public function getAjaxdata(){
		
		 // $is_active = $this->input->post('isactive',true);
		  $data['catobj'] = $this->CategoryModel->filterData();
		  $this->load->view('admin/category/ajaxCategoryList',$data);
		  //print_r($data);

		 // echo json_encode($query);
		
	}
	public function restore()
	{
		 $id = $this->input->post('id');
		 $this->CategoryModel->restore($id);
	}
	public function deleteCat()
	{
		 $id = $this->input->post('id');
		 $this->CategoryModel->deleteCat($id);
	}

	
	public function EditCategory(){
		$cat_ID = $this->input->get('cat_id');
		$this->data['cat_details'] = $this->CategoryModel->Edit($cat_ID);
		$this->middle ='category/edit';
		$this->layout();
		//print_r($data);

		// $this->load->view('admin/header');
		// $this->load->view('admin/category/edit',$data);
		// $this->load->view('admin/footer');
	 		
	}
	
	public function updateCategory(){

		
		 $cid               = $this->input->post('cid');
		 $cat_name         = $this->input->post('cat_name');
		 $is_active        = $this->input->post('is_active');
		 $description      = $this->input->post('description');
		 $category_img     = $this->input->post('category_img');
		 $meta_keyword     = $this->input->post('meta_keyword');
		 $meta_description = $this->input->post('meta_description');
		 $parent_id = $this->input->post('parent_id');
		  $is_nav = $this->input->post('is_nav');
		 $data = array('cid'	=> $cid,
		 'cat_name' => $cat_name,	
		 'is_active' => $is_active,
		 'description' => $description,
		 'category_img' => $category_img,
		 'meta_keyword' => $meta_keyword,
		 'parent_id' => $parent_id,
		 'meta_description' => $meta_description,
		 'is_nav' => $is_nav,
		 );
		
		$this->CategoryModel->Update($data);
		
	}
	
	
	public function subcategory(){	
	 $parent_cat['parent_cat'] = $this->input->get('cat_id');
	 $this->load->view('admin/header');
	 $this->load->view('admin/category/subcategory', $parent_cat);
	 $this->load->view('admin/footer');
	 	
	}

	public function addsubcat(){
		//print_r($_POST);
	  $data = array('parent_id'=> $this->input->post('parent_id'), 
	  'cat_name' => $this->input->post('cat_name'),
	  'is_active' => $this->input->post('is_active'),
	  'description' => $this->input->post('description'),
	  'category_img' => $this->input->post('category_img'),
	  'meta_keyword' => $this->input->post('meta_keyword'),
	  'meta_description' => $this->input->post('meta_description'),
	  'is_nav' => $this->input->post('is_nav')	  
	  );	
	  
	  $this->CategoryModel->AddSubCategory($data);
	}
	
	// public function restore(){
		
	//    $catid =	$this->input->get("id");
	//    //print_r($catid);
	//    $this->CategoryModel->restore_Cat($catid);
	// }







}


?>