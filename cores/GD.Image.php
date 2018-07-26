<?php

class Image// extends Object
{
	
	public 
		$width,
		$height,
		$type,
		$mime,
		$trueColor,
		//$imageType,
		$image;
	
	protected  function __construct($width,$height, $image_data=null, $truecolor = true, $type = IMAGETYPE_JPEG)
	{
		$this->width  = $width;
		$this->height = $height;
		$this->type   = $type;
		if(is_null($image_data))
		{
			$this->trueColor = $truecolor;
			$this->image     = $truecolor? imagecreatetruecolor($width,$height):imagecreate($width,$height);
		}else
		{
			$this->image = $image_data;
			$this->trueColor = imageistruecolor($this->image);
		}
	}
	public  function saveToJpeg($filename,$quality=90)
	{
		return imagejpeg ($this->image, $filename,$quality);
	}
	public  function saveToPng($filename)
	{
		return imagepng ($this->image,$filename);
	}
	public  function saveToGif($filename)
	{
		return imagegif ($this->image, $filename);
	}
	public  function save($filename,$quality=null)
	{
		
		if(is_numeric($quality))
		{
			return $this->saveToJpeg($filename,$quality);
		}
		else
		{
			if($this->type == IMAGETYPE_PNG) 
			{
				return $this->saveToPng($filename);
			}
			else if($this->type == IMAGETYPE_GIF)
			{
				return $this->saveToGif($filename);
			}
			else{
				return $this->saveToJpeg($filename,90);
			}
		}
	}
	
	public function rotate($degrees)
	{
		$newimg = imagerotate($this->image, $degrees, 0);
		return new Image(imagesx($newimg), imagesy($newimg), $newimg, $this->trueColor, $this->type); 
	}
	
	public function createCopyResampled($x,$y,$x2,$y2, $w,$h,$w2,$h2,$alphablending, $bgcolor = 0xFFFFFF)
	{
		$newimg = imagecreatetruecolor($w,$h);
		if($this->trueColor && $this->type == IMAGETYPE_PNG )
		{
			if(!$alphablending){
				imagefill($newimg, 1, 1, $bgcolor);
			}else{
				imagealphablending($newimg, false);
				imagesavealpha($newimg, true);  
				imagealphablending($this->image, true);
			}
		}
		imagecopyresampled(
			$newimg,
			$this->image,
			$x,$y,        // destination x,y
			$x2,$y2,      // source x,y
			$w, $h,       // destination w,h
			$w2,$h2       // source w,h
		);
		return new Image($w, $h, $newimg,$this->trueColor, $this->type);
	}
	private function getCropRect($destW, $destH,  $cropW,$cropH,$dock='center')
	{
		$r = array('x'=>0,'y'=>0,'w'=>0,'h'=>0);
		if($destW>$destH)
		{
			if($cropW>$cropH)
			{
				if( ($cropW / $cropH) > ($destW / $destH) )
				{
					$r['w']=$destW;
				}else{
					$r['h']=$destH;
				}
			}else
				$r['h']=$destH;
		}else
		{
			if($cropH>$cropW)
			{
				if( ($cropH / $cropW) > ($destH / $destW) )
				{
					$r['h']=$destH;
				}else{
					$r['w']=$destW;
				}
			}else
				$r['w'] = $destW;
		}
		if($r['h']==0)
			$r['h']=  floor (($r['w'] / $cropW ) * $cropH);
		if($r['w']==0)
			$r['w']=  floor (($r['h'] / $cropH ) * $cropW);
			

		$r['x']=   floor (( $destW - $r['w'] ) / 2);
		$r['y']=  floor (($destH - $r['h'] ) / 2);
		
		if($dock=='left'){$r['x']= 0;}
		if($dock=='top'){$r['y']= 0;}
		if($dock=='bottom'){$r['y']= $destH - $r['h'];}
		if($dock=='right'){$r['x']= $destW - $r['w'];}
		
		return $r;
	}
	public function fitToMaxSize($maxwidth,$maxheight, $stretch = false)
	{
		if($this->width > $this->height)
		{
			if($this->width <= $maxwidth && $stretch==false)
			{
				return $this;
			}else
				return  $this->fitToWidth($maxwidth);
		}else{
			if($this->height <= $maxheight && $stretch==false)
			{
				return $this;
			}else
				return  $this->fitToHeight($maxheight);
		}
	}
	public function fitToHeight($fit_height,$stretch=false,$alphablending=true)
	{
		if(!$stretch)
		{
			if($this->height < $fit_height)
				return $this;//->image;
		}
		$new_h = $fit_height;
		$new_w = intval(($new_h / $this->height )* $this->width);
		return $this->createCopyResampled(0,0,
			0,0,
			$new_w,$new_h,
			$this->width,$this->height, $alphablending
		);
	}
	public function fitToWidth($fit_width,$stretch=false,$alphablending=true)
	{
		if(!$stretch){
			if($this->width < $fit_width)
				return $this;
		}
		$new_w = $fit_width;
		$new_h = intval(($new_w / $this->width )* $this->height);
		return $this->createCopyResampled(0,0,
				0,0,
				$new_w,$new_h,
				$this->width,$this->height, $alphablending);

	}

	
	public function createThumbnail($cropW,$cropH , $dock='center')
	{
		return $this->cropTo($cropW,$cropH, $alphablending=false,$dock );
	}
	
