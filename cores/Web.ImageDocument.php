<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class ImageDocument extends Document
{

	protected 
		$srcFile,
		$cacheFile;

	private function caching_headers($file,$timestamp)
	{
		$gmt_mtime=gmdate('r', $timestamp);
		header('ETag: "'.md5($timestamp.$file).'"');
		
		$ifModifSince = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']);
		
		$ifNoneMatch = isset($_SERVER['HTTP_IF_NONE_MATCH']);
		if($ifModifSince || $ifNoneMatch){
			$a=false;$b=false;
			if($ifModifSince){$a = $ifModifSince == $gmt_mtime;}
			
			if($ifNoneMatch){$b = str_replace('"','',stripslashes( $ifNoneMatch))== md5($timestamp.$file);}
			if ($a || $b)
			{
				header('HTTP/1.1 304 Not Modified');
				exit();
			}
		}
		return $gmt_mtime;
	}
	public static function getThumbnailUrl($filename, $mediaType = 'library')
	{
		return self::getImageUrl($filename, $mediaType,"t" . app::$config->thumbnailSizeVersion);
	}
	public static function getMediumSizeUrl($filename, $mediaType = 'library')
	{
		return self::getImageUrl($filename, $mediaType,"m");
	}
	public static function getLargeSizeUrl($filename, $mediaType = 'library')
	{
		return self::getImageUrl($filename, $mediaType,"l");
	}
	public static function getImageUrl($filename,$mediaType = 'library',$pathName='')
	{
		return Request::$baseUrl . '/'. MEDIA_PATH .'/' . $mediaType .'/' . (empty( $pathName )?'': $pathName . '/') . (empty($filename)?'no-photo.jpg':$filename);
	}
	
	protected function generateCache($size)
	{
		$srcimage = Image::fromFile($this->srcFile);
		if( $size[0] >0 && $size[1]<=0)
		{
			$image  = $srcimage->fitToWidth($size[0]);
		}
		else if( $size[0]<=0 && $size>=0)
		{
			$image  = $srcimage->fitToHeight($size[1]);
		}
		else
		{
			$crop = @ $size[2];
			
			if($crop != 'crop')
			{
				$image  = $srcimage->fitToMaxSize($size[0],$size[1]);
			}else
			{
				$image  = $srcimage->cropTo($size[0],$size[1]);
			}
			
		}
		if($image)
		{
			$image->save($this->cacheFile);
			//echo $this->cacheFile; exit;
			//exit;
			if($image->type==IMAGETYPE_PNG)
			{
				imagepng($image->image);
			}else{
				imagejpeg($image->image,null,90);
			}
		}

	}

	protected function onPageStart()
	{
		
		if(!is_dir(IMAGES_CACHE_PATH)){
			mkdir(IMAGES_CACHE_PATH) or $this->error("Can not create cache directory");
		}
		$this->srcFile   = MEDIA_PATH .'/' . $this->mediaType .'/' . $this->fileName .'.'. $this->ext;
		$cache_prefix    = str_replace('/','_',$this->size);
		$this->cacheFile = IMAGES_CACHE_PATH . '/' . $cache_prefix .'-' .  $this->fileName .'.'. $this->ext;

		
		if($sizeinfo = @ app::$config->imageSizeOptions[$this->size])
		{
			$sise_str = is_array($sizeinfo) ? $sizeinfo[count($sizeinfo)-1] : $sizeinfo;
			$size = explode('|',$sise_str);
			
			header('Expires: ' . gmdate('r', time() + 315359944) . " GMT");
			header('Cache-control: public, max-age=315359944' );
			header('Content-type: image/' . $this->ext);
			//header("Pragma: private");
	
			if(is_file( $this->srcFile ))
			{
				$cachegen = false;
				if(is_file( $this->cacheFile ))
				{
					
					$filemtime = filemtime($this->cacheFile);
				}else{
					$filemtime = filemtime($this->srcFile);
					
					$cachegen  = true;
				}
				//$cachegen  = true;
				if(!$cachegen)
				{
					header('ETag: "'.md5($filemtime.$this->srcFile).'"');
					$ifNoneMatch  = @ $_SERVER['HTTP_IF_NONE_MATCH'];
					$ifModifSince = @ $_SERVER['HTTP_IF_MODIFIED_SINCE'];
					
					$a=false;$b=false;
					if($ifModifSince){
						$a = strtotime($ifModifSince) == $filemtime;
					}
					if($ifNoneMatch){
						$b = str_replace('"','',stripslashes( $ifNoneMatch))== md5($filemtime.$this->srcFile);
					}
					if ($a || $b) 
					{
					  //header('Last-Modified: '.gmdate('D, d M Y H:i:s', $filemtime).' GMT', true, 304);
					  header('HTTP/1.1 304 Not Modified');
					  exit;
					}
					header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $filemtime) . ' GMT');
					
					//readfile ($this->cacheFile);
					$im = Image::fromFile($this->cacheFile);
					if($im->type==IMAGETYPE_PNG)
					{
						imagepng($im->image);
					}else{
						imagejpeg($im->image,null,90);
					}
		
				}else{
					header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $filemtime) . ' GMT');
					$this->generateCache($size);
				}
			}
		}
	}
}

?>