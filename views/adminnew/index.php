<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title><?php echo $this->pageTitle(); ?></title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="<?php echo $this->templateUrl; ?>/assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="<?php echo $this->templateUrl; ?>/assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="<?php echo $this->templateUrl; ?>/assets/css/paper-dashboard.css" rel="stylesheet"/>
	<link href="<?php echo $this->templateUrl; ?>/assets/css/styles.css" rel="stylesheet"/>
	

    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="<?php echo $this->templateUrl; ?>/assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>
<?php if(app::$session->authenticated){ ?>
<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">


    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="<?php echo Request::$baseUrl; ?>" class="simple-text">
                  Timelessthingsco
                </a>
            </div>

            <ul class="nav">
            	<?php
		            foreach(Admin::$pages as $value)
					{
						if(is_array($value))
						{

							// if(in_array($this->currentUser->role, $value['role']))
							// {
								$class="";
								$path = "";
								if(!empty($this->task))
								{
									$path = $this->basePath . $value['basePath'].'/'.$this->task;
								}else{
									$path = $this->basePath . $value['basePath'];
								}
								if($value['basePath'] != "" && Helper::startWith($path, Request::$pathInfo))
								{
									// $class="active";
									$selectedModule = $value;
								}


								?>

			                    <li class="<?php echo isset($value['group']) ? 'hassub' : ''; ?> <?php echo Request::$pathInfo ==  $path ? 'active' : '';  ?>">


			                    	<a href="<?php echo $this->baseUrl . $value['basePath'] ?>">
			                    		<i class="ti-<?php echo $value['icon']; ?>"></i>
			                    		<p><?php echo $value['title'] ?></p>
			                    		<?php echo isset($value['group']) ? '<span class="icon float-right"><i class="fa fa-chevron-right"></i></span>' : ''; ?>
			                    	</a>


			                    	<?php if(isset($value['group'])){ ?>
			                    			<ul class="<?php echo Request::$pathInfo ==  $path ? 'active' : '';  ?>">
			                    			<?php foreach ($value['group'] as $key => $val) { ?>
												
												<li>
													<a href="<?php echo $this->baseUrl . $val['basePath'] ?>">
														<p><?php echo $val['title'] ?></p>
													</a>
												</li>
													
											<?php } ?>
			                    			</ul>
			                    	<?php } ?>
			                    </li>

		                    <?php
		                    // }
						}else{
								echo '<li class="divider"></li>';
						}
					}
					?>
            	
            	
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <!-- <a class="navbar-brand" href="#"><?php echo $this->pageTitle(); ?></a> -->
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                       
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-user"></i>
                                    <!-- <p class="notification">5</p> -->
									<p><?php echo $this->currentUser->name ?></p>
									<b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
                              	<li><a href="/admin/users/edit?id=<?php echo $this->currentUser->id ?>">Edit Account</a></li>
                                <li><a href="/admin/logout">Sign Out</a></li>
                              </ul>
                        </li>
						
                    </ul>

                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <?php echo $this->renderView(); ?>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
         
                <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> 
                </div>
            </div>
        </footer>

    </div>
</div>

<?php }else{?>
	<div class="wrapper">
		<?php echo $this->renderView(); ?>
	</div>
	
<?php } ?>
</body>

    <!--   Core JS Files   -->
    <script src="<?php echo $this->templateUrl; ?>/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="<?php echo $this->templateUrl; ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="<?php echo $this->templateUrl; ?>/assets/js/bootstrap-checkbox-radio.js"></script>

	<!--  Charts Plugin -->
	<script src="<?php echo $this->templateUrl; ?>/assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="<?php echo $this->templateUrl; ?>/assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script> -->

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="<?php echo $this->templateUrl; ?>/assets/js/paper-dashboard.js"></script>

	

	<script type="text/javascript">
    	// $(document).ready(function(){
// 
        	// demo.initChartist();
// 
        	// $.notify({
            	// icon: 'ti-gift',
            	// message: "Welcome to <b>Paper Dashboard</b> - a beautiful Bootstrap freebie for your next project."
// 
            // },{
                // type: 'success',
                // timer: 4000
            // });
// 
    	// });
	</script>

</html>
