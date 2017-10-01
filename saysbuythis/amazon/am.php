<form method="Post">
	Search <input type="text" name="keywords" > <br>
	<input name="sub" type="submit" value="search" >
</form>


<?php
if(isset($_POST['sub']))
{
	
	print_r($_POST);
}
// Your AWS Access Key ID, as taken from the AWS Your Account page
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

echo "Signed URL: \"".$request_url."\"";

$response = file_get_contents($request_url);
$parsed_xml = simplexml_load_string($response);

echo "<pre>";
//print_r($parsed_xml->Items);

foreach($parsed_xml->Items as $val)
{
	echo "mmore".$val->MoreSearchResultsUrl."<br>";
	echo  "<a href='".$val->MoreSearchResultsUrl."'>More Result</a>";
	
	foreach($val->Item as $items )
	{
		echo $items->ASIN;
		echo "<br>".$items->SmallImage->URL;
		if($items->SmallImage->URL)
		{
		echo "small imag <img src='".$items->SmallImage->URL."' >";
		}else{
			echo "No Image";
		}
		//print_r($items);
	}
	//print_r($val);
}
//printSearchResults($parsed_xml, $SearchIndex);

?>