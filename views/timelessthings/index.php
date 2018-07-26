<?php $this->settings = Settings::getSettings(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title><?php echo $this -> pageTitle(); ?></title>
        <meta name="description" content="">
        <meta name="author" content="LuveTheme">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

		
		<link rel="stylesheet" href="<?php echo Request::$baseUrl.'/vendor/bootstrap/css/bootstrap.min.css'; ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo Request::$baseUrl.'/vendor/fontawesome/css/font-awesome.min.css'; ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo Request::$baseUrl.'/vendor/bxslider/jquery.bxslider.min.css'; ?>" type="text/css" />
		
		<link rel="stylesheet" href="<?php echo $this->templateUrl.'/css/styles.css'; ?>" type="text/css" />
		
		<script src="<?php echo Request::$baseUrl.'/vendor/jquery-1.12.1.min.js'; ?>"></script>     
		
		<script src="<?php echo Request::$baseUrl.'/vendor/jquery.sticky.js'; ?>"></script>     
		
 		<script src="<?php echo Request::$baseUrl.'/vendor/bxslider/jquery.bxslider.min.js'; ?>"></script>    
 		
    </head>
<body>

<!-- HEADER -->
<div id="topheader" class="hide-sm">
	<div class="container">
		<ul class="language">
			<li><a href="#">EN</a></li>
			<li><span>|</span></li>
			<li><a href="#">ID</a></li>
		</ul>
		<ul class="auth">
			<li><a href="#">LOG IN</a></li>
		</ul>
	</div>
</div>
<div id="header" class="hide-sm">
	<div class="container">
		<div class="navbar-header">
			<a href="<?php echo Request::$baseUrl; ?>" class="logo"><img src="<?php echo $this->templateUrl.'/images/logo.png'; ?>" /></a>
		</div>
		<div class="navmenu">
			<div class="menuhalf">
				<ul>
					<li><a href="/page/about-us">About</a></li>
					<li><a href="/page/philosophy">Philosophy</a></li>
					<li><a href="/page/products">Product</a></li>
				</ul>
			</div>
			<div class="menuhalf">
				<ul>
					<li><a href="/page/process">Process</a></li>
					<li><a href="/page/people">People</a></li>
					<li><a href="/contact">Contact</a></li>
				</ul>
			</div>
			
		</div>
	</div>
</div>

<div id="mHeader">
	<div class="container">
			
		
		<div class="navbar-header">
			<div class="text-left"><a href="#">LOG IN</a></div>
			<div><a href="<?php echo Request::$baseUrl; ?>" class="logo"><img src="<?php echo $this->templateUrl.'/images/logo.png'; ?>" /></a></div>
			<div class="text-right"><a href="javascript:;" id="toggleMenu"><i class="fa fa-bars"></i></a></div>
		</div>
		
		<div class="navmenu">
			<a href="#" id="toggleClose" class="text-right">close <i class="fa fa-arrow-right"></i> </a>
				<ul class="language">
					<li><a href="#">EN</a></li>
					<li><span>|</span></li>
					<li><a href="#">ID</a></li>
				</ul>
				<ul class="mainmenu">
					<li><a href="/page/about-us">About</a></li>
					<li><a href="/page/philosophy">Philosophy</a></li>
					<li><a href="/page/products">Product</a></li>
					<li><a href="/page/process">Process</a></li>
					<li><a href="/page/people">People</a></li>
					<li><a href="/contact">Contact</a></li>
				</ul>
				
			
			
		</div>
		
	</div>
</div>

<?php  echo $this -> renderView(); ?>



<div id="footer">
	<div class="topfooter">
		<div class="col-md-5 rightfooter">
			
			<div class="col-sm-12">
				<h4>SUBSCRIBE TO OUR NEWSLETTER!</h4>
				<div class="form-inline newsletter">
					<div class="input-group">
				         <input type="email" class="form-control" placeholder="Enter your email">
				         <span class="input-group-btn">
				         <button class="btn btn-primary" type="submit">SUBMIT</button>
				         </span>
					</div>
					<span class="small" style="font-size:11px; font-weight:300; letter-spacing: .2em;">Signup now for more information about our company!</span>
				</div>
			</div>
			
		</div>
		<div class="col-md-7 leftfooter">
			<div class="col-sm-6" style="overflow:hidden;">
				<h4>TIMELESS THINGS COMPANY</h4>
				<ul class="footermenu">
					<li><a href="/page/about-us">About</a></li>
					<li><a href="/page/products">Product</a></li>
				</ul>
					<ul class="footermenu">
					<li><a href="/page/people">People</a></li>
					<li><a href="/page/philosophy">Philosophy</a></li>
					</ul>
						<ul class="footermenu">
					<li><a href="/page/process">Process</a></li>
					<li><a href="/contact">Contact</a></li>
					</ul>
			</div>
			<div class="col-md-6">
				<h4>SOCIAL MEDIA</h4>
				<ul class="socmed">
					<li><a href="<?php echo $this->settings["facebook"]; ?>"><i class="fa fa-facebook-official"></i></a></li>
					<li><a href="<?php echo $this->settings["facebook"]; ?>"><i class="fa fa-twitter"></i></a></li>
					<li><a href="<?php echo $this->settings["facebook"]; ?>"><i class="fa fa-instagram"></i></a></li>
				</ul>
			</div>
		</div>
		
	</div>
		
		
		<div class="copyright text-center">
			<p class="small">&copy; TIMELESS THINGS COMPANY <?php echo date("Y"); ?></p>
		</div>
</div>
        
        <script>
        $(document).ready(function(){
        	$("#header").sticky({topSpacing:0});
        	if($("#mHeader").length){
        		$("#mHeader").sticky({topSpacing:0});
        		
        		$("#mHeader #toggleMenu, #mHeader #toggleClose").on('click', function(){
        			
        			$("#mHeader .navmenu").toggleClass("open");
        			
        		});
        			
        			
        			
        	}
        
        });
        	
        </script>
 
   	
</body>

</html>