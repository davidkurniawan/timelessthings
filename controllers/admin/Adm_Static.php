<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Adm_Static extends Adm_Articles
{

	protected function onPageStart()
	{
		$this->contentType     ='pages';
		$this->featuredImage   = true;
		$this->featuredContent = false;
		$this->upperHead = false;
		parent::onPageStart();
		
		$this->title = "";
		
	}
	protected function onDataview($statusFilter)
	{
		return parent::onDataview($statusFilter);
	}

	protected function onEdit(){
		//$this->contentFilename = $this->templatePath  . '/users-edit.php';
		parent::onEdit();
	}
	protected function onNew()
	{
		parent::onNew();
		//$this->contentFilename = $this->templatePath  . '/users-edit.php';
	}
	
		protected function onUpdateContent(& $ar){
			
			$ar->category = 13;
			$ar->body    = trim(@$_POST['body']);
			
		}
		
}

?>