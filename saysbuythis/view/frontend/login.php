
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
    <div class="page-title">
        <h1>Login or Create an Account</h1>
    </div>
                <form action="<?php echo base_url('auth/check_login'); ?>" method="post" id="login-form">
        <input name="form_key" type="hidden" value="KayhtO73sZrCeyqn" />
        <div class="col2-set">
            <div class="col-1 new-users">
                <div class="content">
                    <h2>New Customers</h2>
                    <p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>

							<div class="w3-socialconnect-social" style="margin-top:30px;">
                                <p>You can login using your social network account.</p>
                                <div class="w3-social-button-login">
                                
                                </div>
                            </div>
                    
                </div>
            </div>
            <div class="col-2 registered-users">
                <div class="content">
                    <h2>Registered Customers</h2>
                    <p>If you have an account with us, please log in.</p>
                    <?php if(@$msg){ echo "<h3 style='color:red';>$msg </h3>"; } ?>
				<ul class="form-list">
					<li>
						<label for="email" class="required"><em>*</em>User Name</label>
						<div class="input-box">
							<input type="text" name="username" value="" id="email" class="input-text required-entry validate-email" title="Email Address" required />
							 <!--<input type="text" name="login[username]" value="" id="email" class="input-text required-entry validate-email" title="Email Address" /> --> 						</div>
					</li>
					<li>
						<label for="pass" class="required"><em>*</em>Password</label>
						<div class="input-box">
							<input type="password" name="password" class="input-text required-entry validate-password" id="pass" title="Password" required />
						</div>
					</li>
				</ul>
                    <p class="required">* Required Fields</p>                    
                </div>
            </div>
        </div>
        <div class="col2-set">
            <div class="col-1 new-users">
                <div class="buttons-set">
                    <button type="button" title="Create an Account" class="button" onclick='window.location="<?php echo base_url('auth/signup'); ?>";'><span><span>Create an Account</span></span></button>
                </div>
            </div>
            <div class="col-2 registered-users">
                <div class="buttons-set">
                    <a href="http://nile.ingeniousonline.co.in/Projects/JustinLee/SaysBuyThis/Code/index.php/customer/account/forgotpassword/" class="f-left">Forgot Your Password?</a>
                    <button type="submit" class="button" title="Login" name="send" id="send2"><span><span>Login</span></span></button>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        //<![CDATA[
        var dataForm = new VarienForm('login-form', true);
        //]]>
    </script>
</div>

                        </div>
                        
                    </div>
                </div>
                
            </div>
            </div>
            
        </div>
        
    </div>

    

</div>


