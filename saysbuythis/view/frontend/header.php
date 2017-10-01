<?php defined('BASEPATH') OR exit('No direct script access allowed');
$base_url = $this->load->helper('path')->config->config['base_url'];
 //print_r($menu);


  global $nav;
 foreach ($menu as $value) {
//[pid] => 2 [p_name] => Clothes [p_count] => 1 [subid] => Array ( [0] => 5 [1] => 11 ) [subname] 
 $nav .='<li class="level0 nav-2 level-top parent">
<a href="#/clothes.html" class="level-top">
<span>'.$value['p_name'].'</span>
</a>
<ul class="level0">';

$sub_size = count($value['subid']);
 	 	for($i=0; $i <$sub_size; $i++ )
 	 	{

 	 	$nav .='<li class="level'.$i.' nav-2-1 first">
				<a href="#/clothes/women-s.html">
				<span>'.$value['subname'][$i].'</span>
				</a>
				</li>';
			}
 $nav .='</ul></li>';
 }

 
?>

<!Doctype>
<html>

<head>
<title>Says buy this</title>
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="<?php echo $base_url; ?>assets/frontend/css/circle.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/jquery.mmenu.all.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/bootstrap.min.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/bootstrap-responsive.min.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/styles-responsive.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/styles.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/style.css"  />

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/mmenu.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/fish_menu.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/font-awesome.css"  />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo $base_url; ?>assets/frontend/js/progress-circle.js"></script>
<script src="<?php echo $base_url; ?>assets/frontend/js/scroll.js"></script>

<script src="<?php echo $base_url; ?>assets/frontend/js/signup_validation.js"></script>

</head>

<body>

<div class="header-wrapper">
<div class="header-container">
    <div class="container">
    <div class="contain-size">
        <div class="header">

            <div class="toplink visible-desktop">
                <div class="row-fluid">
                    <div class="span6">
                        <div class="phone-number visible-desktop"><p><em class="icon-phone"></em> Call +110 123456</p></div>
                        <div class="currency-language">
                            
                         </div>
                    </div>
					<div class="span6">
						<!--p class="welcome-msg"> </p-->
						<ul class="links">
						<li class="first"><a href="<?php echo base_url('my_account'); ?>" title="My Account">My Account</a></li>
								<li><a href="#/wishlist/" title="Wishlist">Wishlist</a></li>
								<li><a href="#/checkout/cart/" title="My Cart" class="top-link-cart">My Cart</a></li>
								<li><a href="#/checkout/onepage" title="Checkout" class="top-link-checkout">Checkout</a></li>
								<?php if(@$this->session->customer_id)
								{ ?>
								<li class=" last"><a href="<?php echo base_url('auth/logout'); ?>" title="Log In">Log out</a></li>

								<?php }
								else{ ?>
								<li class=" last"><a href="<?php echo base_url('auth/login'); ?>" title="Log In">Log In</a></li>
									<?php } ?>
						</ul>
					</div>
                </div>                
            </div>

<div class="header-content hidden-desktop mheader mm-fixed-top">
	<div class="row-fluid">
			<a class="menu-button" href="<?php echo base_url('IndexController'); ?>"><i class="icon-reorder"></i></a>	
			<h1 class="logo"><a href="#/" title="Says buy this" class="logo">
			<img src="<?php echo $base_url; ?>assets/frontend/images/logo.png" alt="Says buy this"></a></h1>   		
			<div data-retina="true" class="icon-cart-big"><a class="cart-url" href="#/checkout/cart/"><span></span></a></div>   
			<a data-retina="true" class="icon-login-big" href="#/customer/account/login/" title="Account"></a> 							
	</div>
</div>
            

            <div class="header-content visible-desktop">
                <div class="row-fluid">

                
                   <div class="span4">
<h1 class="logo"><strong>Says buy this</strong><a href="<?php echo base_url(); ?>" title="Says buy this" class="logo"><img data-retina="true" src="<?php echo $base_url; ?>assets/frontend/images/logo.png" alt="Says buy this" ></a></h1>
                        
                   </div>

                

                    <div class="span4" style="float:right;">
						
                        <div class="quick-access">
                        	<div class="wishlist-big"><a data-retina="true" class="icon-wishlist-big" href="#/wishlist/" title="Wishlist"><span>Wishlist</span></a></div>
                            
 <div class="top-cart-wrapper">
                                    <div class="top-cart-contain">
                                        <div id="mini_cart_block">
    <div data-retina="true" class="icon-cart-big"><a class="cart-url" href="#/checkout/cart/"><span></span></a></div>
    <div class="block-cart mini_cart_ajax">
                <!--<span class="top-cart-icon"></span>-->
        <span class="top-cart-title">
            My Cart        </span>
        
        <div class="top-cart-content" style="display: none;">
            <span class="cart-arrow"></span>
            <div class="subtotal">
                <div class="l">
                    My Cart ( Items)
                </div>
                <div class="r">
                    <span class="price">$0.00</span>                </div>                        
            </div>

            <p class="empty">You have no items in your shopping cart.</p>
                        
             
                    </div>
    </div>
