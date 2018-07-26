<?php

class Validator
{
	
	private static $errFields = array();
	private static function notEmpty($postname)
	{
		if(isset($_POST[$postname]) )
		{
			if($_POST[$postname] == '')
			{
				self::$errFields[$postname] = '';
				return false;
			}
			return true;
		}
		return false;
	}
	
	public static function setError($postname, $msg='')
	{
		self::$errFields[$postname] = $msg;
	}
	
	public static function getValue($postname, $defaultValue='')
	{
		if(isset($_POST[$postname]) ){
			return  $_POST[$postname];
		}
		return $defaultValue;
	}
	public static function getNumber($postname, $defaultValue=0)
	{
		if(isset($_POST[$postname]) ){
			return  intval($_POST[$postname]);
		}
		return $defaultValue;
	}
	
	
	/////////////////////////////
	public static function validateText($postname, $minlength=1, $maxlength = 2147483647)
	{
		if(!self::errText($postname, $minlength, $maxlength)){
			return $_POST[$postname];
		}
		return null;
	}
	public static function validateEmail($postname,$defaultValue='')
	{
		if(!self::errEmail($postname)){
			return  $_POST[$postname];
		}
		return null;
	}
	public static function validatePhoneBumber($postname,$defaultValue='')
	{
		if(!self::errPhoneNumber($postname)){
			return  $_POST[$postname];
		}
		return null;
	}
	
	public static function validateNumber($postname,$defaultValue=0, $min=null, $max=null)
	{
		if(!self::errNumber($postname,$min, $max)){
			return  $_POST[$postname];
		}
		return null;
	}
	public static function validateDateIso($postname,$defaultValue='')
	{
		if(!self::errDateIso($postname)){
			return  $_POST[$postname];
		}
		return null;
	}
	
	public static function containErrors()
	{
		return count(self::$errFields);
	}
	public static function release()
	{
		if(self::$errFields){
			App::$page->addScript('VALIDATOR_ERROR_FIELDS =' . json_encode(self::$errFields) . ';');
			return false;
		}
		return true;
	}
	
	/////////////////////////////
	private static function errText($postname, $minlength=1, $maxlength = 2147483647)
	{
		if(self::notEmpty($postname)){
			$_POST[$postname] = trim($_POST[$postname]);
			$len = strlen($_POST[$postname]);
			if( !($len>= $minlength && $len<= $maxlength) )
			{
				self::$errFields[$postname] ='';
			}else
				return false;
		}
		return true;
	}
	private static function errEmail($postname)
	{
		if(self::notEmpty($postname))
		{
			if(!Helper::isEmail($_POST[$postname]))
			{
				self::$errFields[$postname] ='';
			}else
				return false;
		}
		return true;
	}
	private static function errNumber($postname,$min=null, $max=null)
	{
		if(self::notEmpty($postname))
		{
			$num = $_POST[$postname];
			if(!is_numeric($num))
			{
				self::$errFields[$postname] ='';
			}else{
				if(is_numeric($min)){
					if($num < $min){
						self::$errFields[$postname] ='';
						return true;
					}
				}
				if(is_numeric($max)){
					if($num > $max){
						self::$errFields[$postname] ='';
						return true;
					}
				}
				return false;
			}
		}
		return true;
	}
	private static function errPhoneNumber($postname)
	{
		if(self::notEmpty($postname))
		{
			if( preg_match('#^((\+[1-9])|0+)([0-9]+)$#i',$_POST[$postname]))
			{
				return false;
			}else{
				self::$errFields[$postname] ='';
				return true;
			}
		}
		return true;
	}
	private static function errDateIso($postname)
	{
		if(self::notEmpty($postname))
		{
			if( preg_match('#^(?<y>[0-9]{4}+)-(?<m>[0-9]{2}+)-(?<d>[0-9]{2}+)$#i',$_POST[$postname], $m))
			{
				if( !($m['y'] >1900  && (intval($m['m'])>0 &&  intval($m['m'])<=12) && (intval($m['d'])>0 &&  intval($m['d'])<=31)) ){
					self::$errFields[$postname] ='';
					return true;
				}
			}
			return false;
		}
		return true;
	}
	////////////////////
}
?>