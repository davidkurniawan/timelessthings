<!-- LOGIN FORM -->

<div id="login">
	<h1 class=" h4 text-center title-sh">
		<img style="max-width:180px;display: block; margin:0 auto;" src="<?php echo Request::$baseUrl.'/views/steakholycow/images/logo.png'; ?>"  />
		<br>
		Sign in
	</h1>
	<div class="loginform">
		<form method="post" action="<?php echo $this->basePath ?>/login" class="form">
			
			
			<div class="input-group">
			  <span class="input-group-addon" id="email"><i class="fa fa-envelope"></i></span>
			  <input type="email" autocomplete="off" name="email" placeholder="Email" class="form-control" />
			</div>
			
			
			<div class="input-group">
			  <span class="input-group-addon" id="email"><i class="fa fa-lock"></i></span>
			 <input type="password" autocomplete="off" name="password" placeholder="Password" class="form-control" />
			</div>
			
			
			<div>
			 	<!-- <div class="small text-right">Forgot Password? <a href="/login?forgot">Click here</a></div> -->
			 	<br />
			 	<!-- <div class="grid cols-2"> -->
				 	<!-- <div  class="text-left">
				 		<label>
	            			<input type="checkbox" value="1" name="autologin" /> Remember me
	       				</label>
	       			 </div> -->
	       			 <div>
	       			 	<button id="btnLogin" class="btn btn-success btn-block" type="submit">Login</button>
	       			 </div>
			 	<!-- </div> -->

			 </div>
		</form>
	</div>

</div>
