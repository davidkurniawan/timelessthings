<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Adm_Pages extends Adm_Articles
{
	protected $disabledBody = true;
	
	protected function onPageStart()
	{
		$this->contentType='page';
		$this->featuredImage = true;
		$this->featuredContent = false;
		$this->upperHead = true;
		 $this -> isHaveCategories = false;
		 
		parent::onPageStart();
		// $this->contentFilename = $this->templatePath  . '/page.php';
		$this->title = "Pages";
		
	}
	
	protected function onEdit(){
		parent::onEdit();
		switch ($this->id) {
			case 9:
				$this->aboutPage = true;
				break;
			
			default:
				
				break;
		}
		
		
		$this->contentFilename = $this->templatePath  . '/page-edit.php';
		
	}
	
	protected function onDataview($statusFilter)
	{
		return parent::onDataview($statusFilter);
	}
	
	protected function onUpdateContent(& $ar){
		

	}
	
	
	
	
	
	
		
}

?>