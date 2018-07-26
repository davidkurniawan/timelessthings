<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Author URI: http://shapetherapy.com/
Copyright 2008-2010 by wildan
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*class GoogleRecaptcha 
{

 	private static $google_url = "https://www.google.com/recaptcha/api/siteverify";
	public static function verify($privatekey,$response)
    {
        $url = self::$google_url."?secret=".$privatekey."&response=".$response;
		$data = file_get_contents($url);
		$res = json_decode($data, true);
        return $res['success']; 
    }
}*/
class SignupDocument extends HtmlDocument
{
	protected 
		 $validator
		,$activationRequired
		,$activationQueryName = 'key'
		,$isSignupComplete = false
		,$minPasswordLength = 6
		,$userData;
	
	
	protected function onAfterRenderPage()
	{
		if(app::$session->signupComplete==1)
		{
			app::$session->signupComplete=null;
		}
	}
	protected function onPageStart()
	{
		if(app::$session->authenticated)
		{
			Response::redirect(Request::$baseUrl);
		}
		if(isset($_GET['complete']))
		{
			if(app::$session->signupComplete!=1)
			{
				Response::redirect(Request::$pathUrl);
			}else{
				$this->isSignupComplete=true;
			}
		}
		if(empty($this->contentFilename))
		{
			$this->contentFilename = $this->templatePath . '/signup.php';
		}
		
		if(!isset($this->activationRequired))
		{
			$this->activationRequired  = app::$config->activationRequired;
		}
		
		
		if(Request::isPost())
		{
			$blackip=array('118.137.208.43','114.124.1.114');
			if(in_array($_SERVER['REMOTE_ADDR'], $blackip))
			{
				return;
			}
			
			validateCsrfToken();
			//require 'modules/recaptcha/recaptchalib.php';

			$privatekey = "6LeX7xkTAAAAAAZ5mAAS6N9iyyHUwQZwXiB1xlnR";
			if( empty($_POST["g-recaptcha-response"]))
			{
				//Response::redirect(Request::$url);
				$this->alert("Beri validasi bahwa Anda bukan Robot.");
				return;
			}
			if(! GoogleRecaptcha::verify($privatekey,$_POST["g-recaptcha-response"]))
			{
				die ("The reCAPTCHA wasn't entered correctly. Go back and try it again.");
			}else{
				
			}
			
			$this->validator = new FormValidator($_POST);
			$this->userData  = new ActiveRecord('#__users',null, 'id');
			
			if(isset($_POST['name']))
				$this->userData->name = $this->validator->validateText('name');
			
			$this->userData->email   = $this->validator->validateText('email');

			if($this->validator->isValid())
			{
				if(app::$database->getRow("SELECT id FROM #__users WHERE email='". $this->userData->email ."'"))
				{
					$this->validator->setError('email', __("The email address you have entered is already registered, please enter your another email address"));
					$this->alert( $this->validator->getInvalidMessage('email') );
					$this->onSignupError();
					return;
				}
			}
			
			$pass1 = $this->validator->validateText('password',$this->minPasswordLength);
			$pass2 = $this->validator->validateText('password_confirm',$this->minPasswordLength);
			
			if($this->validator->isValid())
			{
				if($pass1 != $pass2){
					$this->validator->setError('password');
					$this->validator->setError('password_confirm');
				}
			}
			
			$this->userData->password = getHash($pass1);
			$this->userData->role     = 1;

			$this->userData->regIP    = $_SERVER['REMOTE_ADDR'];
			
			$this->userData->dateRegistered = Helper::ymdHis();
			$this->userData->status   = $this->activationRequired?0:1;
			
			if($this->validator->isValid())
			{
				$this->onSignupData();
				if($this->validator->isValid())
				{
					$this->userData->save();
					if($this->activationRequired){
						$this->notifyAccountActivation();
					}
					$this->onSignupComplete();
					return;
				}
			}
			$this->onSignupError();
		}
	}
	protected function onSignupData(){}
	protected function onSignupComplete()
	{
		if(Request::isXmlHttpRequest())
		{
			echo json_encode(array("userId"=>$this->userData->id));
			exit;
		}
		app::$session->signupComplete=1;
		Response::redirect(Request::$pathUrl . "?complete");
	}
	
	protected function onSignupError()
	{
		/*
		if(!Request::isXmlHttpRequest())
		{
			app::$page->addScript('var _INVALID_ELEMENTS = ' . json_encode($this->validator->getInvalidFields(true)) . ';');
		}else
		{
			$obj = array("invalidFields"=> $this->validator->getInvalidFields());
			echo json_encode($obj);
			exit;
		}*/
	}
	private function notifyAccountActivation()
	{
		$authkey = Helper::getUniqueKey($this->userData->id);
		app::$database->insertRow('#__usermeta', array(
			'userId'        => $this->userData->id,
			'metaKey'       => 'account_activation',
			'metaValue'     => $authkey
		));
		Notification::sendMail('activate_your_account', $this->userData->email,
			array(
				'realname'   => $this->userData->name,
				'email'      => $this->userData->email,
				'action_url' => Request::$baseUrl . '/activate?' . $this->activationQueryName  .'=' . $authkey
		));
	}

		
	//protected function onSignupData(){}
	
}

?>