<?php

class Adm_Login extends LoginDocument
{
			
	protected function onPageStart()
	{
		$this->baseUrl  = Request::$baseUrl . $this->basePath;
		parent::onPageStart();
	}
}