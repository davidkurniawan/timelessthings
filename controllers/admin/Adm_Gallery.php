<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Adm_Gallery extends Adm_Articles
{
	
    protected function onPageStart() {

        $this -> contentType = 'gallery';
        $this -> featuredImage = true;
        $this -> featuredContent = true;
        $this -> upperHead = false;
        $this -> isHaveCategories = true;
        parent::onPageStart();
		
        $this -> title = "Gallery";

    }
	protected function onDataview($statusFilter)
	{
		return parent::onDataview($statusFilter);
	}
	
	protected function onUpdateContent(& $ar)
	{
		
	}
	
	protected function onEdit(){
		parent::onEdit();
		$this->contentFilename = $this->templatePath  . '/article-edit.php';
		
	}
	protected function onNew()
	{
		parent::onNew();
		$this->content->pathName = 'uncategorized';
		$this->contentFilename = $this->templatePath  . '/article-edit.php';
	}
	
	
	

}

?>