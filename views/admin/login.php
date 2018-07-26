<!-- LOGIN FORM -->

<div id="login">
	<h1 class=" h2 text-center title-sh">
		Login Admin
	</h1>
	<div class="loginform">
		<form method="post" action="<?php echo $this->basePath ?>/login" class="form">

			<div class="input-group">
				<label style="min-width:40px;" class="text-center"><i class="fa fa-envelope"></i> </label>
				<input type="email" autocomplete="off" name="email" placeholder="Email" class="form-element" />

			</div>

			<div  class="input-group">
				<label style="min-width:40px;" class="text-center"><i class="fa fa-lock"></i> </label>
				<input type="password" autocomplete="off" name="password" placeholder="Password" class="form-element" />
			</div>
			<div>
			 	<div class="small text-right">Forgot Password? <a href="/login?forgot">Click here</a></div>
			 	<br />
			 	<div class="grid cols-2">
				 	<div  class="text-left">
				 		<label>
	            			<input type="checkbox" value="1" name="autologin" /> Remember me
	       				</label>
	       			 </div>
	       			 <div>
	       			 	<button id="btnLogin" class="button primary small block" type="submit">Login</button>
	       			 </div>
			 	</div>

			 </div>
		</form>
	</div>

</div>
