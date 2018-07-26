<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">


		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php echo  strip_tags($this->pageTitle());  ?></title>
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS Jqarta -->
		<link rel="stylesheet" href="<?php echo  $this->templateUrl; ?>/js/fr/css/styles.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->templateUrl; ?>/css/font-awesome.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->templateUrl; ?>/js/datepicker/datepicker.css" type="text/css" />
		<?php if($this->isRealTimeApp){ ?>
			<link rel="stylesheet" href="<?php echo $this->templateUrl; ?>/css/realtime/" type="text/css" />
		<?php }else{ ?> 
			<link rel="stylesheet" href="<?php echo $this->templateUrl; ?>/css/" type="text/css" />
		<?php } ?>
		<?php if(App::$session->authenticated){ ?>
			<script src="<?php echo $this->templateUrl; ?>/js/fr/jquery.js"       type="text/javascript"></script>
			<script src="<?php echo $this->templateUrl; ?>/js/fr/jqarta.core.js"   type="text/javascript"></script>
			<script src="<?php echo $this->templateUrl; ?>/js/fr/jqarta.io.js" type="text/javascript"></script>
			<script src="<?php echo $this->templateUrl; ?>/js/fr/jqarta.modal.js" type="text/javascript"></script>
			<script src="<?php echo $this->templateUrl; ?>/js/fr/jqarta.popup.js" type="text/javascript"></script>
			<script src="<?php echo $this->templateUrl; ?>/js/fr/jqarta.validator.js" type="text/javascript"></script>

			<script>
				var BASE_URL       = '<?php echo Request::$baseUrl ?>';
				var ADMIN_BASE_URL = '<?php echo $this->baseUrl ?>';
			</script>

		<?php } ?>

		<script src="<?php echo $this->templateUrl; ?>/js/scripts.js?v3.1" type="text/javascript"></script>


		<?php $this->pageLinks() ?>




	</head>

	<body>

		<?php if(app::$session->authenticated){ ?>



		<!-- HEADER -->

				<div id="header">
					<h3 class="float-left" style="padding-left:2em; margin-top:5px; color:#ebebeb;">
						<?php echo $this->pageTitle(); ?>
					</h3>
					
					
					
					<div id="account" class="float-right">
						<!-- User Menu -->
						 <div>
		                	<button  data-role="dropdown" class="button btn-dark"><i class="fa fa-user"></i>
		                		&nbsp; <span class="hide-md"><?php echo $this->currentUser->name ?></span>
		                    <span class="caret"></span>
		                    </button>
		                    <ul class="popup">
		                    <li><a class="" href="/cms/users/edit?id=<?php echo $this->currentUser->id ?>"><i class="fa fa-pencil-square-o"></i> Edit Account</a></li>
		                    <li><a class="bold" href="/cms/logout"><i class="fa fa-power-off"></i> Log out</a></li>
		                    </ul>
		                </div>
					</div>
					
			
				</div>

		<!-- END HEADER -->


		<div class="navSidebar">
                <div class="sideBarTop">
                	<a href="#" class="logo">Site Admin</a>
                </div>
				<ul class="menuBar">
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
			                    		<span class="icon"><i class="fa <?php echo $value['icon']; ?>"></i></span>
			                    		<span><?php echo $value['title'] ?></span>
			                    		<?php echo isset($value['group']) ? '<span class="icon float-right"><i class="fa fa-chevron-right"></i></span>' : ''; ?>
			                    	</a>


			                    	<?php if(isset($value['group'])){ ?>
			                    			<ul class="<?php echo Request::$pathInfo ==  $path ? 'active' : '';  ?>">
			                    			<?php foreach ($value['group'] as $key => $val) { ?>
												
												<li>
														
													<a href="<?php echo $this->baseUrl . $val['basePath'] ?>">
														<span class="icon"><i class="fa <?php echo $val['icon']; ?>"></i></span>
														<span><?php echo $val['title'] ?></span>
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


		<div id="wrapper">
			<div id="mainContent">
				<div class="breadcrumb">
					<?php CustomHelper::breadcrumbs(Request::$pathInfo); ?>
				</div>
				<div class="wrapper">
                   <?php echo $this->renderView(); ?>
                 </div>
			</div>

		</div>


	 <?php }else{ ?>

	 	<div class="wrapper">
	 	 <?php echo $this->renderView(); ?>
	 	</div>


	 <?php } ?>
	 
		<script src="<?php echo $this->templateUrl; ?>/js/layout.js" type="application/javascript"></script>
	</body>
</html>
