<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Adm_Index extends Adm_Base
{

	protected function onPageStart()
	{
		parent::onPageStart();
		
		//require_once(ABS_PATH.'/modules/gen-content.php');
		$this->contentFilename = $this->templatePath  . '/home.php';
	}
}

?>