<?php

class Notification
{
	public static function sendMail($tplname, $to, $varreplace)
	{
		if($tpl  = self::getEmailTemplate($tplname, app::$locale->language))
		{
			$subject = $tpl['subject'];
			$body    = $tpl['body'];
			$varreplace["site_name"] = app::$config->siteName;
			$varreplace["site_url"]  = Request::$baseUrl;
			foreach($varreplace as $key=>$val)
			{
				$body    = str_replace('{'.$key.'}',$val, $body);
				$subject = str_replace('{'.$key.'}',$val, $subject);
				
			}
			//file_put_contents("_temp/$tplname.html", Helper::plainToHtml("$subject\n\n$body"));
			Helper::sendMail($to,$subject,$body);
		}
	}
	
	public static function sendAccountActivationInfo($userid, $useremail, $realname, $actianurl)
	{
		$authkey = Helper::getUniqueKey($user->id);
		app::$database->insertRows('#__usermeta', array(
			'userId'        => $userId,
			'metaKey'       => 'account_activation',
			'metaValue'     => $authkey
		));
		self::sendMail('activate_your_account', $ar->email,
			array(
				'realname'   => $regdata->realname,
				'email'      => $regdata->username,
				'action_url' => Request::$baseUrl . '/activate?key=' . $authkey
		));
	}



	public static function getEmailTemplate($tplname,$lang='en')
	{
		if($data = file_get_contents("tpl/email/$tplname.dat"))
		{
			$ar = explode('--body--',$data);
			if(count($ar)==2)
			{
				return array(
				"subject"=>trim($ar[0]),
				"body"   =>trim($ar[1])
				);
			}
		}
		return null;
	}
	
	public static function saveTemplateEmail($tplname,$lang, $subject, $body)
	{
		file_put_contents("tpl/email/$tplname.dat", "$subject\r\n\r\n--body--\r\n\r\n$data");
	}
	/*
	public static function getTemplateFiles($lang)
	{
		return Folder::getFiles("lang/$lang/email", '(.*)\.dat+$', false);
	}*/
}



?>