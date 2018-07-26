<?php
class Adm_MediaUpload extends UploadDocument
{
	

	protected function onPageStart()
	{
		if(Request::isPost())
		{
			
			$task = @ $_POST['task'];
			if($task=='delete')
			{
				$this->deleteMedia();
			}
			else if($task=='status')
			{
				$id = @ $_POST['id'];
				$status = $_POST['status']==1?0:1;
				app::$database->updateRows("#__media",array("status"=>$status),"id=$id");
				echo "{}";
				exit;
			}
			else
			{
				
				$ref = @ $_REQUEST['ref'];
				$mediaType  =@ $_REQUEST['mtype'];
				$mediaOwner =@ $_REQUEST['owner'];
				
				if(isset($_REQUEST['status'])){
					
					$this->mediaStatus  = intval($_REQUEST['status']);
				}
				
				$this->fromDialog = $ref=='dialog';
				// $this->maxImageWidth  = 1920;
				// $this->maxImageHeight = 1920;
				$this->mediaType      = empty($mediaType)?'library': $mediaType;
				$this->mediaOwner     = empty($mediaOwner)? 0 : $mediaOwner;
				
				$this->saveName = @ $_REQUEST['forceFilename'];
				
				parent::onPageStart();
			}
		}
	}
	protected function onOutputData()
	{
		if(!$this->fromDialog)
		{
			parent::onOutputData();
		}else
		{	
			ob_end_clean();
			$this->output->dataFile = $this->mediaData->datarow;
			ob_start();
			Adm_Media::htmlDialogMediaItem(array(
			"name"=>$this->mediaData->name,
			"extension"=>$this->mediaData->extension,
			"mediaType"=>$this->mediaData->mediaType,
			"title"=>$this->mediaData->title
			));
			$this->output->html = ob_get_contents();
			ob_end_clean();
		}
	}
	protected function deleteMedia()
	{
		$id = @ $_POST['id'];
		if($id){
			if($obj = app::$database->getObject("SELECT * FROM #__media WHERE id=" . $id))
			{
				$filename = Helper::makeFilename($obj->name, $obj->extension); 
				UploadDocument::delete($id,  $filename,$obj->mediaType );
				$this->output = new stdClass();
				$this->output->deleteId=$id;
				return;
			}
		}
		Response::badRequest();
	}
}
?>
