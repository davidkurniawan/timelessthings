<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

class Helper
{

	public static function secondsToTime($seconds)
	{
		$secs = floor($seconds % 60);
		$hours = floor($seconds / 3600);
		$mins = floor(($seconds - ($hours*3600)) / 60);
		if($seconds>=3600){
			return $hours .':' . $mins . ':' . $secs;	
		}
		return  $mins . ':' . $secs;	
	}

	public static function capitalize($name)
	{
		$name = str_replace('-',' ',$name);
		$name = strtolower($name);
		return ucwords($name);
	}
	public static function cleanEmptyArray($array)
	{
		$retval=array();
		foreach ($array as $value) 
		{
			if(!empty($value) && $value!==0 ){
				$retval[] = $value;
			}
		}
		return $retval;
	}
	public static function cleanEmptyArgsToArray()
	{
		$args = func_get_args();
		return self::cleanEmptyArray($args);
	}
	public static function joinArgsToCommaDelimiter()
	{
		$args = func_get_args();
		$array   = self::cleanEmptyArray($args);
		return implode(', ',$array);
	}
	
	public static function absPathToUrl($absPath)
	{
		$_= str_replace(ABS_PATH,'',$absPath);
		return Request::$baseUrl  . str_replace(DIRECTORY_SEPARATOR,'/',$_);
	}
	public static function absPathToRelative($absPath)
	{
		$_= str_replace(ABS_PATH,'',$absPath);
		return  ltrim(str_replace(DIRECTORY_SEPARATOR,'/',$_),'/');
	}
	public static  function ymdHis($time = null)
	{
		return  date('Y-m-d H:i:s',empty($time)? time():$time );
	}
	
	static function encrypt($data, $key = GLOBAL_ENCRYPT_KEY, $use_mcrypt=false)
	{
		if($use_mcrypt && function_exists("mcrypt_encrypt"))
		{
			$encrypted_data = mcrypt_encrypt(MCRYPT_3DES, $key, $data, MCRYPT_MODE_ECB);
		}
		else
		{
			$pass = str_split(str_pad('', strlen($data), $key, STR_PAD_RIGHT));
			$stra = str_split($data);
			foreach($stra as $k=>$v){
				$tmp = ord($v)+ord($pass[$k]);
				$stra[$k] = chr( $tmp > 255 ?($tmp-256):$tmp);
			}
			$encrypted_data =  join('', $stra);
		}
		return 	base64_encode($encrypted_data);
	}
	
