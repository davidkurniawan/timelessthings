<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

class StaticPage extends HtmlDocument
{
	public $bodyClass ="single";

	protected function onPageStart()
	{
		
		$this->contentFilename  =  $this->templatePath . '/pages/'.  str_replace('/','.', substr(Request::$pathInfo,1) ) . '.php';
		// echo $this->contentFilename;
// 		
		// exit;
		
		$this->settings = Settings::getSettings();
		
		$this->pageAbout = Settings::getSettings("aboutus");
		
		$this->pagePhilosophy = Settings::getSettings("philosophy");
		
		$this->people = app::$database->getObjects("
						SELECT item.* FROM #__contents as item 
						WHERE item.contentType='slider' 
						AND item.status=1
						AND item.category=3");
						
		$this->philosophy = app::$database->getObjects("
						SELECT item.* FROM #__contents as item 
						WHERE item.contentType='slider' 
						AND item.status=1
						AND item.category=4");		
								
		$this->products = app::$database->getObjects("
		SELECT item.* FROM #__contents as item 
		WHERE item.contentType='product' 
		AND item.status=1
		ORDER BY item.id DESC
		");
								
		if(!is_file($this->contentFilename))
		{
			Response::notFound();
		}
		
		
	
	}
	
	

}