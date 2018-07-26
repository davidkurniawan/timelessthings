<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class SessionBase
{
	private
		$_user,
		$_authenticated=false;

	public  function __construct()
	{
		$this->onInit();
	}
	private function sessionStart()
	{
		if(!isset($_SESSION)){
			ini_set('session.use_cookies', 1);
			ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_httponly', intval(COOKIE_HTTP_ONLY));
             ini_set('session.cookie_secure', intval(COOKIE_SECURE));
			//session_name("_wdat"); session.cookie_secure

			session_start();
		}
	}

	protected function setAuthenticatedUser($userRow)
	{
		if(empty($userRow))
		{
			$this->_user =  new Object( array('id'=>0,'name'=>'Guest','group'=>0 ));
			$this->_authenticated =false;

		}else
		{

			if($userRow instanceof ActiveRecord)
			{

				$this->_user =  $userRow;
				$this->_authenticated =  !empty($userRow->id);
			}else{
				$this->_user =  new ActiveRecord('#__users', $userRow,'id');
				$this->_authenticated = !empty($userRow['id']);
			}
		}

		return $this->_authenticated;
	}
	public function isAdmin()
	{
		return $this->_user->id=3;
	}
	public function isAdminGroup()
	{
		return $this->_user->group=2;
	}
	public function isContentManager()
	{
		return $this->isAdmin() ||  $this->_user->id=4;
	}
	public function isModerator()
	{
		return $this->isContentManager() ||  $this->_user->id=5;
	}



	protected function getUserById($id)
	{
		return $this->getUser("users.id=$id");
	}
	protected function getUserByEmail($email)
	{
		return $this->getUser("users.email='".  app::$database->escape($email) ."'");
	}
	protected function getUser($filter)
	{
		if($user = app::$database->getRow(
		"SELECT
		users.*,
		roles.title as roleTitle,
		roles.group
		FROM #__users as users
		LEFT JOIN #__roles as roles ON users.role = roles.id
		WHERE users.status=1
		" . (!empty(app::$config->sessionGroupId)? " AND roles.group=". app::$config->sessionGroupId:"")
		. " AND $filter"
		))
		{
			return $user;
		}
		return false;
	}
	public function logout()
	{
		//if(isset($_SESSION)){
			//session_destroy();
		//}
		$this->onLogout();
	}
	public function destroy()
	{
		if(isset($_SESSION)){
			session_destroy();
		}
	}

	protected function onLogout(){}

	public function getData($name)
    {
		if($name=='user')
		{
			return $this->_user;
		}
		elseif ($name=='authenticated')
		{
			return $this->_authenticated;
		}
		else
		{
			$this->sessionStart();
		//	if(isset($_SESSION)){
				return @ $_SESSION[$name];
		//	}
		}
		return null;
    }
	public function __get($key)
    {
		return $this->getData($key);
	}
	public function setData($key,$value)
    {
		$this->sessionStart();
		if($value===null)
		{
			unset($_SESSION[$key]);
		}else
		{
			$_SESSION[$key]=$value;
		}
	}
    public function __set($name, $value)
    {
		if($name== 'user' && $name== 'authenticated')
		{
			trigger_error(sprintf("Can not set read only property '%s::$name'", get_class($this)), E_USER_ERROR);
		}else
		{
			$this->setData($name,$value);
		}
	}

	protected function onInit(){}


}

?>