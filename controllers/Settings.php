<?php 
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 * 
 */
class Settings extends HtmlDocument {
	
	
		
		
		protected function onPageStart()
		{
				
			
		}
		
		
		public static function getSettings($meta_key = "settings"){
			$settingValue = app::$database->getRow("SELECT * FROM #__metadata WHERE meta_key='$meta_key'");
		
			$settingValue = unserialize($settingValue['meta_value']);		
			
			return $settingValue;
		}
		
	
	
	
}
