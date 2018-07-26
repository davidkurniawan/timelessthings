<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Lang
{
	public  static $items       = array();
	private static $addedCtype  = array();
	
	public static function hasConversation($ctype='')
	{
		return empty($name)?count(self::$addedCtype): in_array($ctype, self::$addedCtype);
	}
	public static function addConversation($ctype)
	{
		if(!in_array($ctype, self::$addedCtype))
		{
			$filename = 'lang/' . App::$locale->language . '/' . $ctype . '.php';
			if(is_file($filename))
			{
				require_once($filename);
				$arr = "lang_$ctype";
				self::$items =  array_merge(self::$items, $arr);
				self::$addedCtype[]= $ctype;
			}
		}
	}
}
?>