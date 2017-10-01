<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends MY_Controller{
	

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
	    $this->load->library('session');
	    $this->datetime = date("Y-m-d H:i:s");
		if(empty($this->session->userdata('user_id'))){
			redirect('admin/login/logout');
		}
		$this->load->model('backend/category_product_model');
		$this->load->model('backend/ProductModel');
		$this->load->helper(array('form', 'url'));
	}
	
	public function index(){
	
		//$this->data['row'] = $this->ProductModel->productList();
		//$this->output->set_content_type('application/json');
		//$this->output->set_output(json_encode($data));
		//echo json_encode($this->data);
		//print_r($this->data); 
		$this->middle = 'products/view';
		$this->layout();

	}
	public function media()
	{   
		$config['upload_path'] = 'catalog/product/large/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '0';
		$config['max_width']  = '0';
		$config['max_height']  = '0';

		$this->load->library('upload', $config);
	if (!$this->upload->do_upload())
		{
			
			$error = array('error' => $this->upload->display_errors());
			// print_r($error);
			//$this->middle = 'products/edit';
			//$this->layout();
		}
		else
		{
			//$data = array('upload_data' => $this->upload->data());
					    
					$upload_data = $this->upload->data();
					//print_r($upload_data);
					$thumb_img	=		'thumb_'.$upload_data['file_name'];
					$medium_img	=		'medium_'.$upload_data['file_name'];
					$small_img	=		'small_'.$upload_data['file_name'];
					$image_config["image_library"] = "gd2";
					$image_config["source_image"] = $upload_data["full_path"];
					$image_config['create_thumb'] = FALSE;
					$image_config['maintain_ratio'] = FALSE;
					$image_config['new_image'] ="catalog/product/thumb/$thumb_img"; //$upload_data["file_path"].''.$new_img;
					$image_config['quality'] = "100%";
					$image_config['width'] = 180;
					$image_config['height'] = 180;
					$dim = (intval($upload_data["image_width"]) / intval($upload_data["image_height"])) - ($image_config['width'] / $image_config['height']);
					$image_config['master_dim'] = ($dim > 0)? "height" : "width";
					 
					$this->load->library('image_lib');
					$this->image_lib->initialize($image_config);
 
						if(!$this->image_lib->resize()){ 
						//echo "not resize img";
							}else{
							$data['thumb_image']  =	$thumb_img;
						
						}

					$image_config['new_image'] ="catalog/product/medium/$medium_img"; //$upload_data["file_path"].''.$new_img;
					$image_config['create_thumb'] = FALSE;
					$image_config['width'] = 420;
					$image_config['height'] = 420;
					$dim = (intval($upload_data["image_width"]) / intval($upload_data["image_height"])) - ($image_config['width'] / $image_config['height']);
					$image_config['master_dim'] = ($dim > 0)? "height" : "width";
						$this->image_lib->initialize($image_config);
 
						if(!$this->image_lib->resize()){ 
						//echo "not resize medium img";
						//Resize image
						   // redirect("errorhandler"); //If error, redirect to an error page
						}else{
							$data['medium_image']  =	$medium_img;
							//echo "resize medium img";
						}

					// $image_config['new_image'] ="catalog/product/small/$small_img"; //$upload_data["file_path"].''.$new_img;
					// $image_config['create_thumb'] = FALSE;
					// $image_config['width'] = 204;
					// $image_config['height'] = 204;
					// $dim = (intval($upload_data["image_width"]) / intval($upload_data["image_height"])) - ($image_config['width'] / $image_config['height']);
					// $image_config['master_dim'] = ($dim > 0)? "height" : "width";
					// 	$this->image_lib->initialize($image_config);
 
					// 	if(!$this->image_lib->resize()){ 
					// 	//echo "not resize medium img";
					// 	//Resize image
					// 	   // redirect("errorhandler"); //If error, redirect to an error page
					// 	}else{
					// 		$data['small_image']  =	$small_img;
					// 		//echo "resize medium img";
					// 	}

						$data['product_id']        = $this->input->get('id');
						$data['product_url']       = $upload_data['raw_name'];
					    $data['large_image'] 	   = $upload_data['file_name'];
					    $data['is_active']  	   = '1';

					     
						$this->ProductModel->media($data);
			redirect('admin/products');
		}
	}
	public function partial_product_list()
	{
		//echo "<pre>";
		$data['row'] = $this->ProductModel->productList();
		//print_r($data); die;
		$this->load->view('admin/products/partial_product_list',$data);

	}
	public function editProduct()
	{	
		if($this->uri->segment(4))
		{
			 $this->data['t_product_id'] = $this->uri->segment(4);
				$p_id =  $this->data['t_product_id'];
		}
		else{
				$p_id = 	$this->input->get('id');
		}
		$categories  = $this->category_product_model->category_list();
$result = array();
				foreach ($categories as  $value) {

					//print_r($value);
					if($value['pid'] && array_key_exists('pid',$value ) )
					{
						$result[$value['pid']]['pid'] = $value['pid'];
						$result[$value['pid']]['p_name'] = $value['pname'];
						$result[$value['pid']]['p_count'] =  $this->category_product_model->product_count_category($value['pid']);
						$result[$value['pid']]['p_select_status'] =$this->category_product_model->check_product_category_select($value['pid'], $p_id );		


						$result[$value['pid']]['subid'][] = $value['subid'];
						$result[$value['pid']]['subname'][] = $value['subname'];
						$result[$value['pid']]['sub_count'][] = $this->category_product_model->product_count_category($value['subid']);
						$result[$value['pid']]['sub_select_status'][] =$this->category_product_model->check_product_category_select($value['subid'], $p_id );		

					} 
					# code...
				}




				//print_r($cat);
				
				// $count =  count($cat['cat_list']);
				// for($i=0; $i<$count; $i++ )
				// {
				// 	$cat_id = $cat['cat_list'][$i]['category_id'];
				// 	$num_pro = $this->category_product_model->product_count_category($cat_id);
				// 	$cat['cat_list'][$i]['num_pro'] = $num_pro;	

				// 					//$product_id	 = $data['row'][$i]['product_id'];
				// $cat['cat_list'][$i]['select_status'] =$this->category_product_model->check_product_category_select($cat_id, $p_id );		
				// }
				//print_r($cat); die;
				$this->data['cat_list'] = $result;//$cat['cat_list'];

		$this->data['product_type_list'] = $this->ProductModel->product_type_list();
		//echo "<pre>";
		//print_r($this->data['product_type_list']); die;
	
		$this->data['product_row'] = $this->ProductModel->edit($p_id);
		//echo "<pre>";
		//print_r($this->data); die;
		$this->middle = 'products/edit';
		$this->layout();

	}
	public function addproduct(){
		
		$this->data['product_type_list'] = $this->ProductModel->product_type_list();
		$this->middle = 'products/addproduct';
		$this->layout();
		//$this->load->view('admin/header');
		//$this->load->view('admin/products/addproduct');
		//$this->load->view('admin/footer');
			
	}
	
	public function addnewproduct(){
		//print_r($_POST);
		$pro_nam = $this->input->post('product_name');
		$url = str_replace(' ', '-', $pro_nam);
		$pro_url = strtolower($url); 
		$from_date = $this->input->post('from_date');
		//date("Y-m-d H:i:s");
		//echo $from_d = date_format($from_date,"Y-m-d H:i:s");
		 $frm_date =  date_create($from_date);//new DateTime($d);// $this->input->post('from_date');
		 $fr_d =  date_format($frm_date, 'Y-m-d H:i:s');

		 $to  = $this->input->post('to_date');
		 $to_date =  date_create($to);//new DateTime($d);// $this->input->post('from_date');
		 $to_d =  date_format($to_date, 'Y-m-d H:i:s');
		
		$data = array('product_name' => $this->input->post('product_name'),
		'product_type_id' => $this->input->post('product_type'),
		'product_description'		 => $this->input->post('description'), 
		'product_short_description'	 => $this->input->post('short_description'), 
		'sku'	 					 => $this->input->post('sku'), 
		'weight'	 				 => $this->input->post('weight'), 
		'new_from_date'				 => $fr_d,
		'new_to_date'				 => $to_d,
		'is_featured'				 => $this->input->post('is_featured'),
		'is_active'	 				 => $this->input->post('is_active'),
		'product_url'				 => $pro_url,
		'created_on'				=> date('Y-m-d H:i:s')
		);
		
		$response = $this->ProductModel->add($data);
		if($response)
		{   redirect("admin/products/editProduct/$response");
			//redirect('')
		}
		else{ echo "not Insert product";}

		$this->session->set_flashdata('success', 'You added a new product');
	}

	public function update()
	{
		//print_r($_POST);
		$id	 = $this->input->get('id');
		$pro_nam = $this->input->post('product_name');
		$url = str_replace(' ', '-', $pro_nam);
		$pro_url = strtolower($url);
		$d =	$this->input->post('from_date');
		$from_date =  date_create($d);//new DateTime($d);// $this->input->post('from_date');
		 $from_d =  date_format($from_date, 'Y-m-d H:i:s'); 
 		$to  = $this->input->post('to_date');
		 $to_date =  date_create($to);//new DateTime($d);// $this->input->post('from_date');
		 $to_d =  date_format($from_date, 'Y-m-d H:i:s');

		$data = array('product_name' => $this->input->post('product_name'),
		'product_type_id' => $this->input->post('product_type_id'),
		'product_description'		 => $this->input->post('product_description'), 
		'product_short_description'	 => $this->input->post('product_short_description'), 
		'sku'	 					 => $this->input->post('sku'), 
		'weight'	 				 => $this->input->post('weight'), 
		'new_from_date'				 => $from_d,//$this->input->post('from_date'),
		'new_to_date'				 => $to_d,
		'is_featured'				 => $this->input->post('is_featured'),
		'is_active'	 				 => $this->input->post('is_active'),
		'product_url'				 => $pro_url,
		'updated_on'				 => date('Y-m-d H:i:s')	
		);
	 	$this->ProductModel->update($data,$id);
		redirect('admin/products');
	}
	public function deletePro()
	{
		$id	 = $this->input->get('id');
		$this->ProductModel->disable_pro($id);
		redirect('admin/products');

	}
	public function restore()
	{
			echo $id	 = $this->input->get('id');
		$this->ProductModel->restore_pro($id);
		redirect('admin/products');

	}

	public function price()
	{	
		//echo "<pre>";
		 $this->input->get('id');
		$data = array_filter($_POST);
		// print_r($data); 
		 $product_price_id = $this->input->post('product_price_id');
		 if($product_price_id)
		 {
		 	$this->ProductModel->update_price($data,$product_price_id);
		 }
		 else{
			$this->ProductModel->insert_price($data);
			}

		redirect('admin/products');
		// Array ( [price] => 1212 [special_price] => 1212 [special_price_start_date] => 0000-00-00 00:00:00 [special_price_end_date] => 0000-00-00 00:00:00 [discount_type] => 121 [discount_value] => 1212 ) 

	}

	public function product_category()
	{
		//Array ( [product_id] => 3 [cat_id] => Array ( [0] => 4 [1] => 5 [2] => 7 [3] => 8 ) ) 
		print_r($_POST);
		
		
		
		echo $product_id = $_POST['product_id'];
		$un_chk_ary = array_slice(array_filter($_POST['un_checked_cat']),0);
		 $un_chk_size = count($un_chk_ary);
				for($j=0; $j< $un_chk_size; $j++)
				{
						$cat_id = $un_chk_ary[$j];
						$this->category_product_model->del_pro_from_cat($cat_id,$product_id);

				}
				
			 $size = count($_POST['cat_id']);
			 for($i=0; $i<$size; $i++)
			 {
				 echo $cat_id = $_POST['cat_id'][$i];
				$this->category_product_model->product_category($product_id,$cat_id);	
				
			 	
			}
			redirect('admin/products');
	}



	
}


?>