<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Adm_Sliders extends Adm_Articles
{
	
    protected function onPageStart() {

        $this -> contentType = 'slider';
        $this -> featuredImage = true;
        $this -> featuredContent = true;
        $this -> upperHead = false;
        $this -> isHaveCategories = true;
        parent::onPageStart();

        $this -> title = "Slider";

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