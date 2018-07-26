<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

class Config
{
	public
		$changes = array();

	public
		$dsn = null,
		$pathRewrites  = array('/'=>"SiteIndex"),
		$templatePath  = "tpl/default",

		///////////////////
		$virtualDirectory   = array(), //array( "/admin" => array( "Admin","tpl/admin") ),
		/////////////////////////////

		$modPage       = null,
		$modGrobal     = null,
		$modSession    = "Session",
		//$siteName      = "JQarta",

		$loginModule        = 'LoginDocument',
		$activationModule   = 'AccountActivation',

		$allowRemoteAddress = null,

		$fbConfigs = null,
		$paypalConfigs = null,

		$imageCache    = true,
		$imageSizeOptions = array
		(
			"t"    => "320|210|crop",
			"t/fw" => "320|0",
			"h"    => "630|355|crop",
			"m"    => "768|0",
			"l"    => "1024|768"
		);
		public $configs  = array
		(
			"lang"               => 'en',
			"loginEnabled"       => true,
			"activationRequired" => true
		);

	private $saveChangeConfig = false;

	protected function __construct()
	{
		$ar = explode(".", $_SERVER['HTTP_HOST']);
		$len = count($ar);
		$confilg_file = "config.php";

		if($len >2)
		{
			if( $ar[0]!='www' && !is_numeric($ar[$len-1]))
			{
				$prefix = $ar[0]. '.';
				if(
					preg_match('#.(co|com|or|org|go|gov|web|net).([a-z]+)$#', $_SERVER['HTTP_HOST'] ,$m)
					&& $len==3)
				{
					$prefix = '';
				}
				if(is_file($prefix . "config.php"))
				{
					$confilg_file = $prefix . "config.php";
				}else{

					if(is_file("wildcard.config.php"))
					{
						$confilg_file = "wildcard.config.php";
					}
				}
			}
		}

		require $confilg_file;
		if($this->loginEnabled && $this->loginModule)
		{
			$this->pathRewrites["/(?<pathName>(login|logout))(|(/(?<task>(forgot|reset))))"]= $this->loginModule;
			//$this->pathRewrites["/logout"]= $this->loginModule;
		}
		if($this->activationRequired && $this->activationModule)
		{
			$this->pathRewrites["/activate"]= $this->activationModule;
		}


		$saveChangeConfig = true;

	}


	public static function getInstance()
	{
		static $instance;
		if(!isset($instance))
		{
			$class = __CLASS__;
			$instance = new $class();
			if($instance->dsn)
			{

				app::$database  = DataProvider::createConnection($instance->dsn);
				app::$database->open();

				if(!Cache::exists(Cache::CACHE_NAME_CONFIG))
				{
					if(isset($_REQUEST['install'])){


						if(!app::$database->getResult("SHOW TABLES LIKE '#__metadata'"))
						{
							require LIB_PATH . '/install.php';
						}

					}
					$configs = MetaData::getConfigs();
					Cache::putData(Cache::CACHE_NAME_CONFIG, $configs,0,'configs');

				}else
					require Cache::getFilename(Cache::CACHE_NAME_CONFIG);

				$instance->configs = array_merge($instance->configs,$configs);

			}
		}
		return $instance;
	}
	public function __get($name)
    {
        if (array_key_exists($name,$this->configs))
		{
        	return $this->configs[$name];
		}
		return null;
    }
    public function __set($config_name, $value)
    {
        if (array_key_exists($config_name,$this->configs))
		{
			if($this->configs[$config_name] != $value)
			{
				if($this->saveChangeConfig){
					$this->changes[] = $config_name;
				}
				$this->configs[$config_name]=$value;
			}
		}
    }
	function saveChanges()
	{
		if($this->changes)
		{
			foreach($this->changes as $config_name){
				MetaData::updateValue('config',$config_name,$this->configs[$config_name], true);
			}
			$this->clearCache();
		}
	}
	function save($config_name,$config_value)
	{
		if(MetaData::updateValue('config',$config_name,$config_value, true))
		{
			$this->configs[$config_name]=$config_value;
			$this->clearCache();
		}
	}
	function clearCache()
	{
		Cache::delete(Cache::CACHE_NAME_CONFIG);
	}
    public function delete($config_name)
    {
		if (array_key_exists($config_name,$this->configs))
		{
			unset($this->configs[$config_name]);
			MetaData::deleteItem('config',$config_name);
		}
	}

	public function __isset($name)
	{
        return isset($this->configs[$name]);
    }
    public function __unset($name)
	{
		unset($this->configs[$name]);
    }
}
?>