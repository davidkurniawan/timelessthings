<?php

//if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


	define('ABS_PATH', dirname(__FILE__));

	define('HASH_TYPE',		'md5');
	define('HASH_KEY',		'Xmo_SFCow*(-)*');
	define('DEBUG_MODE',1);
	define('GLOBAL_ENCRYPT_KEY', '#12ssra!');

	require "cores/core.php";
	
	App::start();
?>