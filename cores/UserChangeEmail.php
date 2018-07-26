<?php
class UserChangeEmail extends Document
{
	protected function onPageStart()
	{
		if(empty( $_GET['authkey'] ))
			Response::badRequest();
		if($regdata = App::$database->getObjectRow(
			"SELECT 
			u.realname, u.username,u.email,
			k.id,
			k.user_id, 
			k.hash ,
			k.req_data as new_email 
			FROM #__user_keys as k
			INNER JOIN #__users as u on k.user_id= u.id
			WHERE k.req_type=2 AND k.hash='" .App::$database->escape($_GET['authkey']) . "'")
		)
		{
			App::$database->deleteRows('#__user_keys', "id=". $regdata->id );
			App::$database->updateRows('#__users', array('email'=> $regdata->new_email), "id=". $regdata->user_id );
			
			Notification::sendMail('your_new_email',$regdata->email,
			array(
				'user_fullname'     => $regdata->realname,
				'user_email'        => $regdata->new_email,
				'user_old_email'    => $regdata->email
			));
			if(isset($this->redirectUrl))
			{
				Response::redirect($this->redirectUrl);
			}else
			Response::redirect(Request::$baseUrl . '/akun-saya');
			
		}else
			Response::badRequest();
	}

}
?>