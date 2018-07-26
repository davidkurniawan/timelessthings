<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


if (!function_exists('get_called_class')):

  function get_called_class()
  {
    $bt = debug_backtrace();
    $lines = file($bt[1]['file']);
    preg_match('/([a-zA-Z0-9\_]+)::'.$bt[1]['function'].'/',
               $lines[$bt[1]['line']-1],
               $matches);
    return $matches[1];
  }

endif;

class Object extends ObjectBase
{
	public  function __construct($properties = null, $lockProperties=false)
	{
		parent::__construct($properties , $lockProperties);
	}
}
class ObjectSingleton extends ObjectBase
{
	public static function getInstance()
    {
		static $instance;
		$called_class = get_called_class();
		
		if (! isset ($instance)) {
            $instance = new $called_class();
        } 
		return $instance;
    }
}
/*
class ObjectSingleton extends ObjectBase
{
	public static function getInstance()
    {
		static $instance = array();
		$called_class = get_called_class();
		
		if (! isset ($instance[$called_class])) {
            $instance[$called_class] = new $called_class();
        } 
		return $instance[$called_class];
    }
}*/

//abstract
class ObjectBase
{
   	protected $properties          = array();
	protected $readonlyProperties = array();
	protected $autoset = true;
	
	protected  function __construct($properties = null, $readonly=false, $autoCreateProp=true)
	{
		if(is_array($properties)) 
		{
			$this->properties = $properties;
			if($readonly)
			{
				$this->lockProperties();
			}
		}
		$this->autoset = $autoCreateProp;
		$this->init();
	}
	//protected function onDestruction(){}
	
	protected function init()
	{
	
	}
	protected function lockProperties()
    {
		$this->readonlyProperties = array_keys($this->properties);
	}
	protected function unlockProperties()
    {
		$this->readonlyProperties = array();
	}
	protected function lockProperty($name)
    {
		$this->readonlyProperties[]=$name;
	}
	protected function unlockProperty($name)
    {
		if(false !== $index = array_search($name, $this->readonlyProperties))
		{ 
			array_splice($this->readonlyProperties,$index,1);
		}
	}
	public function getProperties()
    {
		return $this->properties;
	}
	public function getProperty($name)
    {
		if (array_key_exists($name,$this->properties)) 
		{
			return $this->properties[$name];
		}else
		{
			$method = 'get__' . $name;
			if(method_exists($this, $method))
			{
				return $this->$method();
			}
		}
		return null;
    }
  	public function __get($name)
    {
		return $this->getProperty($name);
    }
	
    public function __set($name, $value)
    {
		$method = 'set__' . $name;
		if(method_exists($this, $method))
		{
			$this->$method($value);
		}else
		{
			if(array_key_exists($name,$this->properties)) 
			{
				if(in_array($name,$this->readonlyProperties))
				{
					trigger_error(sprintf("Can not set read only property '%s::$name'", get_class($this)), E_USER_ERROR);
				}else
					$this->properties[$name] = $value;
			}else
			{
				if(method_exists($this, 'get__' . $name))
				{
					trigger_error(sprintf("Can not set read only property %s::$name'", get_class($this)), E_USER_ERROR);
				}else
				{
					if($this->autoset)
					{
						$this->properties[$name] = $value;
					}else
					{
						trigger_error(sprintf("Undefined object property '%s::$name'", get_class($this)), E_USER_ERROR);
					}
				}
			}
		}
    }
	
	public function __isset($name) 
	{
        return isset($this->properties[$name]);
    }
    public function __unset($name) 
	{
       if(!in_array($this->readonlyProperties)) 
	   { 
			unset($this->properties[$name]);
	   }
    }
}

?>