<?php

class app {
	
	public static $config, $session, $startTime, $page, $database, $locale, $systemTemplatePath;

	private static function init() {
		ob_start();

		self::$config = Config::getInstance();

		if (self::$config -> modSession) {
			self::$session = new self::$config->modSession();
		}
		date_default_timezone_set(DEFAULT_TIMEZONE);
		self::$locale = new Culture(self::$config -> lang);

	}

	public static function start() {
		self::init();

		if ($_SERVER['HTTP_USER_AGENT'] != 'BHM 2015 DesktopApp') {
			if (defined('LOCK_PASSCODE')) {
				$cookie = Request::getCookie('_lcpass');
				$locked = false;
				if (Request::isPost()) {
					$c = @$_POST['passcode'];
					if (empty($c) && $cookie != 1) {
						$locked = true;
					} else {
						if ($c == LOCK_PASSCODE) {
							$cookie = $c;
							Response::setCookie('_lcpass', 1, SESSION_AUTOLOGIN_TIMEOUT);
							Response::redirect(Request::$url);
						}
					}
				} else {
					$locked = ($cookie != '1');
				}

				if ($cookie != '1') {
					require ('passcode.php');
					exit ;
				}

			}
		}

    preg_match('#(Edge|Trident|MSIE)#i', $_SERVER['HTTP_USER_AGENT'],$m );
    if($m)
        {

            Response::setStatus(406,true);
        }


		self::pathRewrite();
	}

	private static function pathRewrite() {
		$props = array();

		if (!empty(Request::$pathInfo)) {
			$imgvars = array_keys(self::$config -> imageSizeOptions);
			self::$config -> pathRewrites['/' . MEDIA_PATH . '/(?<mediaType>([a-z])+)/(?<size>(' . implode('|', $imgvars) . ')+)/(?<fileName>([a-z0-9A-Z\-_\.])+)\.(?<ext>(jpg|png)+)'] = 'ImageDocument';

			if (self::$config -> virtualDirectory) {
				foreach (self::$config->virtualDirectory as $pathname => $value) {
					if (preg_match('#^' . addcslashes($pathname, "-./") . '/#', Request::$pathInfo . '/', $match)) {
						$pathInfo = substr(Request::$pathInfo, strlen($pathname));
						$module = new $value[0]();
						$module -> pathRewrites($pathRewrites);
						$props = array("basePath" => $pathname);
						if (empty($pathInfo)) {
							self::execRewrite($props, $pathRewrites['/'], $value[1]);
						} else {
							self::rewrites($pathInfo, $pathRewrites, $value[1], $props, null);
						}
						return;
					}
				}
			}

			////////////////////////////////////////////////////
			if(self::$config -> termPaths != null)
			{
				$pathRewrites = array_merge(self::$config -> pathRewrites, self::$config -> termPaths);
			}else{
				$pathRewrites = self::$config -> pathRewrites;
			}
			
			
			if (self::$config -> modPage) {
				$pathRewrites['/(?<contentName>([a-z0-9\-])+)'] = self::$config -> modPage;
			}
			self::rewrites(Request::$pathInfo, $pathRewrites, self::$config -> templatePath, array(), self::$config -> modNotFound);
		} else {
			self::execRewrite(array(), self::$config -> pathRewrites['/'], self::$config -> templatePath);
		}
	}

	private static function execRewrite($props, $module, $templatePath) {
		$props['templatePath'] = $templatePath;
		$props['templateUrl'] = Request::$baseUrl . '/' . $props['templatePath'];
		self::$page = new $module($props);
		self::$page -> start();
		
	}

	private static function rewrites($pathInfo, $pathRewrites, $templatePath, $props, $modNotFound) {
		foreach ($pathRewrites as $patern => $value)
		{
			if (preg_match('#^' . $patern . '$#', $pathInfo, $match)) {
				$module = $value;
				$props = array_merge($props, $match);
				for ($i = 0; $i < count($match); $i++) {
					unset($props[$i]);
				}

                if(app::$config->allowRemoteAddress)
                {


// if(isset($_GET['xtest'])){
    // phpinfo();
  // //  echo $_SERVER['REMOTE_ADDR'];
    // exit;
// }
// //


                    if(isset(app::$config-> allowRemoteAddress[$pathInfo]))
                    {

                        $allow = false;
                        $ar = explode("|", app::$config-> allowRemoteAddress[$pathInfo]);
                        foreach($ar as $ip)
                        {
                            if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                            {

                               if($ip==$_SERVER['HTTP_X_FORWARDED_FOR'])
                               {
                                    $allow=true;
                                    break;
                               }
                            }else
                            {
                                if($ip==$_SERVER['REMOTE_ADDR']){
                                     $allow=true;
                                    break;
                                }
                            }
                        }
                        if(!$allow){
                            Response::unauthorized();
                        }
                    }

                }

				break;
			}
		}

		if (!isset($module)) {
			if ($modNotFound) {
				$module = $modNotFound;
			} else {
				Response::notFound();
			}
		}
		self::execRewrite($props, $module, $templatePath);
	}

}
?>