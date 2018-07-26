<?php

class Pagelog 
{
	
	const LOG_TYPE_VIEW = 1;
	const LOG_TYPE_MOST_VIEWED = 2;
	const LOG_TYPE_LIKE = 3;
	const LOG_TYPE_RATING = 4;

	public static function update()
	{
		$params = func_get_params(
			array(
			'content_id'        => 0, 
			'content_type'      => "",
			'log_type'          => 1,  
			'content_table'     => '#__contents',
			'most_viewed_table' => '#__mostviewed',
			'timeout'           => (60 * 60 * 24 * 90),
			'value'             => 0
			), func_get_args()
		);
		
		$cookie_name = md5($params['content_type'] . $params['log_type']);
		$cstate  = @ $_COOKIE[$cookie_name];
		if(empty($cstate))
		{
			$cstate = uniqid() . '-' . rand(100,500);
			$cstate = md5($cstate);
			Response::setCookie($cookie_name, $cstate ,  $params['timeout']);
		}
		
		$ff_ip      = @ $_SERVER["HTTP_X_FORWARDED_FOR"];
		$uniquser   = $_SERVER["REMOTE_ADDR"] . $ff_ip . $_SERVER['HTTP_USER_AGENT'] . $cstate;
		$uniquser   = md5($uniquser);
		$content_id = $params['content_id'];
		$retval     = 0;
		
		$log = app::$database->getRow
		(
			"SELECT id FROM #__pagelogs
			WHERE 
			visitorId       = '$uniquser' 
			AND logType     = '{$params['log_type']}'
			AND contentType = '{$params['content_type']}'
			AND contentId   = $content_id" 
		);
		
		$now    = time();
		$sqlnow = date('Y-m-d H:i:s',$now);
		$interval = ceil($params['timeout']/86400);
		
		if($log == 0)
		{
			app::$database->deleteRows("#__pagelogs", "lastView < DATE_SUB('', INTERVAL $interval DAY)");
			app::$database->insertRow("#__pagelogs", array(
					'contentId'   => $content_id,
					'contentType' => $params['content_type'],
					'visitorId'   => $uniquser, 
					'logType'     => $params['log_type'],
					'lastView'    => $sqlnow
			));
			if($params['log_type']<=2)
			{
				
				app::$database->query("UPDATE {$params['content_table']} SET views=views+1 WHERE id=" . $content_id);
				$retval = 1;
			}
			else if($params['log_type']==3)
			{
				
				if($ar =  app::$database->getActiveRecord("SELECT id,rate,rateData from {$params['content_table']} WHERE id=" . $content_id))
				{
					// 0 : users
					// 1 : total
					$rateData = empty($ar->rateData)?array(0,0) :unserialize($ar->rateData);
					$rateData[0]  += 1;
					$rateData[1]  += $params['value'];
					$ar->rate     = ceil($rateData[1] / $rateData[0]);
					$ar->rateData = serialize($rateData);
					$ar->save();
					return $ar->rate;
				}
			}
		}
		
		if($params['log_type']==2)
		{
			if($view = app::$database->getRow(
			"SELECT * FROM {$params['most_viewed_table']}
			WHERE contentId = $content_id"))
			{
				$lastview     = new DateTime($view['lastView']);	
				$date         = new DateTime($sqlnow);
				$daily        = $date->diff( $lastview)->format("%d") > 0  ? 1: $view['daily']+1;
				$weekly       = $date->diff( $lastview)->format("%d") > 7  ? 1: $view['weekly']+1;
				$monthly      = $date->diff( $lastview)->format("%m") > 0  ? 1: $view['monthly']+1;
				$halfYearly   = $date->diff( $lastview)->format("%d") > (30 *6) ? 1: $view['halfYearly']+1;
				$yearly       = $date->diff( $lastview)->format("%y") > 0 ? 1: $view['yearly']+1;
				
				$affecteds = app::$database->query(
				"UPDATE {$params['most_viewed_table']}
				SET 
				  lastView='$sqlnow'
				, daily   = $daily 
				, weekly  = $weekly
				, monthly = $monthly
				, halfYearly = $halfYearly 
				, yearly = $yearly
				WHERE contentId=$content_id");
				
			}else
			{
				app::$database->insertRow($params['most_viewed_table'], array(
				'contentId'  => $content_id,
				'lastView'    => $sqlnow
				));
				
			}
			
		}
		return $retval ;
	}

}

?>