</div>
  </div>
  </div>
						
						<div class="" style="width:100px; text-align:center; float:left; margin-top:9px;">

						<?php
						  if(@$this->session->customer_id){ $url = $this->session->customer_username; } 
						  	else{$url = "auth/login"; }
						  ?>
						<a href="<?php echo base_url($url); ?>" id="mylist" custid="" class="account-links">
						<i class="fa fa-folder-open" style="font-size:24px; color: #EA5959;"></i><br>
						My Collection</a>
								 
						</div>
	
					
 <div class="account-big">
                                 
  <div class="login-big">
  	<?php 
  	  if(@$this->session->customer_id){ $param ="Logout"; $contr = 'logout'; }else{ $param ="Login"; $contr = 'login';} ?>
  		<a data-retina="true" class="icon-login-big" href='<?php echo base_url("auth/$contr"); ?>' title="Login" data-retina="true" ><span><?php echo $param ?></span></a>
  	<!-- <a title="My Account" href="http://nile.ingeniousonline.co.in/Projects/JustinLee/SaysBuyThis/Code/index.php/customer/account/" style="width:70px;" class="icon-login-big" data-retina="true"><span>My Account</span></a> -->

  	</div>
       <div class="account-fly login-fly" style="display: none;">
           <span class="arrow"></span>
           <div class="account-content">
                 <div class="row">                                      
                   <div class="span6">
                  <!-- POP LOGIN START FROM HERE -->                              
					<div class="block block-login">
						<div class="block-title">
							<strong><span>Login</span></strong>
						</div>
						<form action="#/customer/account/loginPost/" method="post">
						<input name="form_key" type="hidden" value="vgjIJuHrwZMzSoEp">
							<div class="block-content">
								<label for="mini-login">Email:</label><input type="text" name="login[username]" id="mini-login" class="input-text">
								<label for="mini-password">Password:</label><input type="password" name="login[password]" id="mini-password" class="input-text">
								<div class="actions">
									<button type="submit" class="button"><span><span>Login</span></span></button>
								</div>
							</div>
						</form>
					</div>
					<div class="account-content">
                                        <a href="http://nile.ingeniousonline.co.in/Projects/JustinLee/SaysBuyThis/Code/index.php/customer/account/" class="account-links profile">
                                            <div class="name">paljinder singh</div>
                                            <div class="sub-title">My Account</div>
                                        </a>
                                        <a class="account-links" href="http://nile.ingeniousonline.co.in/Projects/JustinLee/SaysBuyThis/Code/index.php/sales/order/history/">My Orders</a>
                                        <a class="account-links" href="http://nile.ingeniousonline.co.in/Projects/JustinLee/SaysBuyThis/Code/index.php/wishlist/">Wishlist</a>
										
                                        <a class="account-links" href="http://nile.ingeniousonline.co.in/Projects/JustinLee/SaysBuyThis/Code/index.php/customer/address/">Address Book</a>
                                        <a class="account-links logout" href="http://nile.ingeniousonline.co.in/Projects/JustinLee/SaysBuyThis/Code/index.php/customer/account/logout/">Logout</a>
                          </div>

					</div>
                                            
        <div class="span6"></div>
                                                                                    
                   </div>
                </div>
            </div>
</div>
       

                        </div>
                    </div>
                </div>
            </div>
                    </div>
    </div>
    </div>

   
</div>



<div class="nav-container visible-desktop">
	<div class="container">
	<div class="contain-size">
		<div class="nav-inner">
			<ul id="nav" class="">
			<li class="home active"><a href="#/" title="Home"><span><i class="icon-home"></i></span></a></li>
										
				<li class="level0 nav-1 level-top first">
<a href="#/grocery-staples.html" class="level-top">
<span>Grocery &amp; Staples</span>
</a>
</li>

