<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Adm_Base extends HtmlDocument
{
	protected $currentUser, $baseUrl;
	protected function onPageStart()
	{
		$this->baseUrl = Request::$baseUrl . $this->basePath;
		if(app::$session->authenticated)
		{
			$this->currentUser = app::$session->user;
			if($this->currentUser->group==2)
			{
				$this->isAdmin           = $this->currentUser->role==3;
				$this->isContentManager  = $this->currentUser->role==4;
				$this->isModerator       = $this->currentUser->role==5;
				
			}
			else
			{
				Response::notFound();
			}
		}else{
			Response::redirect(Request::$baseUrl . $this->basePath .'/login');
		}


		if(Request::isPost())
		{
			$task = @ $_POST['task'];
			$this->onPostData($task);
			if(Request::isXmlHttpRequest()){
				exit;
			}
		}
	}
	
	protected function onPostData($task)
	{
		
	}
	
	public static function getContentsResult($termsId)
	{
		return app::$database->getResult("SELECT * FROM #__contents where category=".$termsId);
	}
	

	
}

?>