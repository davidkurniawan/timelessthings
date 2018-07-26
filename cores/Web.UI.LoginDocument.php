<?php

//$yy = vsprintf("You have failed to login %d times. Please try again after %d minutes", array(22,33));
//echo $yy;
//exit;

class LoginDocument extends HtmlDocument
{


	protected function onLoggedIn()
	{
		Response::redirect ($this->baseUrl);
	}
	protected function onLoggedOut()
	{
		Response::redirect ($this->baseUrl);
	}

	protected function onPasswordChanged()
	{
		Response::redirect ($this->baseUrl . '/login');
	}
	protected function onRequestChangePassword()
	{
		app::$session->forgotEndRequest = true;
		Response::redirect ($this->baseUrl . '/login/forgot');
	}
	protected function onActivate()
	{
		Response::redirect ($this->baseUrl . '/login');
	}
	protected function onAfterRenderPage()
	{
		if(app::$session->forgotEndRequest==true)
		{
			app::$session->forgotEndRequest=null;
		}
	}
	protected function onPageStart()
	{

		if(empty($this->baseUrl)){
			$this->baseUrl = Request::$baseUrl;
		}

		Lang::addConversation('login');
		$titles = array(
		'login'  => __('Log in'),
		'signin' => __('Sign in'),
		'forgot' => __('Forgot Password?'),
		'reset'  => __('Change Password')
		);

		//echo $this->logoutPathName;exit;
		Response::cacheControl('no-store');

		if($this->pathName == 'logout')
		{

			if(app::$session->authenticated)
			{
				app::$session->logout();
				$this->onLoggedOut();
			}else
			{
				Response::redirect($this->baseUrl);
			}
		}
		if($this->pathName == 'login')
		{


			if(empty($this->task))
			{

				if(app::$session->authenticated){
					Response::redirect ($this->baseUrl);
				}
				if(Request::isPost())
				{
					$this->postLogin();
				}
				$this->title = $titles['login'];
				$this->contentFilename  = $this->templatePath . '/login.php';
			}
			else
			{
				$this->title = $titles[$this->task];
				$this->contentFilename  = $this->templatePath . '/login-' . $this->task .'.php';

				if($this->task=='reset')
				{
					$reset_key = $_REQUEST['key'];
					if(empty($reset_key))
						Response::badRequest();

					if(!($userhash = app::$database->getObject("SELECT * FROM #__usermeta where metaKey='forgot_pass' AND metaValue='" . app::$database->escape($reset_key) . "'")))
					{
						Response::badRequest();
					}

					if(Request::isPost())
						$this->postChangePassword($userhash);
				}
				else if($this->task=='forgot')
				{
					if(app::$session->authenticated){
						Response::redirect ($this->baseUrl);
					}
					if(Request::isPost())
					{
						$this->postRequestChangePassword();
					}else{
						$this->isSucceed = app::$session->forgotEndRequest;
					}
				}
				else
				{
					Response::badRequest();
				}
			}
		}
	}
	protected function postLogin()
	{
		if(app::$session->authenticate($_POST['email'],$_POST['password'], isset($_POST['autologin'])))
		{

			$this->onLoggedIn();
		}
		else
		{

			if(app::$session->lockAttempt===true)
			{

				$this->alert(__("You have failed to login %d times. Please try again after %d minutes", LOGIN_ATTEMPTS,LOGIN_ATTEMPTS_TIMOEOUT));

			}else
			{
				$this->alert(__("Incorrect user name or password"));
			}

		}
	}
	protected function postRequestChangePassword()
	{
		if(empty($_POST['email']))
		{
			$this->alert(__("Email address cannot be empty"));
		}
		else
		{
			if(!Helper::isEmail($_POST['email']))
			{
				$this->alert( __("Invalid email address"));
			}else
			{
				$email   = app::$database->escape($_POST['email']);
				if($user = app::$database->getObject("SELECT id, email, name FROM #__users where status>0 AND email ='" .$email . "'"))
				{
					if($obj = app::$database->getObject("SELECT metaValue FROM #__usermeta where metaKey='forgot_pass' AND userId=" .$user->id))
					{
						$key = $obj->metaValue;
					}else
					{
						$key = Helper::getUniqueKey($user->id);
						app::$database->insertRow('#__usermeta',
						array('metaKey'=>'forgot_pass', 'metaValue'=>$key,'metaDate' => Helper::ymdHis(), 'userId'=>$user->id));
					}
					Notification::sendMail('request_change_password',$email,
					array(
						'realname'   => $user->name,
						'email'      => $user->email,
						'action_url' => $this->baseUrl . '/login/reset?key=' .$key
					));
					$this->onRequestChangePassword();

				}else
					$this->alert(__("E-mail address you submit is not listed as our member"));
			}
		}

	}
	protected function postChangePassword($userhash)
	{
		$pass = @ trim($_POST['password']);
		if(empty($pass))
		{

			$this->alert(__("Your new password cannot be empty"));
		}
		else
		{
			if($pass != $_POST['password_confirm'])
			{
				$this->alert(__("Password and confirm password are not the same"));
			}else
			{
				if($user = app::$database->getActiveRecord("SELECT id, email, name, password FROM #__users where id=" . $userhash->userId))
				{
					$user->password = getHash($pass);
					$user->save();
					app::$database->deleteRows('#__usermeta', "metaKey='forgot_pass' and userId=". $userhash->userId );

					$this->onPasswordChanged();
				}else
					Response::badRequest();
			}
		}

	}
}

?>