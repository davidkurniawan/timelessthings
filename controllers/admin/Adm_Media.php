<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Adm_Media extends Adm_Base
{
	protected 
		$items;
		
		
	
	protected function onPostData($task)
	{
		$value   = @ $_REQUEST['value'];
		$id      = @ $_REQUEST['id'];
		if($id){
			
			if($task=="save_title")
			{
				if($value )
				{
					
					app::$database->updateRows("#__media",array("title"=>$value), "id=$id");
					echo "+OK";
				}
			}
			else if($task=="save_desc")
			{
				if($value )
				{
					app::$database->updateRows("#__media",array("description"=>$value), "id=$id");
					echo "+OK";
				}
			}
			else if($task=="save_credit")
			{
				//app::$database->updateRows("#__media",array("description"=>$value), "id=$id");
				$obj = app::$database->getActiveRecord("SELECT id,metaData FROM #__media WHERE id=$id");
				$array=array();
				if($obj->metaData)
				{
					$array = unserialize($obj->metaData);
				}
				$array["credit"] = $value;
				$obj->metaData = serialize($array);
				$obj->save();
				
				echo "+OK";
			}
		}
		
	}
	protected function onPageStart()
	{
		parent::onPageStart();
		
		$this->pageIndex = intval(@ $_GET['p'] );
		if($this->pageIndex <1) $this->pageIndex  =1;

		$mode   = @ $_REQUEST['mode'];
		$search = @ $_REQUEST['q'];
		$this->contentFilename = $this->templatePath  . '/media.php';
		$this->title = 'Media Library';
		$filter = "";
		
		if($this->groupType)
		{
			$this->title .=  ' / '. ucfirst($this->groupType);
			/*
			if($this->groupType=='images'){
				$filter = "item.extension in('jpg','png') AND";
			}else{
				$filter = "item.extension not in('jpg','png') AND";
			}*/
		}
		
		if($search)
		{
			$words = Helper::searchWords($search);
			if(count($words)>0){
				foreach($words as $value){
					$wheres[] = "item.title like '%".app::$database->escape($value)."%'";
				}
				$filter .= implode(' AND ', $wheres) . ' AND ';
			}
		}
			
		$this->items = array();
		$this->dataview = new DataView();
		$this->dataview->pageIndex  = $this->pageIndex;
		$this->dataview->strOrderBy = 'item.datePosted DESC';
		$this->dataview->queryPages( 
		"SELECT item.*, user.name as posterName FROM #__media as item 
		LEFT JOIN #__users as user ON item.posterId = user.id WHERE $filter item.mediaType in('library','product')"
		,18);
		
		if($mode!='dialog_content')
		{
			while ($row =  $this->dataview->fetchAssoc())
			{
				$ext = $row['extension'];
				if($ext=='jpg' || $ext=='png')
				{
					$row['thumbnailUrl'] = ImageDocument::getThumbnailUrl($row['name'] . ".". $row['extension'],$row['mediaType'] );
				}
				$row['metaData'] = $row['metaData']?unserialize($row['metaData']):array();
				$this->items[] = new Object($row);
			}
		}else
		{
			while ($row =  $this->dataview->fetchAssoc())
			{
				$row['metaData'] = $row['metaData']?unserialize($row['metaData']):array();
				Adm_Media::htmlDialogMediaItem($row);
			}
			if($this->pageIndex	< $this->dataview->pageLength)
			{
				?>
				<div class="dlg-load-more">
					<button class="button default" 
                    onclick="$.mediaDialog._loadmore(this, <?php echo ($this->pageIndex+1) ?>)"><i class="icon icon-chevron-down"></i>Load More</button>
				</div>
				<?php
			}
			exit;
		}
	}
	public static function htmlDialogMediaItem($row)
	{
		$row['filename'] =Helper:: makeFilename($row['name'],$row['extension']);
?>
	<div>
    	<div class="dlg-media-item" onclick="$.mediaDialog._select(this)" data-file='<?php echo json_encode($row) ?>'>
            <div>
            	<?php
				$ext = $row['extension'];
				if($ext=='jpg' || $ext=='png' || $ext=='gif' )
				{
					$url = ImageDocument::getThumbnailUrl($row['filename'],$row['mediaType'] );
				?>
            	<img style="background-image:url(<?php echo $url ?>)" class="media-thumb" src="<?php echo app::$page->templateUrl ?>/img/media_thumb.png" />
                <?php } else { ?>
                <img class="media-thumb file <?php echo $ext ?>" src="<?php echo app::$page->templateUrl ?>/img/media_thumb.png" />
                <?php } ?>
                <div class="media-item-ribon"><?php echo $ext ?></div>
                <div class="media-item-title ellipsis" id="mediaTitle<?php echo $row['id'] ?>">
                    <?php echo $row['title'] ?>
                </div>
            </div>
        </div>
    </div>
<?php
	}
}

?>