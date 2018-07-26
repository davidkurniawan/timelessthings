<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


define('DS'                 , DIRECTORY_SEPARATOR);
define('LIB_PATH'           , dirname(__FILE__));
define('MODULES_PATH'       , ABS_PATH.DS.'controllers');


if(!defined('SESSION_COOKIE_NAME'))       define('SESSION_COOKIE_NAME', md5( 'session' . HASH_KEY));

if(!defined('MEDIA_PATH'))                define('MEDIA_PATH', 'uploads');
if(!defined('CACHE_PATH'))                define('CACHE_PATH', ABS_PATH .DS.'tmp');
if(!defined('IMAGES_CACHE_PATH'))         define('IMAGES_CACHE_PATH', MEDIA_PATH . '/tmp');

if(!defined('SESSION_AUTOLOGIN_TIMEOUT')) define('SESSION_AUTOLOGIN_TIMEOUT',864000);
if(!defined('DEFAULT_TIMEZONE'))          define('DEFAULT_TIMEZONE','UTC');
if(!defined('LOGIN_ATTEMPTS'))            define('LOGIN_ATTEMPTS',5);
if(!defined('LOGIN_ATTEMPTS_TIMOEOUT'))   define('LOGIN_ATTEMPTS_TIMOEOUT',1);
if(!defined('CSRF_TOKEN_NAME'))           define('CSRF_TOKEN_NAME','token');

if(!defined('COOKIE_SECURE'))           define('COOKIE_SECURE',0);
if(!defined('COOKIE_HTTP_ONLY'))           define('COOKIE_HTTP_ONLY',0);

/**************
AUTH_TYPE 'none,user,form,basic,digest
**************/

define('NEW_LINE',strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'?"\r\n":"\n");
define('CRLF',"\r\n");

// Strip slashes from GET/POST/COOKIE (if magic_quotes_gpc is enabled)
if (get_magic_quotes_gpc())
{
	function stripslashes_array($array)
	{
		return is_array($array) ? array_map('stripslashes_array', $array) : stripslashes($array);
	}

	$_GET = stripslashes_array($_GET);
	$_POST = stripslashes_array($_POST);
	$_COOKIE = stripslashes_array($_COOKIE);
}

require_once LIB_PATH . DS.'object.php';
require_once LIB_PATH . DS.'IO.php';
require_once LIB_PATH . DS.'cache.php';
require_once LIB_PATH . DS.'Error.php';
require_once LIB_PATH . DS.'httpHandler.php';
require_once LIB_PATH . DS.'app.php';

$__autoload_classes 	= array();


//foreach($_SERVER as $key=>$value)
//{
//echo  $key . " : " .$value . "\n";
//}
//exit;

/////////////////////////////////////////////////
$useragent = "luve:" .  @ $_SERVER['HTTP_USER_AGENT'];
define('CSRF_TOKEN',  getHash( $useragent . $_SERVER['REMOTE_ADDR']) );
function isValidCsrfToken()
{
	if(!empty( $_REQUEST[CSRF_TOKEN_NAME]))
	{
		return $_REQUEST[CSRF_TOKEN_NAME] === CSRF_TOKEN;
	}
	return false;
}
function validateCsrfToken()
{
	if(! isValidCsrfToken())
	{
		Response::unauthorized();
	}
}
/////////////////////////////////////////////////

function getMicrotime()
{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
}
function getHash($str)
{
	return md5($str . HASH_KEY);
}
function staticUrl($path_relative)
{
	return STATIC_BASEURL . $path_relative;
}
function func_get_params($default_params, $args)
{
	if($args)
	{
		if( is_array($args[0]) && count($args)==1)
		{
			return array_merge($default_params,$args[0]);
		}else
		{
			foreach(array_keys($default_params) as $index=>$key)
			{
				if(isset($args[$index])){
					$default_params[$key] = $args[$index];
				}
			}
			return $default_params;
		}
	}
	return null;
}

function __()
{
	if($num_args = func_num_args())
	{
		$args = func_get_args();
		$text = $args[0];
		if(!Lang::hasConversation()){
			Lang::addConversation('default');
		}
		if(isset( Lang::$items[$text]))
		{
			$text = Lang::$items[$text];
		}
		if($num_args ==1)
		{
			return $text ;
		}else
		{
			return   vsprintf($text, array_slice($args,1));
		}
	}
}
///////////////////////////////////////////////
//$__autoload_classes

$__autoload_classes=array();

spl_autoload_register(function ($className)
{


	global $__autoload_classes;
	$slpos =  strpos($className,"\\");
	if( $slpos >0){
		$ar = explode("\\",$className);
		$className = $ar[count($ar)-1];
	}

	if(!isset($__autoload_classes[$className]))
	{
		Cache::delete(MODULES_PATH);
		__autoload_create_cache();
		if(!isset($__autoload_classes[$className]))
		{
			trigger_error("Undefined class '$className'", E_USER_ERROR);

		}
	}

    require_once $__autoload_classes[$className];

});

/*
function __autoload($className)
{
	global $__autoload_classes;
	if(!isset($__autoload_classes[$className]))
	{
		Cache::delete(MODULES_PATH);
		__autoload_create_cache();
		if(!isset($__autoload_classes[$className]))
		{
			trigger_error("Undefined class '$className'", E_USER_ERROR);

		}
	}
	require_once $__autoload_classes[$className];
}*/

function __autoload_libs_callback($file)
{
	global $__autoload_classes;
	$filename = basename($file,".php");
	$c = $filename{0};
	if($c== strtoupper($c))
	{
		if(''== $className = substr(strrchr($filename, '.'), 1))
		{
			 $className=$filename;
		}
		if($className!= 'File' || $className!= 'Folder' || $className!= 'Cache')
			$__autoload_classes[$className] = $file;
	}
}
function __autoload_create_cache()
{
	global $__autoload_classes;
	Folder::getFiles(LIB_PATH , '(.*)\.php+$', true,'__autoload_libs_callback',DS);
	Folder::getFiles(MODULES_PATH , '(.*)\.php+$', true,'__autoload_libs_callback',DS);
	if(is_dir('plugins')){
		Folder::getFiles('plugins' , '(.*)\.php+$', true,'__autoload_libs_callback',DS);
	}

	if(!empty($__autoload_classes))
	{
		Cache::putData(MODULES_PATH, $__autoload_classes,0,'__autoload_classes');
	}
}

if(!Cache::exists(MODULES_PATH))
	__autoload_create_cache(MODULES_PATH);
else{

	require( Cache::getFilename(MODULES_PATH));
}

?>