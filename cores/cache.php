<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Cache
{
	const CACHE_NAME_CONFIG 		= 'App Configs';
	
	static public function exists($cache_name)
	{
		return file_exists(self::getFilename($cache_name)); 
	}
	static public function delete($cache_name)
	{
		@unlink(self::getFilename($cache_name));
		@unlink(self::getFilename($cache_name,'.var'));
	}
	static public function clear()
	{
		function __clearItemCallback($file)
		{
			@unlink ($file);
		}
		Folder::search(CACHE_PATH,'__clearItemCallback');
	}

	static public function getItems()
	{
		function __cacheItemCallback($file)
		{
			global $__cacheItem__;
			$__cacheItem__[] = unserialize(file_get_contents($file)); 
		}
		Folder::searchCallback(CACHE_PATH,'__cacheItemCallback','(.*)\.var+$');
		$retval = @ $GLOBALS['__cacheItem__'];
		if(!empty($retval))
		{
			unset($GLOBALS['__cacheItem__']);
			return $retval;
		}
		return false;
	}
	static public function getData($cache_name)
	{
		
		$file_name = self::getFilename($cache_name,'');
		if(file_exists($file_name . '.var'))
		{

			$info = @ unserialize(file_get_contents($file_name .'.var'));

			if( $info['expire'] <= 0 || ( time() <= $info['expire']) )
			{
				if($info['datatype']=='array')
				{
					return unserialize(file_get_contents($file_name . '.cache'));
				}else
					return file_get_contents($file_name .'.cache');
			}else
			self::delete($cache_name);
		}
		return false;
	}

	static public function putData($cache_name, $data , $expire = 0, $array_var_export='')
	{
		$info = array('name'=> $cache_name);
		$info['datatype']='text';
		
		
		
		if(is_array($data))
		{
			if(empty($array_var_export))
			{
				$data = serialize($data);
				$info['datatype']='array';
			}else{
				$data = "<?php\n \$" . $array_var_export . " = " . var_export($data,true) . ";\n?>";
			}
		}
		
		
		$info['expire'] = ($expire>0)? (time() + ($expire)):0;
		$file_name = self::getFilename($cache_name,'');
		
		
		
		@ file_put_contents($file_name . '.cache', $data);
		@ file_put_contents($file_name . '.var', serialize($info));
	}

	static public function getFilename($cache_name, $extension = '.cache')
	{
		return CACHE_PATH .DS . md5($cache_name) . $extension;
	}	
}
?>