	static function decrypt($base64_data, $key = GLOBAL_ENCRYPT_KEY, $use_mcrypt=false)
	{
		if($use_mcrypt && function_exists("mcrypt_decrypt"))
		{
			$decrypted = @ mcrypt_decrypt (MCRYPT_3DES,$key, base64_decode($base64_data), MCRYPT_MODE_ECB);
			if(!empty($decrypted))
				return trim($decrypted);
		}else
		{
			$str = base64_decode($base64_data);
			$pass = str_split(str_pad('', strlen($str), $key, STR_PAD_RIGHT));
			$stra = str_split($str);
			foreach($stra as $k=>$v){
				$tmp = ord($v)-ord($pass[$k]);
				$stra[$k] = chr( $tmp < 0 ?($tmp+256):$tmp);
			}
			return join('', $stra);
		}
		return false;
	}
	static function unserialize($data)
	{
		return  empty($data)?array(): unserialize($data);
	}
	static function getUniqueKey($str='',$len=0)
	{
		$key   = md5($str .'-'. time());
		$nums  = array('-','#','%','@','_','=','+','!',',','.');
		$chars = array('Y','Z','Q','M','K','W','R','J','S','U');
		for ($i=0;$i<10;$i++){
			$c = $chars[$i] . $nums[rand(0,9)];
			$key=str_replace($i,$c,$key);
		}
		for ($i=0;$i<strlen($key);$i++){
			$c = $key[$i];
			if(in_array($c,$nums)){
				$key[$i] = rand(0,9);
			}else{
				if($i % 4 ==0)
				$key[$i] = strtolower($key[$i]);
			}
		}
		// max len 64
		return $len>0? substr($key,0,$len): $key;
	}
	static function trimArrayxxx($array,$stripEmpty=false)
	{
		$retval = array();
		foreach($array as $key => $value)
		{
			if(is_string($value))
			{
				$str = trim($value);
				if($stripEmpty)
				{
					if(empty($str))
						unset($array[$key]);
				}else
					$array[$key]=$str;
			}
		}
		return $array;
	}
	static function trimArray($array,$stripEmpty=false)
	{
		foreach($array as $key => $value)
		{
			if(is_string($value))
			{
				$str = trim($value);
				if($stripEmpty)
				{
					if(empty($str))
						unset($array[$key]);
				}else
					$array[$key]=$str;
			}
		}
		return $array;
	}
	static function makeFilename($name,$extension='') 
	{
		if(empty($extension))
			return $name;
		return $name . '.'. ltrim($extension,'.');
	}
	static function iniGetBytes($param_name) 
	{
		if($val = ini_get($param_name))
		{
			$val = trim($val);
			$last = strtolower($val[strlen($val)-1]);
			switch($last) {
				case 'g':
					$val *= 1024;
				case 'm':
					$val *= 1024;
				case 'k':
					$val *= 1024;
			}
		}else
			$val=0;
    	return $val;
	}
	static function isIPAddress($str)
	{
		if(preg_match('/^([0-9]){1,3}\.([0-9]){1,3}\.([0-9]){1,3}\.([0-9]){1,3}+$/',$str,$matches))
		{
			return $matches[1]<256 && $matches[2]<256 && $matches[3]<256 && $matches[4]<256;
		}
		return false;
	}
	static function isEmail($str)
	{
		return filter_var($str, FILTER_VALIDATE_EMAIL);
	}
	static function isUrl($str)
	{
		return self::isFullUrl($str) || self::isAbsUrl($str) || self::isRelativeUrl($str);
	}
	static function isFullUrl($str)
	{
		return filter_var( $str, FILTER_VALIDATE_URL , FILTER_FLAG_PATH_REQUIRED );
	}
	static function isAbsUrl($str)
	{
		if($str){
			return $str[0]=='/' && filter_var( "http://a.com" .$str, FILTER_VALIDATE_URL , FILTER_FLAG_PATH_REQUIRED );
		}
		return false;
	}
	static function isRelativeUrl($str)
	{
		if($str)
		{
			return $str[0]!='/' && !self::startWith('http',$str) && 
			filter_var( "http://a.com/" .$str, FILTER_VALIDATE_URL , FILTER_FLAG_PATH_REQUIRED );
		}
		return false;
	}
	

	// static function sendMail($to,$subject,$message,$from=null,$format=0)
	// {
		// if (is_null($from)){
			// $from = app::$config->siteName.'<'.app::$config->senderEmail.'>';
		// }
		// $pos = strpos($from, "<");
// /*
		// if($pos){
			// $ar = explode("<",$from);
			// $ar = explode(">",$ar[1]);
			// $x_sender = trim($ar[0]);
		// }else
		// $x_sender=$from;
// */

		// //$from     = "Dugrostar<mailer@dugro.com.my>";
		// //$x_sender = "dugro.com.my";
		
		
		// $to = trim(preg_replace('#[\n\r]+#s', '', $to));
		// $subject = trim(preg_replace('#[\n\r]+#s', '', $subject));
		// $from = trim(preg_replace('#[\n\r:]+#s', '', $from));

		// $lf= strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'?"\r\n":"\n";
		// $headers  = "From: $from" .$lf;
		// $headers .= "Date: ".date('r') .$lf;
		// $headers .= "X-Sender: $x_sender" .$lf;
		// $headers .= "X-Mailer: PHP" .$lf; // mailer
		// if ($format==1){
			// $headers .= "Content-Type: text/html; charset=iso-8859-1"; // Mime type
			// $message ="<HTML><BODY>" . $message . "</BODY></HTML>";
		// }
		// else
			// $headers .= "Content-type: text/plain; charset=iso-8859-1"; // Mime type
		
