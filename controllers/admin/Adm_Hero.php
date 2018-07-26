<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Adm_Hero extends Adm_DataEntries
{
	protected 
	$content
	, $categories = array()
	, $featuredContent = false
	, $featuredImage   = true
	, $contentType     = 'location'
	, $upperHead = false
	, $isHaveCategories    = false;

	protected function onPageStart()
	{		
		
		$this->title = "Hero Settings";
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
		 $this->contentFilename = $this->templatePath  . '/hero.php';
		 return "SELECT item.* FROM #__hero as item 		 ";
	}
	protected function onDataviewAssoc(& $row){}
	
	protected function onEdit()
	{
		$this->addScript( $this->templateUrl . "/js/tinymce/tinymce.min.js");
		$this->contentFilename = $this->templatePath  . '/hero-edit.php';
		
		$this->id = @ $_REQUEST['id'];
		if($this->id)
		{
			if(!($this->content = app::$database->getObject
			( (
					"SELECT item.* FROM #__hero as item WHERE item.id=" . $this->id
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
		$this->contentFilename = $this->templatePath  . '/hero-edit.php';
		
		$this->content = new stdClass();
		$this->content->title    = "";
		$this->content->name     = "";
		$this->content->id       = 0;
		$this->content->picture  = "";
		$this->content->body     = "";
		$this->content->status = 0;
		
		
		
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
			if($posttask=='trash')
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
					$ar = new ActiveRecord("#__hero",null,'id');
					$ar->title   = ucwords($title);
					$ar->name    = Helper::safeUrlText( $name? $name: $ar->title);
					$ar->body    = $body;
					
					if(isset($_POST['status'])){
						$ar->status  = $_POST['status'];
					}
					
					if(isset($_POST['picture']))
					{
						$ar->picture = basename($_POST['picture']);
					}
					if($id)
					{
						$ar->id = $id;
						$ar->dateModified = date('Y-m-d H:i:s');
					}else
					{
						$ar->dateCreated = $ar->dateModified = date('Y-m-d H:i:s');
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
					
					
					$this->onUpdateContent($ar);
					
					
					$ar->save();
					
					echo '{"id":"'.$ar->id.'"}';
				}
			}
			exit;
		}
	}
	
	
	
	
	

}

?>