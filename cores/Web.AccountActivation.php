<?php
class AccountActivation extends Document
{
	protected 
		$redirectUrl,
		$queyName = 'key',
		$userData;		
		
	protected function onPageStart()
	{
		if(empty( $_GET[$this->queyName] ))
			Response::badRequest();
				
		if($this->userData = App::$database->getObject(
			"SELECT 
			user.name, user.email, meta.* 
			FROM #__usermeta as meta
			INNER JOIN #__users as user on meta.userId= user.id
			WHERE meta.metaKey='account_activation' AND meta.metaValue='" .App::$database->escape($_GET[$this->queyName]) . "'")
		)
		{
			App::$database->deleteRows('#__usermeta', "id=". $this->userData->id );
			App::$database->updateRows('#__users', array('status'=>1,'dateActivated'=>Helper::ymdHis()), "id=". $this->userData->userId );

			if(!isset($this->redirectUrl))
			{
				$this->redirectUrl = Request::$baseUrl . '/login';
			}
			$this->onActivationComplete();
			Response::redirect($this->redirectUrl);
		}
		else{
			$this->onInvalidKey();
		}
	}
	protected function onActivationComplete(){}
	protected function onInvalidKey()
	{
		Response::badRequest();
	}

}
?>