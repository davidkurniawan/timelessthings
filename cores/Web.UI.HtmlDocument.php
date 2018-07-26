<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

class HtmlDocument extends Document
{
	protected 
		$description   = '',
		$keywords      = '',
		$_scripts      = array(),
		$_text_script  = array(),
		$_links        = array(),
		$_meta         = array();
		
	public $templateFilename = 'index.php';


	protected function alert($msg, $alert_type='danger')
	{
		$this->_alert = new stdClass();
		$this->_alert->message = $msg;
		$this->_alert->type    = $alert_type;
	}
	protected function pageMessage($dismissable=true)
	{
		if($this->_alert){
			echo "<div class=\"alert {$this->_alert->type}". ($dismissable?" dismissable":"")."\"><div>{$this->_alert->message}</div></div>";
		}
	}
	
	protected function getCss($filename, $compress=true)
	{
		$css = file_get_contents($filename);
		if($compress){
			/* remove comments */
			$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', ' ', $css);
			/* remove tabs, spaces, newlines, etc. */
			$css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $css);
		}
		return $css;
	}
	
	public function addScript($src,$type="text/javascript")
	{
		if(!Helper::isUrl($src))
		{
			if(!isset($this->_text_script[$type])){
				$this->_text_script[$type]=array();
			}
			$this->_text_script[$type][] = $src;
		}else{
			$this->_scripts[$src]   = $type;
		}
	}
	protected function addLink($rel, $href, $type=null,  $media=null)
	{
		$this->_links[$href]['rel']= $rel;
		$this->_links[$href]['type']= $type;
		if(!is_null($media))
			$this->_links[$href]['media']= $media;
	}
	public function addStyleSheet($href, $media = null)
	{
		$this->addLink('stylesheet', $href, 'text/css', $media);
	}
	public function addMeta($name, $content, $attrName ='name')
	{
		$this->_meta[$attrName][$name]=$content;
	}
	protected function pageMeta()
	{
		if(!empty($this->description)){
			$this->addMeta('description', $this->description);
		}
		if(!empty($this->keywords)){
			$this->addMeta('keywords', $this->keywords);
		}
		
		$head = array();
		$head[] = '<meta http-equiv="Content-Type" content="text/html; charset='. $this->charset.'" />';
	
		foreach($this->_meta as $meta_attr => $meta_value)
		{
			foreach($meta_value as $key => $value){
				$head[] = '<meta '.$meta_attr.'="'.$key .'" content="'.htmlentities($value).'" />';
			}
		}
		
		echo  implode("\r\n",$head);
	}
	protected function pageLinks()
	{
		$head = array();
		foreach($this->_links as $key=>$value)
		{
			$param='';
			foreach($value as $attrName=>$attrValue){
				if(!empty($attrValue))
				$param .= " $attrName=\"$attrValue\"";
			}
			$head[] = "<link" . $param ." href=\"$key\" />";
		}
		foreach($this->_scripts as $key=>$value)
		{
			$head[] = "<script type=\"$value\" src=\"$key\" /></script>";
		}
		
		foreach($this->_text_script as $key => $value)
		{
			$head[] = "<script type=\"$value\" />" . implode("\r\n",$value). "</script>";
		}
		
		echo  implode("\r\n",$head);
	}
	protected function pageTitle()
	{
		echo (empty($this->title)?'':$this->title . ' - ' ) .    app::$config->siteName;
	}
	protected function renderView()
	{
		echo  $this->renderView;
	}
	protected function render()
	{		
		

		$this->renderView = Response::getContent() ;
		Response::clearContent();
		$this->onBeforeRenderPage();
		require $this->templatePath . '/' . $this->templateFilename;
		$this->onAfterRenderPage();
		Response::end();
	}
	protected function onBeforeRenderPage(){}
	protected function onAfterRenderPage(){}
	
}


?>