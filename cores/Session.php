<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Session extends SessionBase
{

	public $lockAttempt=false;

	protected function onLogout()
	{
		Response::deleteCookie(SESSION_COOKIE_NAME);
	}

	public function authenticate($username, $password, $autologin=false)
	{

		if($user = $this->getUserByEmail($username))
		{


			if($user['log_timeout']<= time())
			{
			//	echo $user['password'] ."==" . getHash($password); exit;
				if( ($user['password'] ==  getHash($password)) )
				{

					$uservars = array('log_attempts'=>0,'log_timeout'=>0);
					App::$database->updateRows('#__users',$uservars,'id='.$user['id'] );
					$this->updateCookie($user['id'],$user['password'],intval($autologin));
					return true;
				}
			}else{

				$this->lockAttempt=true;
				return false;
			}
			if($user['log_attempts'] < LOGIN_ATTEMPTS-1)
			{
				App::$database->updateRows('#__users', array('log_attempts'=>$user['log_attempts']+1),'id='.$user['id'] );

			}else{

				if($user['log_attempts'] == (LOGIN_ATTEMPTS-1))
				{
					App::$database->updateRows('#__users', array('log_attempts'=>0,'log_timeout'=> time()+ (60 * LOGIN_ATTEMPTS_TIMOEOUT)),'id='.$user['id'] );
				}
				$this->lockAttempt=true;
			}


		}
		return false;
	}
	public function onInit()
	{
		$cookies = Request::getCookie(SESSION_COOKIE_NAME);
		$cookie  = array('user_id' => 0, 'pwd_hash' => '','autologin'=> 0);
		if (is_array($cookies))
		{
			list($cookie['user_id'], $cookie['pwd_hash'], $cookie['autologin']) = $cookies;
		}
		$authenticated = false;
		if ($cookie['user_id'] > 0)
		{
			if ($userrow = $this->getUserById($cookie['user_id']) )
			{
				if ($userrow['password'] == $cookie['pwd_hash'])
				{
					$this->updateCookie($userrow['id'], $userrow['password'],$cookie['autologin']);
					App::$database->updateRows('#__users',array('lastVisit'=>date("Y-m-d H:i:s")),'id='.$userrow['id'] );
					$authenticated = $this->setAuthenticatedUser($userrow);
				}
			}
			if(!$authenticated)
			{
				Response::deleteCookie(SESSION_COOKIE_NAME);
			}
		}
		if(!$authenticated)
		{
			$this->setAuthenticatedUser(null);
		}
	}

	protected function updateCookie($userid, $pwdhash, $autologin)
	{
		$ar = serialize(array( $userid, $pwdhash, $autologin));
		Response::setCookie(SESSION_COOKIE_NAME, "~a|" . Helper::encrypt($ar), ($autologin? SESSION_AUTOLOGIN_TIMEOUT :10000));
	}
}

?>