		// mail($to, $subject, $message, $headers);
	// }
	
	static function sendMail($to,$subject,$message,$from=null,$format=0)
	{
		if (is_null($from)){
			$from = app::$config->siteName.'<'.app::$config->senderEmail.'>';
		}
		$pos = strpos($from, "<");

		if($pos){
			$ar = explode("<",$from);
			$ar = explode(">",$ar[1]);
			$x_sender = trim($ar[0]);
		}else
		$x_sender=$from;


		//$from     = "Dugrostar<mailer@dugro.com.my>";
		//$x_sender = "dugro.com.my";


		$to = trim(preg_replace('#[\n\r]+#s', '', $to));
		$subject = trim(preg_replace('#[\n\r]+#s', '', $subject));
		$from = trim(preg_replace('#[\n\r:]+#s', '', $from));

		$lf= strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'?"\r\n":"\n";
		$headers  = "From: $from" .$lf;
		$headers .= "Date: ".date('r') .$lf;
		$headers .= "X-Sender: $x_sender" .$lf;

		$headers .= "X-Mailer: PHP" .$lf; // mailer
		if ($format==1){
			$headers .= "Content-Type: text/html; charset=iso-8859-1"; // Mime type
			$message ="<HTML><BODY>" . $message . "</BODY></HTML>";
		}
		else
			$headers .= "Content-type: text/plain; charset=iso-8859-1"; // Mime type

		mail($to, $subject, $message, $headers);
	}
	
	
	
///////////////////////////////////////////////////////////////////////
//// ARRAY HELPER

	static function isArraySerialized($data)
	{
		if ( preg_match( '/a\:([0-9]+)\:\{(.*)\}$/s', $data ))
			return true;
		return false;
	}
	static function implodeSerializedData($serialized_data,$delim=',')
	{
		if(Helper::isArraySerialized($serialized_data))
			return implode($delim,unserialize($serialized_data));
		return '';
	}
	static function textDelimiterToSerialize($text,$delim=',',$datatype='string')
	{
		$array = array();
		$ar = explode($delim, $text);
		foreach ($ar as $value)
		{
			$val=trim($value);
			if($datatype!='int')   
				$val=intval($val);
			elseif($datatype!='float') 
				$val=floatval($val);
			$array[]= $val;
		}
		return serialize($array);
	}
	static function arrayShuffle($temp)
	{
		$len  = count($array);
		$retval=array();
		for($i=0;$i<$len;$i++)
		{
			 $index     = rand(0,count($array)-1);
			 $retval[]   = $array[$index];
			 array_splice($array,$index,1);
		}
		return $retval;
	}
	static function clamp($value,$min,$max)
	{
		return min($max,max($min,$value));
	}

///////////////////////////////////////////////////////////////////////
//// TEXT HELPER

