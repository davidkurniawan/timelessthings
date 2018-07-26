<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Author URI: http://shapetherapy.com/
Copyright 2008-2010 by wildan
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Taxonomy
{

	public static function getCategoriesByParent($name, $published_only=false)
	{
		$section =  App::$config->categoryParent[$name];
		return self::getCategoriesByParentId($section['id'], $published_only);
		
	}
	public static function getCategoriesByParentId($id, $published_only=false)
	{
		return app::$database->getObjects("SELECT * FROM #__terms WHERE ". ( $published_only?"status=1 and ":"") ."parent=" . $id  . " order by ordering");
	}
	
	public static function getCategoriesByContentType($contentType, $published_only=false)
	{
		return app::$database->getObjects("SELECT * FROM #__terms WHERE contentType='$contentType'". ( $published_only?" AND status=1":"") . " order by ordering");
	}

/*
	public static function getCategoriesByPathName($pathname, $published_only=false, $return_obj=false)
	{
		$path =  App::$database->escape($pathname .'/') . '%';
		$sql  = "SELECT * FROM #__terms where ". ($published_only?'status=1 AND':'')." pathName='$pathname'  or basepath like '$path'  order by  ordering";
		return $return_obj?App::$database->getHierarchicalObjectRows($sql): App::$database->getHierarchicalDataRows($sql);
	}
	public static function getCategoriesByContentType($contentType=null, $published_only=false, $return_obj=false)
	{
		$sql  = 'SELECT * FROM #__terms'  . (is_null($contentType)?'':' where '. ($published_only?'status=1 AND':'').' content_type=\'' . $contentType . '\'  order by ordering ASC, title ASC');
		return $return_obj?App::$database->getHierarchicalObjectRows($sql): App::$database->getHierarchicalDataRows($sql);
	}
	public static function getCategoryById($id)
	{
		return App::$database->getObjectRow("SELECT * FROM #__terms where id=$id");
	}
	public static function getCategoriesById($id, $published_only=false, $return_obj=false)
	{
		if($path = self::getCategoryById($id))
		{
			return self::getCategoriesByBasepath($path->basepath, $published_only, $return_obj);
		}
		return false;
	}
	public static function getCategoryChilds($id, $published_only=false, $return_obj=false)
	{
		$filter = is_string($id) ? "basepath like '". App::$database->escape($id)."/%'":"parent=$id";
		$sql  = "SELECT * FROM #__terms where ". ($published_only?'status=1 AND':'')." $filter  order by  ordering";
		return $return_obj? App::$database->getObjectRows($sql):  App::$database->getDataRows($sql);
		
	}
	public static function select($filter, $return_obj=false)
	{
		return App::$database->getObjectRows("SELECT * FROM #__terms where $filter  order by  ordering");
	}
	public static function getIdList($id ,$published_only=false)
	{
		if($obj = self::getCategoryById($id))
		{
			$path =  App::$database->escape($obj->basepath .'/') . '%';
			if($rows =  App::$database->getObjectRows("SELECT id FROM #__terms where ". ($published_only?'status=1 AND':'')." basepath='".$obj->basepath."'  or basepath like '$path'  order by  ordering"))
			{
				$array = array();
				foreach($rows as $value)
				{
					$array[]=  $value->id;
				}
				return implode(',',$array);
			}
		}
		return false;
	}
	*/
}

?>