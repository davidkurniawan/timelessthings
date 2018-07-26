<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Adm_Locations extends Adm_DataEntries
{
	protected 
	$content
	, $categories = array()
	, $featuredContent = true
	, $featuredImage   = true
	, $contentType     = 'location'
	, $upperHead = false
	, $isHaveCategories    = true;

	protected function onPageStart()
	{		
		
		$this->title = "Locations / Camp";
		if($terms = Taxonomy::getCategoriesByContentType($this->contentType,true))
		{
			
			
			if(count($terms)>0)
			{
				$this->categories = $terms;
				$this->isHaveCategories = count($terms)>1;
			}
		}
		parent::onPageStart();
	}
	protected function onDataview($statusFilter)
	{
		 $this->contentFilename = $this->templatePath  . '/location.php';
		 return "SELECT item.*, 
		 user.name as authorName,
		 term.pathName, 
		 term.title as categoryTitle , 
		 term.id as categoryId
		 FROM #__locations as item 
		 LEFT JOIN #__terms as term ON item.category = term.id 
		 LEFT  JOIN #__users as user ON item.authorId = user.id
		 WHERE ".(empty($statusFilter)? "": "$statusFilter AND") ." item.contentType='{$this->contentType}'";
	}
	protected function onDataviewAssoc(& $row){}
	
	protected function onEdit()
	{
		$this->addScript( $this->templateUrl . "/js/tinymce/tinymce.min.js");
		$this->contentFilename = $this->templatePath  . '/location-edit.php';
		
		$this->id = @ $_REQUEST['id'];
		if($this->id)
		{
			if(!($this->content = app::$database->getObject
			( (
					"SELECT item.*, user.name as authorName, term.pathName, term.title as categoryTitle , term.id as categoryId
					FROM #__locations as item 
					LEFT JOIN #__terms as term ON item.category = term.id 
					LEFT  JOIN #__users as user ON item.authorId = user.id
					WHERE item.id=" . $this->id
				)
			)))
			{
				Response::badRequest();
			}
		}else{
			Response::badRequest();
		}
		// $this->content->metaData  = empty($this->content->metaData)?array(): unserialize($this->content->metaData);
					
		$this->onEditContent();
	}
	protected function onNew()
	{
		$this->addScript( $this->templateUrl . "/js/tinymce/tinymce.min.js");
		$this->contentFilename = $this->templatePath  . '/location-edit.php';
		
		$this->content = new stdClass();
		$this->content->title    = "";
		$this->content->name     = "";
		$this->content->id       = 0;
		$this->content->category = 0;
		$this->content->picture  = "";
		$this->content->status   = 0;
		$this->content->body     = "";
		$this->content->address = "";
		$this->content->city = "";
		$this->content->longitude="";
		$this->content->latitude="";
		$this->content->direction="";	
		
		
		
		if($this->categories)
		{
			$this->content->pathName = 'uncategorized';
			$this->content->categoryTitle = "Uncategorized";
			
			if($this->isHaveCategories)
			{
				
			}else
			{
				$this->content->category = $this->categories[0]->id;
			}
		}
		
		$this->onNewContent();
		
	}
	protected function onNewContent(){}
	protected function onEditContent(){}
	protected function onUpdateContent(& $ar){}
	
	

	protected function onPostData($posttask)
	{
		if($posttask)
		{
			$id = @ $_POST['id'];
			if($posttask=='status')
			{
				$status = $_POST['status']==1?0:1;
				app::$database->updateRows("#__contents",array("status"=>$status),"id=$id");
				echo "{}";
			}
			else if($posttask=='featured')
			{
				$status = $_POST['status']==1?0:1;
				app::$database->updateRows("#__contents",array("featured"=>$status),"id=$id");
				echo "{}";
			}else if($posttask=='featured1')
			{
				$status = $_POST['status']==2?0:2;
				app::$database->updateRows("#__contents",array("featured"=>$status),"id=$id");
				echo "{}";
			}
			else if($posttask=='trash')
			{
				app::$database->updateRows("#__contents",array("status"=>2),"id=$id");
				echo "{}";
			}
			else if($posttask=='save')
			{
				$title = trim(@ $_POST['title']);
				$body  = trim(@ $_POST['body']);
				$name  = trim(@ $_POST['name']);
				
				
				if($title && $body)
				{
					$ar = new ActiveRecord("#__locations",null,'id');
					$ar->title   = ucwords($title);
					$ar->name    = Helper::safeUrlText( $name? $name: $ar->title);
					$ar->body    = $body;
					$ar->words   = @ implode(' ', Helper::wordsUnique( Helper::stripTags($ar->body)));
					if(isset($_POST['status'])){
						$ar->status  = $_POST['status'];
					}
					$ar->contentType  = $this->contentType;
					
					$ar->address = trim(@$_POST['address']);
					$ar->city = trim(@$_POST['city']);
					$ar->direction = trim(@$_POST['direction']);
					$ar->longitude = trim(@$_POST['longitude']);
					$ar->latitude = trim(@$_POST['latitude']);
					
				
					if(isset($_POST['picture']))
					{
						$ar->picture = basename($_POST['picture']);
					}
					if($id)
					{
						$ar->id             = $id;
						$ar->dateModified   = date('Y-m-d H:i:s');
						$ar->modifierId     = app::$session->user->id;
					}else
					{
						$ar->datePublished  = $ar->dateCreated  = $ar->dateModified = date('Y-m-d H:i:s');
						$ar->modifierId     = $ar->authorId  = app::$session->user->id;
					}
					if(isset($_POST['category']))
					{
						$ar->category = $ar->contentType=='page'?0:  $_POST['category'];
					}else{
						
						
						if($this->categories)
						{
							$ar->category = $this->categories[0]->id;
										
						}
						
					}
					
					
					$ar->metaData = array();
					
					/*$upperHead = trim(@ $_POST['upperHead']);
					if($upperHead){
						$ar->metaData['upperHead']= $upperHead;
					}*/
					
					$ar->metaData  = empty( $_POST['meta'])?array(): $_POST['meta'];
					$this->onUpdateContent($ar);
					
					$ar->metaData= serialize($ar->metaData);
					
					$ar->save();
					
					echo '{"id":"'.$ar->id.'"}';
				}
			}
			exit;
		}
	}
	
	
	
	
	

}

?>