	public static function safeUrlText($str,$maxlen=255)
	{
		$unicode = '';
		$str = self::removeAccents($str);
		for ($i = 0; $i < strlen( $str ); $i++ ) {
			$value = ord( $str[ $i ] );
			//if ( $value < 128 ) {
			 	$str[ $i ] =	preg_replace("/[^A-Za-z0-9\s]/i", '-', strtolower($str[ $i ]));
			//}
			$unicode .= $str[$i];
		}
	 	$unicode =	preg_replace('#[\s]#si', "-", $unicode);
		while(strpos($unicode,'--')!==false)
		{
			 $unicode =	str_replace("--","-",$unicode);
		}
		$unicode = trim($unicode,'-');
		if(strlen($unicode)> $maxlen)
		{
			$unicode=substr($unicode,0, $maxlen);
			$unicode = trim($unicode,'-');
		}
		return $unicode;
	}
	public static  function seemsUtf8($Str) { # by bmorel at ssi dot fr
		for ($i=0; $i<strlen($Str); $i++) {
			if (ord($Str[$i]) < 0x80) continue; # 0bbbbbbb
			elseif ((ord($Str[$i]) & 0xE0) == 0xC0) $n=1; # 110bbbbb
			elseif ((ord($Str[$i]) & 0xF0) == 0xE0) $n=2; # 1110bbbb
			elseif ((ord($Str[$i]) & 0xF8) == 0xF0) $n=3; # 11110bbb
			elseif ((ord($Str[$i]) & 0xFC) == 0xF8) $n=4; # 111110bb
			elseif ((ord($Str[$i]) & 0xFE) == 0xFC) $n=5; # 1111110b
			else return false; # Does not match any model
			for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
				if ((++$i == strlen($Str)) || ((ord($Str[$i]) & 0xC0) != 0x80))
				return false;
			}
		}
		return true;
	}
	
	public static  function removeAccents($string) {
		if ( !preg_match('/[\x80-\xff]/', $string) )
			return $string;
	
		if (self::seemsUtf8($string)) {
			$chars = array(
			// Decompositions for Latin-1 Supplement
			chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
			chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
			chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
			chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
			chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
			chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
			chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
			chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
			chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
			chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
			chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
			chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
			chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
			chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
			chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
			chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
			chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
			chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
			chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
			chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
			chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
			chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
			chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
			chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
			chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
			chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
			chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
			chr(195).chr(191) => 'y',
			// Decompositions for Latin Extended-A
			
			//chr(196).chr(128) => 'AE', chr(196).chr(129) => 'ae',
			chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
			chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
			chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
			chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
			chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
			chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
			chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
			chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
			chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
			chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
			chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
			chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
			chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
			chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
			chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
			chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
			chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
			chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
			chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
			chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
			chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
			chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
			chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
			chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
			chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
			chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
			chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
			chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
			chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
			chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
			chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
			chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
			chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
			chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
			chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
			chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
			chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
			chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
			chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
			chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
			chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
			chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
			chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
			chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
			chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
			chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
			chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
			chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
			chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
			chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
			chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
			chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
			chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
			chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
			chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
			chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
			chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
			chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
			chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
			chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
			chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
			chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
			chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
			chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
			// Euro Sign
			chr(226).chr(130).chr(172) => 'E',
			// GBP (Pound) Sign
			chr(194).chr(163) => '');
	
			$string = strtr($string, $chars);
		} else {
			// Assume ISO-8859-1 if not UTF-8
			$chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
				.chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
				.chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
				.chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
				.chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
				.chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
				.chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
				.chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
				.chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
				.chr(252).chr(253).chr(255);
	
			$chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";
	
			$string = strtr($string, $chars['in'], $chars['out']);
			$double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
			$double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
			$string = str_replace($double_chars['in'], $double_chars['out'], $string);
		}
	
		return $string;
	}
	
	static function reduceWhiteSpace($html)
	{
		$html = preg_replace('~^\s+~m','',$html);
		$html = preg_replace('~\s+$~m','',$html);
		$html = preg_replace('~\n+~s'," ",$html);
		$html = str_replace('&nbsp;',' ',$html);
		$html = preg_replace('~ +~s',' ',$html);
		return $html;
	}

	static function reduceChars($text, $chars)
	{
		for($i=0;$i<strlen($chars);$i++)
		{
			$char=$chars[$i];
			$regx = preg_quote($char,'/');
			$text = preg_replace('~'.$regx.'+~s',$char,$text);
		}
		return $text;
	}

	static function strNonWordPos($text, $start=0)
	{
		if(preg_match('/[\W]/i',$text,$match,PREG_OFFSET_CAPTURE,$start))
		{
			return $match[0][1];	
		}
		return false;
	}
	static function ellipsis($text, $length, $cut=false, $suffix='...')
	{
		$strlen = strlen($text);
		if($length <$strlen)
		{
			if(!$cut)
			{
				if(false!== $pos=self::strNonWordPos($text,$length))
				{
					$text = substr($text,0,$pos);
				}
			}else
				$text = substr($text,0,$length);
		}
		return $text . $suffix;
	}
	public static  function htmlTextClip($html, $maxLength =0, $pageBreakSeparator='<!-- pagebreak -->')
	{
		
		$splitIndex = empty($pageBreakSeparator)?0: strpos($html, $pageBreakSeparator);
		$strlen = strlen($html);
		
		if($splitIndex>0)
		{
			$html = substr($html,0,$splitIndex);
			$html = self::htmlToPlainText($html);
		}else{
			if($maxLength>0)
			{
				if($maxLength <$strlen){
					$html = self::htmlToPlainText($html,true);
					if(false !== $pos = self::strNonWordPos($html,$maxLength))
					{
						$maxLength = $pos;
					}
					$html = substr($html,0,$maxLength);
				}
			}else
				return $html;
		}
		$html = nl2br($html);
		return $html;
	}
	static function htmlToPlainText($html,$stripnewline=false)
	{
		$html =  self::stripInvisibleTags($html);
		
		$lf = array (
		'/<\/div>/si',
		'/<\/p>/si',
		'/<br \/>/si',
		'/<br>/si',
		'/<\/tr>/si',
		'/<\/h[1-6]>/si',
		'/<\/li>/si'
		);
		if(!$stripnewline)
		{
			$html = preg_replace($lf, "\x02", $html);
			$html = preg_replace('~<li[^/]+>~si','&#8226; ',$html);
		}
		$html = strip_tags($html);
		
		// reducing newline
		$html = preg_replace('~^\s+~m','',$html);
		$html = preg_replace('~\s+$~m','',$html);
		$html = preg_replace('~\n+~s'," ",$html);
		
		if(!$stripnewline)
		{
			$html = preg_replace('~\x02( +)\x02~',"\x02",$html);
			$html = str_replace("\x02","\n",$html);
		}
		// reducing spaces
		$html = str_replace('&nbsp;',' ',$html);
		$html = str_replace('&amp;',' ',$html);
		$html = preg_replace('~ +~s',' ',$html);
		
		return $html;
		
	}
	static function stripTags($html,$reduceWhiteSpace=false)
	{
		
		$html =  self::stripInvisibleTags($html);
		$html = strip_tags($html);
		if($reduceWhiteSpace)
		{
			$html = self::reduceWhiteSpace($html);
		}
		return $html;
	}
	static function stripInvisibleTags($html)
	{
		return preg_replace('/(<link[^>]+rel="[^"]*stylesheet"[^>]*>|<img[^>]*>|style="[^"]*")|<script[^>]*>.*?<\/script>|<style[^>]*>.*?<\/style>|<!--.*?-->/is', '', $html);
	}
	static function stripObjects($html)
	{
		return preg_replace('/(<object([^>]*)<[^>]object(\s*)>)/is', '', $str);
	}
	static function stripImages($html)
	{
		$str = preg_replace('/(<a[^>]*>)(<img[^>]+alt=")([^"]*)("[^>]*>)(<\/a>)/i', '$1$3$5' , $str);
		$str = preg_replace('/(<img[^>]+alt=")([^"]*)("[^>]*>)/i', '$2', $str);
		$str = preg_replace('/<img[^>]*>/i', '' , $str);
		return $str;
	}
	static function stripLinks($html)
	{
		return preg_replace('/<a.*>(.*)<\/a>/m', '\\1', $html);
	}
	static function stripScripts($html)
	{
		return preg_replace('/<script.*>(.*)<\/script>/m', '', $html);
	}
	static function stripInvisibleChars($str)
	{
		$paterns = array(
			'/%0[0-8]/', '/[\x00-\x08]/',			// 00-08
			'/%11/', '/\x0b/', '/%12/', '/\x0c/',	// 11, 12
			'/%1[4-9]/', '/%2[0-9]/', '/%3[0-1]/',	// url encoded 14-31
			'/[\x0e-\x1f]/');						// 14-31
			
		return preg_replace($paterns, '', $str);
	}
	
	static function containsHyperlink($text)
	{
		if(preg_match('#([\s>])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is',$text))
			return true;
		if(preg_match('#([\s>])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is',$text))
			return true;
		if(preg_match('#([\s>])([a-z0-9\-_.]+)@([^,< \n\r]+)#i',$text) )
			return true;
			
		return false;
	}
	static function makeClickable($ret)
	{
		$ret = ' ' . $ret;
		// in testing, using arrays here was found to be faster
		$ret = preg_replace(
			array(
				'#([\s>])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is',
				'#([\s>])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is',
				'#([\s>])([a-z0-9\-_.]+)@([^,< \n\r]+)#i'),
			array(
				'$1<a href="$2" rel="nofollow">$2</a>',
				'$1<a href="http://$2" rel="nofollow">$2</a>',
				'$1<a href="mailto:$2@$3">$2@$3</a>'),$ret);
		// this one is not in an array because we need it to run last, for cleanup of accidental links within links
		$ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
		$ret = trim($ret);
		return $ret;
	}
	static function plainToHtml($text,$clickable=true, $htmlentities=true)
	{
		$text = self::stripTags($text,false);
		if($htmlentities)
			$text = htmlentities($text);
		if($clickable)
			$text = self::makeClickable($text);
		$text = nl2br($text);
		return $text;
	}
	
	static function wordsUnique($text, $spr = "/[\s]+/")
	{
		 $text = trim($text);
		 if(!empty($text))
		 {
			 return array_unique(preg_split($spr, $text));
		 }
		 return null;
	}
	static function searchWords($text)
	{
		$retval=array();
		 if($arr = self::wordsUnique($text,"/[\s\W]+/"))
		 {
		 	foreach($arr as $str)
			{
				if(strlen($str)>1)
				{
					$retval[] = strtolower($str);
				}
			}
		 }
		 return $retval;
	}
	static function searchLogical($text,$field)
	{
	//	$ar = self::searchWords($text);
		//$retval = "($field='" . implode("' AND $field='", $ar) . "') OR $field IN('" .   implode("', '", $ar) . "')";
		//$retval = "$field IN('" .   implode("', '", $ar) . "')";
	}

	static function trailingSlashit($string) {
		return untrailingslashit($string) . '/';
	}
	
	static function untrailingSlashit($string) {
		return rtrim($string, '/');
	}

	static function startWith($int_start,$str)
	{
		if(empty($int_start) || empty($str)) 
			return false;
			
		$pos = strpos($str,$int_start);
		return($pos!==false && $pos==0);
	}
	
	static function buildUrl($url,$queries) 
	{
		$_queries = array();
		$pos = strpos($url,"?");
		if( $pos >0 ){
			
			$queries_str = substr($url,$pos+1);
			$url         = substr($url,0,$pos);
			if(is_array($queries)){
				parse_str($queries_str,$_queries);
				$_queries = array_merge($queries, $_queries);
			}else{
				parse_str($queries_str . '&'. ltrim($queries,'&') ,$_queries);
			}
			return $url . '?' . http_build_query($_queries);
		}else{
			if(is_array($queries)){
				return $url . '?' . http_build_query($queries);
			}else{
				return $url . '?'. ltrim($queries,'&');
			}
		}
	}
	
	
	static function htmlEntitiesToAscii($str, $all = true)
	{
	   if (preg_match_all('/\&#(\d+)\;/', $str, $matches))
	   {
		   for ($i = 0, $s = count($matches['0']); $i < $s; $i++)
		   {				
			   $digits = $matches['1'][$i];
			   $out = '';
			   if ($digits < 128)
			   {
				   $out .= chr($digits);
			   }
			   elseif ($digits < 2048)
			   {
				   $out .= chr(192 + (($digits - ($digits % 64)) / 64));
				   $out .= chr(128 + ($digits % 64));
			   }
			   else
			   {
				   $out .= chr(224 + (($digits - ($digits % 4096)) / 4096));
				   $out .= chr(128 + ((($digits % 4096) - ($digits % 64)) / 64));
				   $out .= chr(128 + ($digits % 64));
			   }
			   $str = str_replace($matches['0'][$i], $out, $str);				
		   }
	   }
	   $str = str_replace(array("&amp;", "&lt;", "&gt;", "&quot;", "&apos;", "&#45;"),
			array("&","<",">","\"", "'", "-"),
			$str);
	   
	   return $str;
	}

	private static  function dateGetPartValue($date,$part_name)
	{
		if(!empty($date)){
			if(is_numeric($date))
			{
				if($date>100000){
					return date($part_name,$selected_date);
				}
				return $date;
			}else{
				$ar = explode('-',$date);
				if($part_name=='Y')
					return $ar[0];
				else if($part_name=='n')
					return $ar[1];
				else  if($part_name=='j')
				{
					return intval($ar[2]);	
				}
			}
		}
		return null;
	}
	
	/////////////
	
	public static  function htmlOption($text, $value="", $selected_exp = false)
	{
		return '<option value="'. $value .'"'.  ($selected_exp ?' selected="selected"':'')  .'>'. $text .'</option>';
	}
	public static function htmlMonthOptions($selected=null, $label=null)
	{
		
		$months = App::$locale->monthNames;
		if(!empty($label))
		{
			array_unshift($months, $label);
			$array = $months;
		}else{
			$array = array();
			for($i=1;$i<=12;$i++){
				$array[$i] = $months[$i-1];
			}
		}
		return Helper::htmlOptionsFromArray($array, self::dateGetPartValue($selected,'n'));
	}
	public static function htmlDateOptions($selected=null, $label='')
	{
		return (!empty($label)?self::htmlOption($label):"") . Helper::htmlNumberOptions(1,31, self::dateGetPartValue($selected,'j') ,2);
	}
	public static function htmlYearOptions($startyear, $endyear, $selected=null,$label='')
	{
		return (!empty($label)?self::htmlOption($label):"") . Helper::htmlNumberOptions($startyear,$endyear, self::dateGetPartValue($selected,'Y'));
	}
	public static  function htmlNumberOptions($min,$max,$selected=0,$num_digits=0,$increament=1)
	{	
		$retval= array();
		
		$from = min($min,$max);
		$to   = max($min,$max);
		$num  = $from;
		for($i=$from;$i<=$to;$i++)
		{
			$sltd= empty($selected)?'':($selected==$num?' selected="selected"':'');
			$text = $num_digits>0? str_pad($num, $num_digits, "0", STR_PAD_LEFT):$num;
			
			$retval[] = "<option value=\"{$num}\"$sltd>". $text ."</option>";
			$num += $increament;
		}
		if($min>$max)
			$retval=array_reverse($retval);
		return implode("",$retval);
	}	
	public static  function htmlOptionsFromDatarow($items, $value_field,$text_field, $selected_value=0,$selected_exp = true)
	{
		$retval='';
		foreach ($items as $item)
		{
			$selected= ($selected_exp && $item[$value_field]==$selected_value)?' selected':'';
			$retval .=  '<OPTION value="'.$item[$value_field].'"'. $selected .'>'.$item[$text_field]."</OPTION>\n";
		}
		return $retval;
	}
	public static  function htmlOptionsFromArray($array, $selected_value=0)
	{
		$retval='';
		foreach ($array as $key =>$value)
		{
			$selected= ($key==$selected_value)?' selected="selected"':'';
			$retval .=  '<OPTION value="'.$key.'"'. $selected .'>'.$value."</OPTION>\n";
		}
		return $retval;
	}
}