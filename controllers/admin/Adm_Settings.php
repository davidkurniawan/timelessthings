<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * 
 */
class Adm_Settings extends Adm_Base {
	
		protected $settingValue;
		
	protected function onPageStart()
	{
		
		parent::onPageStart();
		$this->title = "Settings";		
		$this->addScript( $this->templateUrl . "/js/tinymce/tinymce.min.js");
		
		$this->settingValue = app::$database->getRow("SELECT * FROM #__metadata WHERE meta_key='settings'");
		
		$this->settingValue = unserialize($this->settingValue['meta_value']);
		
		$this->contentFilename = $this->templatePath.'/settings.php';
		
		
	}
	
	
	protected function onPostData($task)
	{
		
		if(Request::isPost())
		{

				
				
				$settings = array(
						
					"contactMail" => trim(@$_POST['contactMail']),
					"contactAddress" => trim(@$_POST['contactAddress']),
					
									
					"instagram" => trim(@$_POST['instagram']),
					"facebook" => trim(@$_POST['facebook']),
					"twitter" => trim(@$_POST['twitter']),
					
					"pictureAbout" => trim(@$_POST['pictureAbout']),
					"aboutText" => trim(@$_POST['aboutText']),	
					
					"homeSection1" => trim(@$_POST['homeSection1']),
					
					"picturePhilosophy" => trim(@$_POST['picturePhilosophy']),
					"titlePhilosophy" => trim(@$_POST['titlePhilosophy']),	
					"textPhilosophy" => trim(@$_POST['textPhilosophy']),	
					
					"pictureProcess" => trim(@$_POST['pictureProcess']),
					"titleProcess" => trim(@$_POST['titleProcess']),	
					
					"picturePeople" => trim(@$_POST['picturePeople']),
					"titlePeople" => trim(@$_POST['titlePeople']),	
					
					"pagePeopleTitle" => trim(@$_POST['pagePeopleTitle']),	
					"pagePeopleDesc" => trim(@$_POST['pagePeopleDesc'])
					
					
			);
			
			$settings = serialize($settings);
			
			if(app::$database->updateRows("#__metadata", array('meta_value'=> $settings), "meta_key='settings'"))
			{
				// echo "masuk";
				Response::redirect(Request::$baseUrl.'/cms/setting/general');
			}
			
			
			
			
		}
		
		
	}
	
}
