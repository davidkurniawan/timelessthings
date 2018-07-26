<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////



/**
 * Mobile Detect :original source: Mobile_Detect.php 3 2009-05-21 13:06:28Z vic.stanciu $
 */
class UserAgent extends ObjectBase
{
	private
		$accept,
		$userAgent,
		$isMobile     = false,
		//$hasDeviceInit= false,
		$device_inits = array(),
		$devices = array(
			"android"       => "android",
			"blackberry"    => "blackberry",
			"iphone"        => "(iphone|ipod)",
			"ipad"          => "ipad",
			"palm"          => "(avantgo|blazer|elaine|hiptop|palm|plucker|xiino)",
			"windowsCe"     => "windows ce; (iemobile|ppc|smartphone)",
			"windowsPhone"  => "windows phone",
			"generic"       => "(kindle|mobile|mmp|midp|o2|pda|pocket|psp|symbian|smartphone|treo|up.browser|up.link|vodafone|wap)"
		);
	protected function __construct()
	{
		$this->userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$this->deviceInit();
	}
	static function getInstance()
	{
		static $instance;
		if(!isset($instance))
		{
			$class = __CLASS__;
			$instance = new $class();
		}
		return $instance;
	}
	private function deviceInit()
	{
		if(((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'text/vnd.wap.wml')!==false)
		|| (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')!==false))
		|| isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']))
		{
			$this->isMobile = true;
		}
		else
		{

			$mobile_ua      = strtolower(substr($this->userAgent,0,4));
			$mobile_agents  = array('acs-','alav','alca','amoi','audi','aste','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno','ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki','opwv','palm','pana','pant','pdxg','phil','play','pluc','port','prox','qtek','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-');
			if(in_array($mobile_ua,$mobile_agents))
			{
				$this->isMobile  = true;
				$this->devices['generic']=true;
			}else
			{
				foreach ($this->devices as $device => $value)
				{
					if($this->device_inits[$device] =  preg_match("/" . $value . "/is", $this->userAgent))
					{
						$this->isMobile = true;
					}
				}
			}
		}
    }
    function __call($name, $arguments)
	{
		if( strpos($name, 'is') === 0)
		{
			$device = strtolower(substr($name, 2));
			if(isset($this->device_inits[$device]))
			{
				return $this->device_inits[$device];
			}
			return false;
        } else {
            trigger_error("Method $name not defined", E_USER_ERROR);
        }
    }
    public function isMobile()
	{
		//if(!$this->hasDeviceInit)
		//	$this->deviceInit();
		return $this->isMobile;
    }
	public function isBot()
	{
		$botlist = array(
                "Teoma",
                "alexa",
                "froogle",
                "inktomi",
                "looksmart",
                "URL_Spider_SQL",
                "Firefly",
                "NationalDirectory",
                "Ask Jeeves",
                "TECNOSEEK",
                "InfoSeek",
                "WebFindBot",
                "girafabot",
                "crawler",
                "www.galaxy.com",
                "Googlebot",
                "Scooter",
                "Slurp",
                "appie",
                "FAST",
                "WebBug",
                "Spade",
                "ZyBorg",
                "rabaz",
				"Baiduspider",
				"Feedfetcher-Google",
				"TechnoratiSnoop",
				"Rankivabot",
				"Mediapartners-Google",
				"Sogou web spider",
				"WebAlta Crawler"
		);

		//echo preg_quote("WebAlta Crawler");
		//exit;
		//$this->userAgent = 'ds Googlebot sdsds';
		foreach($botlist as $bot)
		{
			if( preg_match('#' . preg_quote($bot). '#i', $this->userAgent))
			{
				return $bot;
			}
		}
		return false;
	}
    protected function isDevice($device)
	{
		//if(isset($this->devices[$device]))
		//{
			//return (bool) preg_match("/" . $this->devices[$device] . "/i", $this->userAgent);
			return preg_match("/$device/i", $this->userAgent);
		//}
        return false;
    }

	function get__version()
	{
		if (preg_match('/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/', $this->userAgent,$matches))
		{
			return $matches[1];
		}
		return 0;
	}
	public function isMsie()
	{
		return preg_match('/msie/i', $this->userAgent ) && !preg_match('/opera/i', $this->userAgent );
	}

	public function isWebkit()
	{
		return preg_match ('/webkit/i', $this->userAgent );
	}
	public function isOpera()
	{
		return preg_match('/opera/i', $this->userAgent );
	}
	public function isFirefox()
	{
		return preg_match('/firefox/i', $this->userAgent );
	}
	public function isMozilla()
	{
		return preg_match('/gecko/i', $this->userAgent ) || $this->isFirefox();
	}

	function __toString()
	{
        return $this->userAgent;
    }

}
///////////////////////////////////////////////
//////////////////////////////////////////////
class Request
{
	static
		$basePath,
		$rootUrl,
		$baseUrl,
		$hostName,
		$scriptName,
		$protocol,
		$requestUri,
		$pathInfo,
		$pathUrl,
		$method,
		$referer,
		$userAgent,
		$appPath,
		$appUrl,
		$basePathUrl,
		$url;

	static function getHeader($name, $prefix='HTTP')
	{
		$prefix = trim(strtoupper($prefix),'_') . '_';
		return @ $_SERVER[$prefix . strtoupper($name)];
	}
	static function initialize()
	{
		self::$method			= isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
		self::$hostName 		= isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		self::$scriptName		= isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : (isset($_SERVER['ORIG_SCRIPT_NAME']) ? $_SERVER['ORIG_SCRIPT_NAME'] : '');
		//self::$protocol			= isset( $_SERVER['HTTP']) || isset($_SERVER['HTTP_SSL_HTTPS'])?'https':'http';
		self::$protocol         = (isset( $_SERVER['HTTPS']) || isset($_SERVER['HTTP_SSL_HTTPS']))?'https':'http';

		$retval = str_replace("\\" , '/',dirname(self::$scriptName));
		self::$appPath = self::$basePath = $retval =='/'?'' : $retval;


		$_retval  = (self::$basePath != '') ? substr($_SERVER['REQUEST_URI'], strlen(self::$basePath)):$_SERVER['REQUEST_URI'];
		self::$requestUri = $_retval=='/'?'': $_retval;


        $pattern = '#(\%3C([a-z\%20]+)\%3E)(.*)(\%3C([a-z\/\%20]+)\%3E)#i';
        preg_match($pattern, self::$requestUri,$m);
        if($m){

            Response::badRequest();
        }



		if($retval!= '')
		{
			$_retval   = explode("?",$_retval);
			$_retval   = rtrim($_retval[0],'/');
		}
		$basedir = "";
		if(!empty($_retval))
		{
			$ar = explode('/',$_retval);
			$basedir = $ar[1];
		}



		self::$rootUrl			= strtolower(self::$protocol . '://' . self::$hostName . ($_SERVER['SERVER_PORT']==80?'':':'.$_SERVER['SERVER_PORT']));
		self::$baseUrl			= self::$rootUrl . self::$basePath;
		self::$appUrl			= self::$rootUrl . self::$appPath;

		self::$pathInfo			= $_retval;
		self::$basePathUrl      = self::$pathUrl = self::$baseUrl .  $_retval;
		self::$url				= self::$baseUrl . self::$requestUri;
		self::$referer			= isset( $_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';


		$basename = basename(self::$pathUrl);
		if(is_numeric($basename))
		{
			self::$basePathUrl = dirname(Request::$pathUrl);
		}
	}

	static function hostNamePrefix()
    {
		if (preg_match('/^(.*)\.(.*)\.([a-z])+$/',self::$hostName, $matches))
		{
			return  $matches[1];
		}
		return null;
    }
	static function topLevelDomain()
    {
		if (preg_match('/^(.*)\.([a-z]+)$/',self::$hostName, $matches))
		{
			return  $matches[2];
		}
		return '';
    }
	static function isLocalhost()
    {
		return self::$hostName == '127.0.0.1'
		|| self::$hostName == 'loopback'
		|| self::$hostName == 'localhost';
    }

	static function url(){
		return self::$url;
	}
	static function method(){
		return self::$method;
	}
	static function hostName(){
		return self::$hostName;
	}
	static function scriptName(){
		return self::$scriptName;
	}
	static function scriptUrl(){
		return self::$rootUrl . self::$scriptName;
	}
	static function protocol(){
		return self::$protocol;
	}
	static function basePath(){
		return self::$basePath;
	}
	static function rootUrl(){
		return self::$rootUrl;
	}
	static function baseUrl($path = null){
		if(is_null($path))
			return self::$baseUrl;
		else
			return self::$baseUrl . '/' . ltrim($path,'/');
	}
	static function requestUri(){
		return self::$requestUri;
	}
	static function pathInfo(){
		return self::$pathInfo;
	}
	static function pathUrl(){
		return self::$pathUrl;
	}
	static function referer(){
		return self::$referer;
	}
	static function userAgent(){
		return  UserAgent::getInstance();
	}
	static function isXmlHttpRequest()
	{
		return (self::getHeader('X_REQUESTED_WITH') == 'XMLHttpRequest');
	}
	static function isSecure()
	{
		return self::$protocol=='https';// && ($_SERVER['HTTP'] =='on' || $_SERVER['HTTPS'] == 1);
	}
	static function isPost()
	{
		return self::$method =='POST';
	}
	static function trimPost()
	{
		foreach($_POST as $key => $value)
		{
			if(is_array($_POST[$key]))
			{
				foreach($_POST[$key] as $key2 => $value2)
				{
					$_POST[$key][$key2]=trim($value2);
				}
			}else
				$_POST[$key]= trim($value);
		}
	}
	static function isGet()
	{
		return self::$method =='GET';
	}
	static function getReferer($default='')
	{
		return empty($_SERVER['HTTP_REFERER'])?$default:$_SERVER['HTTP_REFERER'];
	}
	static function getFiles($key_assoc = false)
	{
		$retval = array();
		if(count($_FILES)>0)
		{
			//$index=-1;
			foreach (array_keys($_FILES) as $key)
			{
				if($_FILES[$key] ['error']=== UPLOAD_ERR_OK)
				{
					//$retval[++$index]= $retval[$key]= new PostedFile($key);
					if($key_assoc){
						$retval[$key]= new PostedFile($key);
					}else{
						$retval[]= new PostedFile($key);
					}

				}
			}
		}
		return $retval;
	}
	static function getCookie($cookie_name)
	{
		if (isset($_COOKIE[$cookie_name]))
		{
			$cookiedata = $_COOKIE[$cookie_name];
			if($cookiedata[0] =='~')
			{
				$ar = explode('|',$cookiedata);
				if(count($ar)==2)
				{
					if($ar[0]=='~a'){
						$dec = Helper::decrypt($ar[1]);
						return unserialize($dec);
					}
				}
			}
			return  Helper::isArraySerialized($_COOKIE[$cookie_name])?unserialize($_COOKIE[$cookie_name]):$_COOKIE[$cookie_name];
		}
		return null;
	}
}
Request::initialize();
//$u = parse_url(Request::$baseUrl);
// Request::$baseUrl = "https://fortigro.dancow.co.id";
//Request::$baseUrl = $u->scheme.'/'.$u->host;
//Request::$baseUrl= str_replace(Request::$baseUrl,":443","");
class Response
{
	/////////////////
	private static
	$headers                       = array(),
	$pageStatusCode          = 200,
	$cacheControl                  = 'no-store',//'no-cache',
	$expires                       = 0,
	$contentLength                 = 0,
	$contentDispositionAttachment  = '',
	$contentDispositionInline      = '',
	$contentType                   = 'text/html',
	$contentTransferEncoding       = '',
	$outputCommpression            = false;

	static function cacheControl($value = null)
	{
		if(is_null($value))
			return self::$cacheControl;
		else
			self::$cacheControl=$value;
	}
	static function expires($value = null)
	{
		if(is_null($value))
			return self::$expires;
		else
			self::$expires=$value;
	}
	static function contentLength($value = null)
	{
		if(is_null($value))
			return self::$contentLength;
		else
			self::$contentLength=$value;
	}
	static function contentDispositionAttachment($value = null)
	{
		if(is_null($value))
			return self::$contentDispositionAttachment;
		else
			self::$contentDispositionAttachment=$value;
	}
	static function contentDispositionInline($value = null)
	{
		if(is_null($value))
			return self::$contentDispositionInline;
		else
			self::$contentDispositionInline=$value;
	}
	static function contentType($value = null)
	{
		if(is_null($value))
			return self::$contentType;
		else
			self::$contentType=$value;
	}
	static function contentTransferEncoding($value = null)
	{
		if(is_null($value))
			return self::$contentTransferEncoding;
		else
			self::$contentTransferEncoding=$value;
	}
	static function outputCommpression($value = null)
	{
		if(is_null($value))
			return self::$outputCommpression;
		else
			self::$outputCommpression=$value;
	}
	private static function send_headers()
	{

		if(!headers_sent())
		{
			if(!empty(self::$contentLength)) header('Content-Length:' . self::$contentLength);
			if(!empty(self::$contentDispositionAttachment) && empty(self::$contentDispositionInline))
			{
				header('Content-Disposition: attachment; filename="' . self::$contentDispositionAttachment .'"');
			}
			if(!empty(self::$contentDispositionInline) && empty(self::$contentDispositionAttachment))
			{
				header('Content-Disposition: inline; filename="' . self::$contentDispositionInline .'"');
			}
			if(!empty(self::$contentTransferEncoding))
			{
				header("Content-Transfer-Encoding: " . self::$contentTransferEncoding);
			}
			if(self::$expires!==false) {

				$date_expires =(self::$expires <= 0)? 'Thu, 21 Jul 1977 07:30:00 GMT' : date('D, d M Y G:i:s GMT', time() + self::$expires);
				header('Expires: ' . $date_expires);
				header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
			}
			if(!empty(self::$cacheControl))
			{

				if(strtolower(self::$cacheControl)=='no-store')
				{
					header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
				}else
				{
					header('Cache-Control:  no-cache, must-revalidate, max-age=0');//, false);
				}
				header('Pragma: no-cache');
			}
			header('Content-Type: ' . self::$contentType);
			foreach( self::$headers as $key => $value)
			{
				if(is_array($value))
				{
					foreach( $value as $data)
					{
						header ($key . ': ' . $data);
					}
				}else
				header ($key . ': ' . $value);
			}
		}
	}
	static function deleteCookie($cookie_name,$cookie_path='/')
	{

		setcookie ($cookie_name, '' ,  time() - (31536000) , $cookie_path);

	}
	static function setCookie($cookie_name, $cookie_value, $expire=0, $cookie_path='/')
	{

		$expire = $expire>0?  (time() + $expire) :0;
		if (version_compare(PHP_VERSION, '5.2.0', '>='))
			setcookie($cookie_name, (is_array($cookie_value)?serialize($cookie_value):$cookie_value), $expire, $cookie_path,'',  COOKIE_SECURE, COOKIE_HTTP_ONLY);
		else
			setcookie($cookie_name,(is_array($cookie_value)?serialize($cookie_value):$cookie_value), $expire, $cookie_path.'; HttpOnly', '',0);
	}
	static function addHeader($name, $header='', $breplace=true)
	{
		if(!headers_sent())
		{
			if($breplace)
				self::$headers[strtolower($name)]  = $header;
			else
				self::$headers[strtolower($name)][]= $header;
		}
	}
	static function reset()
	{
		self::$cacheControl = 'no-cache';
		self::$expires = 0;
		self::$contentLength=0;
		self::$contentDispositionAttachment='';
		self::$contentType='text/html';
		self::$clearHeaders();
		self::$clearContent();
	}
	static function getHeader($name='')
	{
		return @ empty($name)? self::$headers : self::$headers[$name][0];
	}
	static function deleteHeader($name)
	{
		unset(self::$headers[$name]);
	}
	static function clearHeaders()
	{
		self::$headers=array();
	}
	static function getContent()
	{
		return  ob_get_contents();
	}
	static function clearContent()
	{
		ob_end_clean();
		ob_start();
	}
	static function flush()
	{
		self::send_headers();
		ob_flush();
	}
	static function close()
	{
		ob_end_clean();
		exit;
	}
	static function end($output = null, $compression=false)
	{

		self::send_headers();
		if(!headers_sent() &&  ($compression  && extension_loaded('zlib') && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false || strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate') !== false)))
		{

			$content = is_null($output)? ob_get_contents():$output;
			ob_end_clean();
			ob_start('ob_gzhandler');
			echo $content;
			ob_end_flush();
		}else{
			if(is_null($output))
			{
				ob_end_flush();
			}else
				exit($output);
		}
		exit;
	}
	static function writeFile($file_name)
	{
		if(!empty(self::$contentDispositionAttachment))
		{
			ob_end_clean();
			self::send_headers();
			readfile($file_name);
			exit;
		}else
		readfile($file_name);
	}
	static function write($data)
	{
		echo $data;
	}
	static function redirect($url)
	{
		header ('Location: ' . $url);
		exit;
	}
	static function redirectBack($alternate='')
	{
		$url = $alternate;
		if(!empty(Request::$referer)){
			if(Request::$referer!= Request::$url)
				$url = Request::$referer;
		}
		if(empty($url)){
			$url = Request::$url;
		}
		header ('Location: ' . $url);
		exit;
	}

	static function notFound()
	{
		self::setStatus(404,false);

		if(!Request::isXmlHttpRequest()){
			if(is_file('404.php')){
				require '404.php';
			}
		}
		//Message::warning('HTTP 404 Not Found', 'The webpage cannot be found. It\'s possible that the webpage is temporarily unavailable. Alternatively, the website might have changed or removed the webpage');
		exit;
	}
	static function badRequest()
	{
		self::setStatus(400,false);
		if(!Request::isXmlHttpRequest()){
			if(is_file('400.php')){
				require '400.php';
			}
		}
		//if(!Request::isXmlHttpRequest()){
		//	Message::warning('HTTP 400 Bad Request', 'The link you followed is incorrect or outdated.');
		//}
		exit;
	}
	static function unauthorized()
	{
		self::setStatus(401,false);
		if(!Request::isXmlHttpRequest()){
			if(is_file('401.php')){
				require '401.php';
			}
		}
		//if(!Request::isXmlHttpRequest()){
		//	Message::stop('HTTP 401 Unauthorized', 'You do not have permission to view this page');
		//}
		exit;
	}
	static function getStatus()
	{
		return self::$pageStatusCode;
	}

	static function setStatus( $code, $page_exit='auto' )
	{
		$status_desc = array
		(
			100 => 'Continue',
			101 => 'Switching Protocols',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content', //exit
			205 => 'Reset Content',
			206 => 'Partial Content',

			300 => 'Multiple Choices',
			301 => 'Moved Permanently', //exit
			302 => 'Found',//exit
			303 => 'See Other',//exit
			304 => 'Not Modified',
			305 => 'Use Proxy',
			307 => 'Temporary Redirect',//exit

			//exit
			400 => 'Bad Request',
			401 => 'Unauthorized',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',

			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported'
		);
		if(!isset($status_desc[$code]))
			return false;

		self::$pageStatusCode = $code;

		$protocol = $_SERVER["SERVER_PROTOCOL"];
		if ( ('HTTP/1.1' != $protocol) && ('HTTP/1.0' != $protocol) )
			$protocol = 'HTTP/1.0';
		$status_header = "$protocol $code $status_desc[$code]";

		$retval =  @ header( $status_header, true, $code );
		//exit ("Status: $code $status_desc[$code]");
		@ header("Status: $code $status_desc[$code]",1);

		if($page_exit===true || ($page_exit== 'auto' && $code >= 400)) exit;
		return $retval;
	}
}
?>