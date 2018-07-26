<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

class MetaData
{
	public static function getItems($scope,$key=null,$status=null)
	{
		$rows = array();
		$status = $status === null?'': 'status=' .intval($status) . ' and';
		$_scope = is_array($scope)? "scope IN('"  .implode("','",$scope)  ."')":"scope='$scope'";
		if( $result = App::$database->query(
		"SELECT * FROM #__metadata WHERE $_scope " . (empty($key)?'':" AND meta_key='".$key."'")
		))
		{
			while($row = App::$database->fetchAssoc($result))
			{
				$data = $row['meta_value'];
				$rows[$row['meta_key']] = Helper::isArraySerialized($data)? unserialize($data):$data;
			}
		}
		return $rows;
	}
	
	public static function getConfigs()
	{
		$rows = array("termPaths"=>array(),"categoryParent"=>array());
		if( $result = App::$database->query(
			"SELECT term.*, ctype.name,ctype.module,ctype.isCategory,ctype.haveSubCategory,ctype.haveContent
			FROM #__terms as term 
			INNER JOIN #__content_types as ctype
			on term.contentType = ctype.name
			WHERE term.parent=0 AND term.contentType<>'tag' AND term.status=1"
		)){
			$paths = array();
			while($row = App::$database->fetchAssoc($result))
			{
				$name = $row['pathName'];
				
				if($row['isCategory'])
				{
					$paths["/(?<categoryName>$name+)(?<pageIndex>(|/([0-9]+)))"] = $row['module'];
					if($row['haveSubCategory'])
					{
						$rows['categoryParent'][$name] = $row;
						$paths["/(?<categoryName>$name+)/(?<subCategoryName>([a-z0-9\-]+))(?<pageIndex>(|/([0-9]))+)"]     = $row['module'];
						if($row['haveContent']){
							$paths["/(?<categoryName>$name+)/(?<subCategoryName>([a-z0-9\-]+))/(?<contentName>([a-z0-9\-])+)"] = $row['module'];
						}
					}else
					{
						if($row['haveContent']){
							$paths["/(?<categoryName>$name+)/(?<contentName>([a-z0-9\-]+))"] = $row['module'];
						}
					}
				}else{
					$paths["/(?<pathName>$name+)"] = $row['module'];
				}
			}
			$rows['termPaths']   = $paths;
		}
		
		if( $result = App::$database->query(
			//"SELECT * FROM #__metadata WHERE scope IN('config','hook') order by ordering"
			"SELECT * FROM #__metadata WHERE scope ='config'"
		))
		{
			$hooks = array();
			while($row = App::$database->fetchAssoc($result))
			{
				$meta_key  = $row['meta_key'];
				$data = $row['meta_value'];
				if($row['scope'] == 'hook')
				{
					if( !isset($rows[$data])){
						$rows[$data] = array();
					}
					$rows[$data][$meta_key] = $rows[$status];
				}else{
					$rows[$meta_key] = Helper::isArraySerialized($data)? unserialize($data):$data;
				}
			}
		}
		return $rows;
	}
	
	public static function getDataRowById($id,$status=null)
	{
		 $status = $status === null?'': 'status=' .intval($status) . ' and';
		 if($row = App::$database->getDataRow("SELECT * FROM #__metadata WHERE $status id=".$id))
		 {
			if(Helper::isArraySerialized($row['meta_value']))
				$row['meta_value'] = unserialize($row['meta_value']);
			return $row;
		 }
		 return false;
	}
	public static function getDataRow($scope,$key,$status=null)
	{
		$status = $status === null?'': 'status=' .intval($status) . ' and';
		 if($row = App::$database->getDataRow("SELECT * FROM #__metadata WHERE $status scope='".$scope."' AND meta_key='".$key."'"))
		 {
			if(Helper::isArraySerialized($row['meta_value']))
				$row['meta_value'] = unserialize($row['meta_value']);
			return $row;
		 }
		 return false;
	}
	public static function getValue($scope,$key,$default=null)
	{
		 if($row= App::$database->getDataRow("SELECT meta_value FROM #__metadata WHERE scope='".$scope."' AND meta_key='".$key."'"))
		 {
		 	$data = $row['meta_value'];
			return Helper::isArraySerialized($data)? unserialize($data):$data;
		 }
		 return $default;
	}
	public static function addValue($scope,$key,$value)//, $status = 0, $plugin_id = 0, $ordering = 0)
	{
		$data = is_array($value)? serialize($value):$value;
		App::$database->insertRow('#__metadata',
		array(
			'scope'=>$scope, 
			'meta_key'=>$key, 
			'meta_value'=>$data,
			//'status'  =>$status,
			//'plugin_id' => $plugin_id,
			//'ordering' => $ordering,
		));
		return App::$database->insertId();
	}
	public static function update($scope,$oldkey, $newkey, $value=null)
	{
		return self::_update($value, "scope='{$scope}' AND meta_key='{$oldkey}'",$newkey);
	}
	public static function updateValue($scope,$key,$value, $autoinsert=true)
	{
		$affected_rows = self::_update($value, "scope='{$scope}' AND meta_key='{$key}'");
		if(empty($affected_rows) &&  $autoinsert)
		{
			if(!App::$database->getDataRow("SELECT * from #__metadata where scope='{$scope}' AND meta_key='{$key}'"))
			{
				self::addValue($scope,$key,$value);
			}
			return 1;
		}
		return $affected_rows;
	}
	public static function updateStatus($status,$arg1,$arg2=null)
	{
		$where = is_null($arg2)? "id=$id" : "scope='{$scope}' AND meta_key='{$key}'";
		App::$database->updateRows('#__metadata', array('status'=> $status) ,$where);
	}
	public static function updateValueById($id,$value)
	{
		return self::_update($value, 'id='.$id);
	}
	public static function deleteItem($scope,$key)
	{
		return self::delete("scope='{$scope}' AND meta_key='{$key}'");
	}
	public static function deleteItemById($id)
	{
		return self::delete("id=$id");
	}
	
	public static function delete($filter)
	{
		App::$database->deleteRows('#__metadata',$filter);
		return App::$database->affectedRows();
	}
	private static function _update($value, $filter, $key=null)
	{
		$datarow=array();
		if(!is_null($value)){
			$data = is_array($value)? serialize($value):$value;
			$datarow['meta_value']=$data;
		}
		if(!is_null($key))
			$datarow['meta_key']=$key;
			
		$r = App::$database->updateRows('#__metadata', $datarow ,$filter);
		return App::$database->affectedRows();
	}
}
?>