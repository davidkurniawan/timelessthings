<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * 
 */
class Adm_MetaPhilosophy extends Adm_Base {
	
		protected $settingValue;
		
	protected function onPageStart()
	{
		
		parent::onPageStart();
		$this->title = "Philosophy Page";		
		$this->addScript( $this->templateUrl . "/js/tinymce/tinymce.min.js");
		
		$this->settingValue = app::$database->getRow("SELECT * FROM #__metadata WHERE meta_key='philosophy'");
		
		$this->settingValue = unserialize($this->settingValue['meta_value']);
		
		$this->contentFilename = $this->templatePath.'/meta-philosophy.php';
		
		
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
					"thirdSectionDesc" => trim(@$_POST['thirdSectionDesc']),
					"thirdSectionDesc1" => trim(@$_POST['thirdSectionDesc1']),
					
					"titleFourthSection" => trim(@$_POST['titleFourthSection']),
					"textFourthSection" => trim(@$_POST['textFourthSection']),
					
					
					
			);
			
			$settings = serialize($settings);
			
			if(app::$database->updateRows("#__metadata", array('meta_value'=> $settings), "meta_key='philosophy'"))
			{
				// echo "masuk";
				Response::redirect(Request::$baseUrl.'/cms/setting/philosophy');
			}
			
			
			
			
		}
		
		
	}
	
}
