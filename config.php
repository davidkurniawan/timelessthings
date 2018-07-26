<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////



	//$this->dsn = 'mysql://root:@localhost/timelessthings#ln_';
	
	$this->dsn = 'mysql://userx1s:4EFdqW{TBO&p@localhost/timelessthings#ln_';
	
	$this->templatePath  = "views/timelessthings";
	
	
	$this->imageSizeOptions = array
		(
			"t"    => "370|300|crop",
			"tt"   => "300|160|crop",
			"t/fw" => "320|0",
			"tp"   => "399|105|crop",
			"tpF"   => "300|300",
			"tpH"   => "176|160",
			"h"    => "630|355|crop",
			"hh"    => "545|545|crop",
			"m"    => "768|0",	
			"l"    => "1307|308"
		);
	
	$this->pathRewrites["/contact"] = "StaticPage";
	$this->pathRewrites["/page/about-us"] = "StaticPage";
	$this->pathRewrites["/page/philosophy"] = "StaticPage";
	$this->pathRewrites["/page/process"] = "StaticPage";
	$this->pathRewrites["/page/people"] = "StaticPage";
	$this->pathRewrites["/page/products"] = "StaticPage";
	$this->virtualDirectory ["/cms" ]= array( "Admin","views/admin");
	

	
	
?>