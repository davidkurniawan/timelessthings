<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Author URI: http://shapetherapy.com/
Copyright 2008-2010 by wildan
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class ContentPage extends HtmlDocument
{
	protected $content;
	protected function onPageStart()
	{
		$status = app::$session->isContentManager() ? '':'c.status=1 AND';
		if($this->content = app::$database->getObject(
			"SELECT 
			c.*, u.name as authorName
			FROM #__contents as c 
			LEFT JOIN #__users as u ON u.id = c.authorId
			where $status c.name='" . app::$database->escape($this->contentName) . "' and c.contentType='page'"
		
		 ))
		{
			$this->contentFilename =  $this->templatePath . '/page.php';
			$this->title = $this->content->title;
		}
		else{
			Response::notFound();
		}
	}
}

?>