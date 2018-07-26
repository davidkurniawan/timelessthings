<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////



class File
{
	public static function open($filename,$mode=0)
	{
		if( ($mode==0 && !is_readable($filename))){
			return false;
		}
		return new FileStream($filename,$mode);
	}
	public static function create($filename)
	{
		return self::open($filename,1);
	}
	public static function createTempFile()
	{
		return self::open(tmpfile(),1);
	}
	public static function createText($filename,$data)
	{
		return @ file_put_contents($filename,$data);
	}
	public static function appendText($filename,$data)
	{
		return @ file_put_contents($filename,$data, FILE_APPEND );
	}
	public static function delete($filename)
	{
		return @ unlink ($filename);
	}
	public static function copy($filename, $dest, $overwrite = true) 
	{
		if (!file_exists($filename) || is_file($dest) && !$overwrite) {
			return false;
		}
		return copy($filename, $dest);
	}
	public static function move($filename, $dest, $overwrite = true) 
	{
		if (!file_exists($filename) || is_file($dest) && !$overwrite) {
			return false;
		}
		if (copy($filename, $dest))
		{
			if(@ unlink ($filename))
			{
				return true;
			}else
				unlink ($dest);
		}
		return false;
	}
	public static function rename($newname)
	{
		if(file_exists($filename))
		{
			return @ rename($filename, $newname);
		}
		return false;
	}
	public static function getLastAccess($filename) 
	{
		return @ fileatime($filename);
	}
	public static  function getLastModified($filename) 
	{
		return @ filemtime($filename);
	}
	public static  function getLastChange($filename) 
	{
		return @ filectime($filename);
	}
	public static  function setLastModified($filename,$time=null) 
	{
		$time = empty($time)?time():$time;
		if(file_exists($filename))
		{
			$mtime = filemtime($filename);
			return touch($filename,$mtime,$time);
		}
		return false;
	}
	public static  function setLastAccess($filename,$time=null) 
	{
		$time = empty($time)?time():$time;
		if(file_exists($filename))
		{
			$atime = fileatime($filename);
			return touch($filename,$time,$atime);
		}
		return false;
	}
}

class Folder 
{
	public static function delete($dirname)
	{
		if(file_exists($dirname))
		{
			return @ rmdir ($dirname);
		}
		return false;
	}
	public static function rename($dirname, $newname)
	{
		return @ rename( $dirname, $newname);
	}
	public static function create($dirname,$mode=0777)
	{
		return mkdir($dirname,$mode);
	}
	public static function getFolders($path, $filter='')
	{
		$files = array();
		if ($handle = @ opendir($path)) 
		{
			while (false !== ($file = readdir($handle))) 
			{
				if ($file != "." && $file != "..") 
				{
					if( filetype(rtrim($path,'/').'/'.$file)=='dir')
					{
					
						$file = empty($filter)?$file : ( preg_match ('/'. $filter. '/i', $file) ?$file:false);
						if($file!==false)
						{
							$files[] =  $file;
						}
					}
				}
			}
			closedir($handle);
		}
		return $files;
	}
	
	public static function getFiles($path, $filter='',$includeSubDir=false, $callback=null, $ds = '/')
	{
		$files = array();
		if ($handle = opendir($path)) 
		{
			
			while (false !== ($file = readdir($handle))) 
			{
				if ($file != "." && $file != "..") 
				{
					$fullpath = $path.$ds.$file;
					if( filetype($fullpath)=='dir' && $includeSubDir)
					{
						if($callback)
							Folder::getFiles($fullpath, $filter,true,$callback);
						else
						{
							$retval = Folder::getFiles($fullpath, $filter,true,$callback);
							if(count($retval)>0)
							{
								$files= array_merge($files,$retval);
							}
						}
					}
					$file = empty($filter)?$file : (preg_match ('/'. $filter. '/i', $file)?$file:false);
					if($file!==false)
					{
						if(is_callable($callback))
							$callback($fullpath);
						else
							$files[] =  $fullpath;
					}
				}
			}
			
			closedir($handle);
		}
		if(is_null($callback))
			return $files;
	}
	

}
?>