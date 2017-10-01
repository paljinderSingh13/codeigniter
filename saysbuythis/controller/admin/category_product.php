<?php 
class Category_product extends MY_Controller
{

		public function __construct()
		{
			parent::__construct();
			$this->load->model('backend/category_product_model');	
			$this->load->model('backend/ProductModel');
		}	

		public function index()
		{

			    //$this->data['pro_list'] = $this->ProductModel->productList();
				//echo "<pre>";
				$categories  = $this->category_product_model->category_list();
				//print_r($categories);
					$result = array();
				foreach ($categories as  $value) {

					//print_r($value);
					if($value['pid'] && array_key_exists('pid',$value ) )
					{
						$result[$value['pid']]['pid'] = $value['pid'];
						$result[$value['pid']]['p_name'] = $value['pname'];
						$result[$value['pid']]['p_count'] =  $this->category_product_model->product_count_category($value['pid']);
						$result[$value['pid']]['subid'][] = $value['subid'];
						$result[$value['pid']]['subname'][] = $value['subname'];
						$result[$value['pid']]['sub_count'][] = $this->category_product_model->product_count_category($value['subid']);
					} 
					# code...
				}

				//print_r($result);
				// foreach ($result as  $value) {
				// 			//print_r($value);
				// 			echo $value['p_name'];
				// 			 $size = count($value['subid']);
				// 						for($i=0; $i<$size; $i++ )
				// 						{
				// 							// echo $value['subid'][$i];
				// 							  echo '<br>'.$value['subname'][$i];

				// 						}	echo '<br>';				# code...
				// }
						
				// $count =  count($cat['cat_list']);
				// for($i=0; $i<$count; $i++ )
				// {
				// 	$cat_id = $cat['cat_list'][$i]['category_id'];
				// 	$num_pro = $this->category_product_model->product_count_category($cat_id);
				// 	$cat['cat_list'][$i]['num_pro'] = $num_pro;			
				// }
				//print_r($cat); die;
				$this->data['cat_list'] = $result;//$cat['cat_list'];
				$this->middle = 'category/category_product';
				$this->layout();

		}
		public function category_product_save()
		{	
				
				$cat_id = $_POST['cat_id'];
				$un_sel = array_filter($_POST['un_select']);
				$un_select  = array_slice($un_sel,0);
 				$un_sel_count = count($un_select);
 					for($j=0; $j<$un_sel_count; $j++)
 					{
 						$u_pro_id = $un_select[$j];
 					   $this->category_product_model->del_pro_from_cat($cat_id,$u_pro_id);
 					}
			 $size = count($_POST['checks']);
			 for($i=0; $i<$size; $i++)
			 {
				$pro_id = $_POST['checks'][$i];
				$this->category_product_model->category_product($cat_id,$pro_id);	
				
			}
				redirect('admin/category_product');
		}

		public function category_product_list()
		{
			$cat_id = $this->uri->segment(4);
			$data['list']=	$this->category_product_model->category_product_list($cat_id);
		 	echo json_encode($data['list']);
		 //print_r($data);
		}

		public function	search_product_list()
		{
			//$pro_name = $this->uri->segment(4);
				//print_r($_POST);
				$search_by 	= 	$_POST['search_by'];
    			$val   		=	$_POST['val'];
    			$cat_id   		=	$_POST['cat_id'];
			$data['row'] = $this->category_product_model->search_pro($search_by , $val);
			//echo "<pre>";
			$size =  count($data['row']);
			for($i=0; $i < $size; $i++ )
			{
				$product_id	 = $data['row'][$i]['product_id'];
				$data['row'][$i]['select_status'] =$this->category_product_model->check_product_category_select($cat_id, $product_id );
				
			}
			//print_r($data['row']);

			echo json_encode($data['row']);
			//$this->load->view('admin/products/partial_product_list',$data);

			
		}

		public function table()
		{
			$this->middle = 'category/test_table';
		  $this->layout();	
			//$this->load->view('table');
		}

		public function data_table()
		{
			//$this->middle = 'category/test_table';
		  //$this->layout();	
			$this->load->view('table');
		}
}

?>