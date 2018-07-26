<?php

class Document extends Object
{
	protected 
		$charset          = 'utf8';
		
	public $contentFilename  = '';
	public  function __construct($properties = null)
	{
		parent::__construct($properties , false);
	}
	protected function onInit(){}
	protected function onPageStart(){}
	protected function render(){}
	protected function onPageEnd(){}
	
	public function start()
	{
		if( !empty($this->pageIndex)){
			$this->pageIndex = ltrim($this->pageIndex,'/');
		}
		$this->onPageStart();
		if(!empty($this->contentFilename))
		{
			require $this->contentFilename;
		}
		$this->render();
		$this->onPageEnd();
	}
}


?>