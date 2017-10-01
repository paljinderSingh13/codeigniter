<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class IndexController extends MY_Controller {

 
	public function __construct(){		
	  parent::__construct();
	  	$this->load->model('front/product');

        //$this->load->library(array('form_validation','email','auth'));
		//$this->load->helper(array('inflector','html','url','aw_helper'));	  
	}	

	public function amazon_search()
	{		
			print_r($_POST);

			$aws_access_key_id = "AKIAJNWETRZYNR4L7LZA";
		// Your AWS Secret Key corresponding to the above ID, as taken from the AWS Your Account page
		$aws_secret_key = "qVJBSMtwVoGLW2HkGl6B9YAatFxp0rScjmP9E1tX";
 		// The region you are interested in
		$endpoint = "webservices.amazon.com";

		$uri = "/onca/xml";

		

		$params = array(
		    "Service" => "AWSECommerceService",
		    "Operation" => "ItemSearch",
		    "AWSAccessKeyId" => "AKIAJNWETRZYNR4L7LZA",
		    "AssociateTag" => "justinsaysbuy-20",
		    "SearchIndex" => "All",
		    "ResponseGroup" => "Images,ItemAttributes,Large,Reviews,SalesRank",
		    "Keywords" => "refined oil",
			
		);

			if(isset($_POST['keyword']))
			{
				$params['Keywords'] = $_POST['keyword'];
				
			}

			// Set current timestamp if not set
			if (!isset($params["Timestamp"])) {
			    $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
			}

			// Sort the parameters by key
			ksort($params);

			$pairs = array();

			foreach ($params as $key => $value) {
			    array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
			}

			// Generate the canonical query
			$canonical_query_string = join("&", $pairs);

			// Generate the string to be signed
			$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

			// Generate the signature required by the Product Advertising API
			$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $aws_secret_key, true));

			// Generate the signed URL
			$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

			//echo "Signed URL: \"".$request_url."\"";

			$response = file_get_contents($request_url);
			$parsed_xml = simplexml_load_string($response);


			$this->data['api_data'] = $parsed_xml;


		    $this->middle = 'amazon_search';
		    $this->front_layout();


	}
	public function amazon()
	{
		$aws_access_key_id = "AKIAJNWETRZYNR4L7LZA";
		// Your AWS Secret Key corresponding to the above ID, as taken from the AWS Your Account page
		$aws_secret_key = "qVJBSMtwVoGLW2HkGl6B9YAatFxp0rScjmP9E1tX";
 		// The region you are interested in
		$endpoint = "webservices.amazon.com";

		$uri = "/onca/xml";

		$params = array(
		    "Service" => "AWSECommerceService",
		    "Operation" => "ItemSearch",
		    "AWSAccessKeyId" => "AKIAJNWETRZYNR4L7LZA",
		    "AssociateTag" => "justinsaysbuy-20",
		    "SearchIndex" => "Grocery",
		    "ResponseGroup" => "Images,ItemAttributes,Large,Reviews,SalesRank",
		    "Sort" => "salesrank",
		    "Keywords" => "refined oil",
			"Availability" => "Available",
			"ItemPage" => "10"
		);

			if(isset($_POST['keywords']))
			{
				$params['Keywords'] = $_POST['keywords'];
				
			}

			// Set current timestamp if not set
			if (!isset($params["Timestamp"])) {
			    $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
			}

			// Sort the parameters by key
			ksort($params);

			$pairs = array();

			foreach ($params as $key => $value) {
			    array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
			}

			// Generate the canonical query
			$canonical_query_string = join("&", $pairs);

			// Generate the string to be signed
			$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

			// Generate the signature required by the Product Advertising API
			$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $aws_secret_key, true));

			// Generate the signed URL
			$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

			//echo "Signed URL: \"".$request_url."\"";

			$response = file_get_contents($request_url);
			$parsed_xml = simplexml_load_string($response);

			//echo "<pre>";
			//print_r($parsed_xml->Items);

			foreach($parsed_xml->Items as $val)
			{
				//echo "mmore".$val->MoreSearchResultsUrl."<br>";

				$mor = file_get_contents($val->MoreSearchResultsUrl);

				print_r($mor);

				echo  "<a href='".$val->MoreSearchResultsUrl."'>More Result</a>";
				
				foreach($val->Item as $items )
				{
					echo "ASIN : ".$items->ASIN."<br>";
					//echo "<br>".$items->SmallImage->URL;
					if($items->SmallImage->URL)
					{
					echo " imag <img src='".$items->SmallImage->URL."' >";
					}else{
						echo "No Image";
					}
					//print_r($items);
				}
				//print_r($val);
			}

	}
	
	public function index(){
		$this->load->model('backend/setting_model');
		//print_r($this->session);
		//$data = $this->product->high_rating();
		//echo $data['product_id'];
		//$this->data['rating_pro_id'] =   $data['product_id'];
			$setting_row =  $this->setting_model->get_product_setting_val();
			 $this->data['pro_display_setting_val'] = $setting_row['featured_or_recommed'];

		
				if($this->session->back_url_pro_id && $this->session->customer_id )
					{
						$data =	array( 
							'product_id'=> $this->session->back_url_pro_id, 
							'customer_id'=> $this->session->customer_id,
						    'product_price' =>$this->session->back_url_pro_price,
						    'is_followed'=> '1'
						 );
							$msg = $this->product->follow($data);
							$this->session->unset_userdata('back_url_pro_id');
							$this->session->unset_userdata('back_url_pro_price');
							if($msg){
							$pro_name =	$this->session->back_url_pro_name;
							$new_pro_name = str_replace('%20', ' ', $pro_name);
							 $this->session->set_flashdata('back_url_msg', 'You have been followed the '.$new_pro_name.' Product');

								
					 	    }
							

					}

					

		$data['products'] = $this->product->featured_product();
		$size =  count($data['products']);
		$total_user = $this->Authentication->total_customer(2);
		//if(@$this->session->customer_id)
		//{
			for($i=0; $i< $size; $i++)
			{ 

				$product_id = $data['products'][$i]['product_id'];
				
				$count_follower = $this->product->total_follower($product_id);
				$pecentage_follwer = $count_follower/$total_user;
				$pecentage = $pecentage_follwer * 100;
				
					//print_r($recommeded_row);
					//echo $recommeded_row['is_recommend'];
				$total_recommeded = $this->product->total_recommeded($product_id);
				$pecentage_recommeded = $total_recommeded/$total_user*100;
//recommed rating 				
				$recomd_count_rate =   $this->product->rating_by_recomd($product_id);

				
				$data['products'][$i]['pecentage_follwer'] = $pecentage; 
				$data['products'][$i]['total_user'] = $total_user;
				$data['products'][$i]['count_follower'] = $count_follower;
				$data['products'][$i]['total_recommeded'] = $total_recommeded;
				$data['products'][$i]['pecentage_recommeded'] = $pecentage_recommeded;
				$data['products'][$i]['recomd_count_rate'] = $recomd_count_rate;
				if(@$this->session->customer_id)
					{
						$row = $this->product->customer_follow($product_id);
						$is_followed = $row['is_followed'];
						$data['products'][$i]['is_followed'] = $is_followed;

						$recommeded_row = $this->product->customer_recommeded($product_id);
						$data['products'][$i]['is_recommend'] = $recommeded_row['is_recommend'];


					}						
			}
				// 	$recomm = array();
				// foreach ($data['products'] as $key => $value) {
					
				// $recomm[$key] = $value['recomd_count_rate'];


				// }

				//  array_multisort($recomm, SORT_DESC, $data['products']);

				

		//}
		// else{
		// 	for($i=0; $i< $size; $i++)
		// 	{ 
		// 		$product_id = $data['products'][$i]['product_id'];
		// 		//$row = $this->product->customer_follow($product_id);
		// 		$count_follower = $this->product->total_follower($product_id);
		// 		$pecentage_follwer = $count_follower/$total_user;
		// 		$pecentage = $pecentage_follwer * 100;
		// 		//$is_followed = $row['is_followed'];
		// 		//$data['products'][$i]['is_followed'] = $is_followed;
		// 		$data['products'][$i]['pecentage_follwer'] = $pecentage; 
		// 		$data['products'][$i]['total_user'] = $total_user;
		// 		$data['products'][$i]['count_follower'] = $count_follower;
		// 	}

		//}
		
  	//echo "<pre>";
	 //print_r($data['products']);
	// $new_array = array_multisort($data['products']['recomd_count_rate'], SORT_DESC, $data['products']);
	//  	print_r($new_array);

	 	//die;// array_multisort($price, SORT_DESC, $inventory);
		//$this->data['high_light'] = $this->product->high_light_product();
	 	//$h_product_id =  $this->data['high_light']['product_id'];
		//$h_row = $this->product->customer_follow($h_product_id);
		//$h_total_follower =  $this->product->total_follower($h_product_id);
		//$this->data['high_light']['h_is_follow'] = $h_row['is_followed'];
		//$this->data['high_light']['h_total_follow'] = $h_total_follower;
	//echo "<pre>";
	//print_r($h_row);
		//print_r($this->data['high_light']);
	
		$this->data['products'] = $data; 

		$this->middle='featured-product';
		$this->front_layout();
	}
	
	public function high_rating()
	{
		/*echo "<pre>";
	$data['aa'] = $this->product->rating_by_recomd(4);
		//$data = $this->product->high_rating();
     print_r($data);*/
	}
	public function my_collection()
	{


		$customer_name =   $this->uri->segment(1); 
		

		   $data['my_collection'] =	$this->product->my_collection($customer_name);
		   //	echo "<pre>";
			//print_r($data['my_collection']); die;
           $size =  count($data['my_collection']);
		    
			$total_user = $this->Authentication->total_customer(2);
			for($i=0; $i< $size; $i++)
			{ 
				$product_id = $data['my_collection'][$i]['product_id'];
				$count_follower = $this->product->total_follower($product_id);
				$pecentage_follwer = $count_follower/$total_user;
				$pecentage = $pecentage_follwer * 100;
				$recommeded_row = $this->product->customer_recommeded($product_id);
				$total_recommeded = $this->product->total_recommeded($product_id);
				$pecentage_recommeded = $total_recommeded/$total_user*100;
				//$pecentage_recommeded = $total_recommeded/$total_user;


					if($this->session->customer_username != $customer_name)
			 		{ 

			 		 $row = $this->product->customer_follow($product_id);
					 $is_followed = $row['is_followed'];
			 		 $data['my_collection'][$i]['customer_follwer'] = $is_followed;
					}
				$data['my_collection'][$i]['pecentage_follwer'] = $pecentage; 
				$data['my_collection'][$i]['total_user'] = $total_user;
				$data['my_collection'][$i]['count_follower'] = $count_follower;
				$data['my_collection'][$i]['is_recommend'] = $recommeded_row['is_recommend'];
				$data['my_collection'][$i]['total_recommeded'] = $total_recommeded;
				$data['my_collection'][$i]['pecentage_recommeded'] = $pecentage_recommeded;


		
			}


			$this->data['my_collection'] =	$data['my_collection'];
			//echo "<pre>";
			//print_r($this->data['my_collection']);

			$this->middle = 'myCollection';
		    $this->front_layout();
	}
	public function back_url_track()
	{
 			$pro_id = $this->uri->segment(3);
 			$pro_price = $this->uri->segment(4);
 			$pro_name = $this->uri->segment(5);
 			$this->session->set_userdata('back_url_pro_id',$pro_id);
 			$this->session->set_userdata('back_url_pro_price',$pro_price);
 			$this->session->set_userdata('back_url_pro_name',$pro_name);
 			$this->session->back_url_pro_id;
			redirect('auth/login');	
	}
	public function follow_product()
	{
		
	$data =	array( 	'product_id'=> $_POST['product_id'], 
					'customer_id'=> $_POST['customer_id'],
				    'product_price' =>$_POST['pro_price'],
				     'is_followed'=> '1'
				 );
	$pro_name = $_POST['pro_name'];
		$msg = $this->product->follow($data);
		if($msg){
			echo $msg;
			$this->session->set_flashdata('pro_follow_msg', 'You have been followed the '.$pro_name.' Product');

 	 
 	    }
 	}
 	    public function un_follow_product()
	{
		
		$data =	array( 	'product_id'=> $_POST['product_id'], 
						'customer_id'=> $_POST['customer_id'],
					    'product_price' =>$_POST['pro_price'],
					     'is_followed'=> '0'
					 );
			$msg = $this->product->un_follow($data);
			if($msg){
				 echo $msg;
				 $pro_name = $_POST['pro_name'];
				$this->session->set_flashdata('pro_unfollow_msg', 'You have been  un follow the '.$pro_name.' Product');

	 	    }
	}
	
	
	public function recommed()
	{
		//print_r($_POST);
		$data = array( 
			'customer_id'=>$_POST['customer_id'] ,
		 	'product_id'=> $_POST['product_id'],
		    'is_recommend' =>'1'
			);
		 $pro_name  = $_POST['pro_name'];

	$response =	$this->product->recommed($data);
	if($response)
	{
		 echo $response;
	$this->session->set_flashdata('pro_recommed_msg', 'You have been  recommeded the '.$pro_name.' Product');

		//echo "inserted ";
	}

	}
		
}
?>