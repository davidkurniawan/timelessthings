<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

class UploadDocument extends JsonDocument
{
	private 
		$isWebImage    = false,
		$timeUploaded  = null,
		$savedFilename = null;
		
	protected 
		$targetPath,
		$mediaType      = 'library',
		$mediaOwner     = 0,
		$mediaStatus    = 1,
		$mediaData,
		$mediaAllowedTypes = null,
		$saveName       = "",
		$maxImageWidth  = 1920,
		$maxImageHeight = 1080;
	
	public static function delete($id,  $filename , $mediatype='library', $dirname=null)
	{
		if(empty($dirname))
		{
			$dirname = MEDIA_PATH . '/' . $mediatype;
		}
		app::$database->deleteRows("#__media", "id=" . $id);
		@ unlink( $dirname.'/'.$filename );
		foreach(app::$config->imageSizeOptions as $key=>$value)
		{
			if(app::$config->imageCache)
			{
				$prefix = str_replace( '/','-', $key);
				@ unlink('cache/images/'. $prefix . '-' . $filename);
			}else{
				@ unlink($dirname.'/' . $prefix . '-' . $filename);
			}
		}
		
	}
	
	protected function onPageStart()
	{
		parent::onPageStart();
		if(!app::$session->authenticated)
			Response::unauthorized();
	
		$this->timeUploaded = time();
		
		if(Request::isPost())
		{
			if(!isset($this->targetPath))
			{
				$this->targetPath =  MEDIA_PATH . '/' . $this->mediaType;
			}
			$this->createTargetPath();
			$this->uploadinit();
		}else{
			Response::badRequest();
		}
	}
	private function createTargetPath()
	{
		if(!file_exists($this->targetPath))
		{
			 mkdir($this->targetPath) or $this->error("Can not create media directory");
		}
	}

	private function uploadinit()
	{
		$postedFiles  = Request::getFiles();
		
		
		if(count($postedFiles)>0)
		{
			$file = $postedFiles[0];
			
			if($file->error==UPLOAD_ERR_OK)
			{
				if($this->mediaAllowedTypes)
				{
					if(!preg_match('#(' . $this->mediaAllowedTypes . ')#ig',$file->extension))
					{
						$this->error("Invalid file type");
					}
				}
				
				$this->processFile($file);
			}
			else if($file->error==UPLOAD_ERR_INI_SIZE)
			{
				$this->error("File size exceeds the maximum allowed");
			}else
			{
				$this->error("Unexpected Error [".$file->error."]");
			}
		}else{
			$this->error("File size exceeds the maximum allowed");
		}
	}
	protected function saveImage($image,$destination, $extension)
	{
		if($extension =='png')
		{
			if($image->saveToPng($destination)){
				$this->savedFilename = $destination;
				return true;
			}
		}else{
			if($image->saveToJpeg($destination ,90)){
				$this->savedFilename = $destination;
				return true;
			}
		}
		return false;
	}
	protected function moveUploadedFile($file, $destination)
	{
		
		if( $file->move( $destination ))
		{
			$this->savedFilename = $destination;
			return;
		}else{
		}
		$this->error("Can not move uploaded file");
	}
	protected function onFileUploaded($file)
	{
		
		$safefilename = ($this->saveName)?$this->saveName: Helper::safeUrlText($file->basename);
		
		$destination = $this->targetPath . '/' . Helper::makeFilename($safefilename, $file->extension); 
		if(is_file($destination))
		{
			$safefilename .= '-'. $file->uniqueName;
			$destination = $this->targetPath . '/' . Helper::makeFilename($safefilename, $file->extension); 
		}

		if( preg_match('#(jpg|gif|png)#',$file->extension))
		{
			
			if($file->extension !='gif')
			{
				$this->isWebImage = true;
				if($size = @ getimagesize($file->tmp_name))
				{
					$meta_data = array("width"=>$size[0],"height"=>$size[1]);
				}else
					$this->error("Invalid image file");
				
				if( ($this->maxImageWidth >0  && $this->maxImageWidth< $meta_data["width"])
				||  ($this->maxImageHeight >0 && $this->maxImageHeight< $meta_data["height"])
				){
					
					if($srcimage = Image::fromFile($file->tmp_name))
					{	
						if( $this->maxImageWidth>0 && $this->maxImageHeight<=0)
						{
							$image  = $srcimage->fitToWidth($this->maxImageWidth);
						}
						else if( $this->maxImageWidth<=0 && $this->maxImageHeight>0)
						{
							$image  = $srcimage->fitToHeight($this->maxImageHeight);
						}
						else
						{
							$image  = $srcimage->fitToMaxSize($this->maxImageWidth,$this->maxImageHeight);
						}
						if($image =  $srcimage->fitToWidth($this->maxImageWidth))
						{
							
							if($this->saveImage($image, $destination, $file->extension))
							{
								$this->mediaData->name       = $safefilename;
								$this->mediaData->meta_data=array("width"=>$image->width,"height"=>$image->height);
								$this->mediaData->fileSize   = filesize($destination);
								return;
							}
						}
						$this->error("Can not create image file");
					}else
					{
						$this->error("Invalid image file");
					}
				}
			}
			
			$this->mediaData->metaData = $meta_data;				
		}
		
		$this->mediaData->name       = $safefilename;
		$this->mediaData->fileSize   = $file->size;
		
		$this->moveUploadedFile($file, $destination);
	}
	
	
	protected function onMediaData($file)
	{
		$this->mediaData = new ActiveRecord('#__media',null ,"id");
		$this->mediaData->extension  = $file->extension;
		$this->mediaData->mediaType = $this->mediaType;
		$this->mediaData->owner      = $this->mediaOwner;
		$this->mediaData->title      = $file->basename;
		$this->mediaData->status     = $file->mediaStatus;
		//$this->mediaData->name       = $file->uniqueName;
		//$this->mediaData->fileSize   = $file->size;
		$this->mediaData->datePosted = date('Y-m-d H:i:s',$this->timeUploaded);
		$this->mediaData->posterId   = app::$session->user->id;
		
	}
	private function processFile($file)
	{

		$this->onMediaData($file);
		$this->onFileUploaded($file);
		
		if(!$this->mediaData->save())
		{
			$this->error("Can not save upload data entry");
		}
		
		$this->onOutputData($file);
	}
	

	protected function error($err)
	{
		if( $this->savedFilename){
			@ unlink($this->savedFilename);
		}
		parent::error($err);
	}
	protected function onOutputData()
	{
		$this->output->dataFile  = $this->mediaData->datarow;
		$this->output->url       = Request::$baseUrl . '/' . $this->targetPath .'/' . $this->mediaData->name . '.' . $this->mediaData->extension;
		if($this->isWebImage)
		{
			$this->output->thumbnailUrl  = ImageDocument::getThumbnailUrl($this->mediaData->name . '.' . $this->mediaData->extension,$this->mediaType); 
		}
	}
}

?>