<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * 
 */
class Adm_MetaAbout extends Adm_Base {
	
		protected $settingValue;
		
	protected function onPageStart()
	{
		
		parent::onPageStart();
		$this->title = "About Page";		
		$this->addScript( $this->templateUrl . "/js/tinymce/tinymce.min.js");
		
		$this->settingValue = app::$database->getRow("SELECT * FROM #__metadata WHERE meta_key='aboutus'");
		
		$this->settingValue = unserialize($this->settingValue['meta_value']);
		
		$this->contentFilename = $this->templatePath.'/meta-about.php';
		
		
	}
	
	
	protected function onPostData($task)
	{
		
		if(Request::isPost())
		{

				
				
				$settings = array(
					
					
					// Hero Image
					"heroImage" => trim(@$_POST['heroImage']),
					"heroTitle" => trim(@$_POST['heroTitle']),
					
					"pictureBelowHeader" => trim(@$_POST['pictureBelowHeader']),
					"titleBelowHero" => trim(@$_POST['titleBelowHero']),
					"textBelowHero" => trim(@$_POST['textBelowHero']),
					
					"thirdSectionImage" => trim(@$_POST['thirdSectionImage']),
					"thirdSectionTitle" => trim(@$_POST['thirdSectionTitle']),
					
					
					"titleFourthSection" => trim(@$_POST['titleFourthSection']),
					"firstRowImage" => trim(@$_POST['firstRowImage']),
					"firstRowText" => trim(@$_POST['firstRowText']),
					
					
					"secondRowImage" => trim(@$_POST['secondRowImage']),
					"secondRowText" => trim(@$_POST['secondRowText']),
					
					
					
			);
			
			$settings = serialize($settings);
			
			if(app::$database->updateRows("#__metadata", array('meta_value'=> $settings), "meta_key='aboutus'"))
			{
				// echo "masuk";
				Response::redirect(Request::$baseUrl.'/cms/setting/aboutus');
			}
			
			
			
			
		}
		
		
	}
	
}
