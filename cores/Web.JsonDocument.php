<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class JsonDocument extends Document
{

	protected $output ;

	protected function onPageEnd()
	{
		exit(json_encode($this->output));
	}
	protected function onPageStart()
	{
		$this->output = new stdClass();
		
	}
	protected function onError($err)
	{
		
	}
	protected function error($err)
	{
		$this->onError($err);
		$this->output->err = $err;
		$this->onPageEnd();
	}

}

?>