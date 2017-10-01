
<div class="wrapper">
        <div class="page">
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<div class="main-container col1-layout">
            	
            <div class="container">
		
			
            <div class="contain-size">
                                <div class="main">
                    <div class="main-inner">
                      
                        <div class="col-main">
                            <div class="account-login">
                              

                                    

                                    <?php //print_r($api_data); 

            foreach($api_data->Items as $val)
            {
                //echo "mmore".$val->MoreSearchResultsUrl."<br>";

                $mor = file_get_contents($val->MoreSearchResultsUrl);

              //  print_r($mor);

                //
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





                                    ?>



                               



    
                            </div>

                        </div>
                        
                    </div>
                </div>
                
            </div>
            </div>
            
        </div>
        
    </div>

    

</div>


