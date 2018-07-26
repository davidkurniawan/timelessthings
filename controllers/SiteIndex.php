<?php

class SiteIndex extends HtmlDocument{
	
	
	protected function onPageStart(){
			
		$this->settings = Settings::getSettings();
		
		$this->contentFilename = $this->templatePath.'/home.php';
		
		$this->slider = app::$database->getObjects("
		SELECT item.* FROM #__contents as item 
		WHERE item.contentType='slider' 
		AND item.status=1
		AND item.category=2 
		ORDER BY item.id DESC");
		
		$this->products = app::$database->getObjects("
		SELECT item.* FROM #__contents as item 
		WHERE item.contentType='product' 
		AND item.status=1
		ORDER BY item.id DESC
		");
		
		
	}

	
}