	public function cropTo($cropW,$cropH ,$dock='center', $alphablending=false)
	{
		$cropRect  = $this->getCropRect($this->width, $this->height,  $cropW,$cropH,$dock);
		return $this->createCopyResampled(0,0,
			$cropRect['x'],$cropRect['y'],  
			$cropW, $cropH,                 
			$cropRect['w'],$cropRect['h'] , $alphablending 
		);
	}
	public function forcefitToBox($fit_size,$crop=true)
	{
		return $this->forcefitToSize($fit_size,$fit_size, $crop);
	}
	public function forceFitToSize($fit_w, $fit_h, $crop=true, $alphablending=false)
	{
			
		$x= 0; $y= 0;
		$new_w = $fit_w;
		$new_h = $fit_h;
		
		if ($this->height>$this->width)
		{
			//portrait
			$new_w = $this->width * ($fit_h/$this->height);
			$x = ($fit_w - $new_w)/2;
		}else{
			//landscape
			$new_h= $this->height * ($fit_w/$this->width);
			$y = ($fit_h -$new_h)/2;
		}
		
		$x=0;$y=0;
		$w = $new_w; $h= $new_h;
		return $this->createCopyResampled($x,$y,
			0,0,
			$new_w,$new_h,
			$this->width,$this->height,$alphablending
		);

	}

	static public  function create($width,$height, $trueColor = true)
	{
		return new Image($width, $height, null, $trueColor, $this->trueColor?IMAGETYPE_PNG: IMAGETYPE_GIF);
	}


	static public  function fromUrl($src)
	{
		$imggdata = file_get_contents($src);
		 $size = @ getimagesizefromstring ($imggdata);
		if($size)
		{
			//echo "1--";
			if ($size[2])
			{
				$img = imagecreatefromstring($imggdata);
				 
			}
			if(isset($img))
			{
				$imObj = new Image($size[0],$size[1],$img,null,$size[2]);
				return $imObj;
			}
		}
		return false;
	}
	static public  function fromFile($src, $size = null)
	{
		$size = @ getimagesize($src);
		
		 
		if($size)
		{
			switch ($size[2])
			{
				case IMAGETYPE_GIF: //image/gif 
					$img = imagecreatefromgif ($src);
					break;
				case IMAGETYPE_JPEG: //image/jpeg 
					$img = imagecreatefromjpeg ($src);
					break;
				case IMAGETYPE_PNG: //image/png 
					$img = imagecreatefrompng ($src);
					break;
					
			//	case IMAGETYPE_BMP: //image/bmp 
			//	case IMAGETYPE_WBMP: //image/vnd.wap.wbmp 
			//	case IMAGETYPE_XBM: //
	
			}
			if(isset($img))
			{
				$imObj = new Image($size[0],$size[1],$img,null,$size[2]);
				//$imObj->type = $size[2];
				return $imObj;
			}
		}
		return false;
	}
}
?>