<?php //echo $nav; 
?>
<li class="level0 nav-2 level-top parent">
<a href="#/clothes.html" class="level-top">
<span>Clothes</span>
</a>
<ul class="level0">
<li class="level1 nav-2-1 first">
<a href="#/clothes/women-s.html">
<span>Women's</span>
</a>
</li><li class="level1 nav-2-2 last">
<a href="#/clothes/men-s.html">
<span>Men's</span>
</a>
</li>
</ul>
</li><li class="level0 nav-3 level-top">
<a href="#/bread-dairy-eggs.html" class="level-top">
<span>Bread Dairy &amp; Eggs</span>
</a>
</li><li class="level0 nav-4 level-top">
<a href="#/beverage.html" class="level-top">
<span>Beverage</span>
</a>
</li><li class="level0 nav-5 level-top">
<a href="#/branded-foods.html" class="level-top">
<span>Branded Foods</span>
</a>
</li><li class="level0 nav-6 level-top">
<a href="#/personal-care.html" class="level-top">
<span>Personal Care</span>
</a>
</li><li class="level0 nav-7 level-top">
<a href="#/imported-gourmet.html" class="level-top">
<span>Imported &amp; Gourmet</span>
</a>
</li><li class="level0 nav-8 level-top last">
<a href="#/more.html" class="level-top">
<span>More</span>
</a>
</li>			</ul>
		</div>
	</div>
	</div>
</div>

<div class="hidden-desktop">
    <nav id="mobile-menu">
        <ul>
        <li class="level0 nav-1 level-top first">
<a href="#/grocery-staples.html" class="level-top">
<span>Grocery &amp; Staples</span>
</a>
</li>




<li class="level0 nav-2 level-top parent">
<a href="#/clothes.html" class="level-top">
<span>Clothes</span>
</a>
<ul class="level0">
<li class="level1 nav-2-1 first">
<a href="#/clothes/women-s.html">
<span>Women's</span>
</a>
</li><li class="level1 nav-2-2 last">
<a href="#/clothes/men-s.html">
<span>Men's</span>
</a>
</li>
</ul>
</li><li class="level0 nav-3 level-top">
<a href="#/bread-dairy-eggs.html" class="level-top">
<span>Bread Dairy &amp; Eggs</span>
</a>
</li><li class="level0 nav-4 level-top">
<a href="#/beverage.html" class="level-top">
<span>Beverage</span>
</a>
</li><li class="level0 nav-5 level-top">
<a href="#/branded-foods.html" class="level-top">
<span>Branded Foods</span>
</a>
</li><li class="level0 nav-6 level-top">
<a href="#/personal-care.html" class="level-top">
<span>Personal Care</span>
</a>
</li><li class="level0 nav-7 level-top">
<a href="#/imported-gourmet.html" class="level-top">
<span>Imported &amp; Gourmet</span>
</a>
</li><li class="level0 nav-8 level-top last">
<a href="#/more.html" class="level-top">
<span>More</span>
</a>
</li>        </ul>
    </nav>
</div>


</div>

<?php
 
if($this->uri->uri_string() == ''){ 

?>


<!-- HERDER END FROM HERE -->

<div class="row-fluid">
	<div class="banner7-container">		
		<div class="flexslider">
			<div class="loading" style="display: none;"></div>
			<ul class="slides">
																														    <li style="display: list-item;">					
				<img src="<?php echo $base_url; ?>assets/frontend/banner/banner.jpg" class="slides_img" alt="">
																															<div class="banner7-caption hidden-phone">
										<h2></h2>
				</div>
			</li>
		</ul>
			
		</div>
	</div>
</div>


<?php
}
?>
<div class="main-container col1-layout">

<!-- SEARCH START FROMM HERE -->

<div class="row">
<div class="col-lg-12 search_bar_bg">
<div class="container">
<form id="search_mini_form" action="amazon_search" method="post">
    

    <div class="form-search">

        <div class="search-content">
			<div name="cat" class="select_left">
			<select name="cat" >
			<option>All</option>
			<option>Grocery</option>
			<option>Option 2</option>
			</select>
			</div>
		<div class="main_srch">
            <label for="search">Search</label>
            <input id="search" type="text" name="keyword" onfocus="if(this.value == 'Search Here...') { this.value = """ onblur="this.value=!this.value?'Search Here...':this.value;" value="Search Here..." class="input-text form-control" maxlength=" "/>
        </div>
	   
        <div class="srch_btn">
		<button type="submit" title="Search" class="button search-btn">Search</button>
		</div>
            <div id="search_autocomplete" class="search-autocomplete"></div>
            <script type="text/javascript">
            //<![CDATA[
                // var searchForm = new Varien.searchForm('search_mini_form', 'search', 'Search...');
                // searchForm.initAutocomplete('<', 'search_autocomplete');
            //]]>
            </script>
        </div>
		
	</div>	
   
</form>
 </div>
</div>
</div>

<div class="container">
	<div class="col-md-12" style="margin-top:20px; float:left; ">

	  <h2 style="font-size: 22px; font-weight: 900; color: #EB6425;"><i class="fa fa-thumbs-up" style="padding:0px 0px;"></i> <?php if($this->session->customer_id){ echo @$this->session->customer_username.".";} ?>saysbuythis.com</h2>
	<div class="clearfix"></div>
	</div>
</div>
<div class="clearfix"></div>