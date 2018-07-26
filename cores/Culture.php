<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////



class Culture
{
	public
		$name,
		$englishName,
		$nativeName,
		$language,
		$textDirection,
		$numberFormat,
		$percentFormat,
		$currencyFormat,
		$firstDayOfWeek,
		$dayNames,
		$abbrDayNames,
		$shortDayNames,
		$monthNames,
		$abbrMonthNames,
		$meridiemNames,
		$dateTimeFormats;

	public  function __construct($lang='en')
	{
		$this->name = $lang;
		$inc = LIB_PATH .DS.'cultures'.DS. $lang .'.php';
		if(!file_exists($inc))
		{
			$inc = LIB_PATH .DS.'cultures'.DS.'en.php';
			$this->name = 'en';
		}
		//echo app::$config->lang;exit;
		setlocale(LC_ALL, app::$config->lang);
		require $inc;
		
	}
	
	
	public function formatDate($timestamp,$format)
	{
		if(!is_numeric($timestamp))
		{
			if (is_a($timestamp, 'DateTime')) 
			{
				$timestamp = $timestamp->format('U');
			}else{
				$timestamp =strtotime($timestamp);
			}
			
		}
		//$timestamp = is_numeric($timestamp)? $timestamp:strtotime($timestamp);

		if($this->language!='en')
		{
			if(preg_match_all('#%(B|b|A|a)#',$format,$match))
			{
				foreach($match[0] as $patern)
				{
					switch($patern)
					{
						case '%B':
							$format = str_replace('%B',$this->monthNames[date('n', $timestamp)-1],$format);break;
						case '%b':
							$format = str_replace('%b',$this->abbrMonthNames[date('n', $timestamp)-1],$format);break;
						case '%A':
							$format = str_replace('%A',$this->dayNames[date('w', $timestamp)], $format);break;
						case '%a':
							$format = str_replace('%a',$this->abbrDayNames[date('w', $timestamp)],$format);break;
					}
				}
			}
		}
		if(preg_match_all('#%(P|p|e|l)#',$format,$match))
		{
			foreach($match[0] as $patern)
			{
				switch($patern)
				{
					case '%e':
						$format = str_replace('%e',date('j',$timestamp),$format);break;
					case '%l':
						$format = str_replace('%l',date('g',$timestamp),$format);break;
					case '%P':
						$format = str_replace('%P', $this->meridiemNames[date('a',$timestamp)],$format);break;
					case '%p':
						if($this->language!='en')
							$format = str_replace('%p', $this->meridiemNames[date('A',$timestamp)],$format);
						break;
				}
			}
		}
		return strftime($format,$timestamp);
	}
	
	public  function strShortDate($timestamp)
	{
		return  $this->formatDate($timestamp,$this->dateTimeFormats['short_date']);
	}
	public  function strLongDate($timestamp)
	{
		return  $this->formatDate($timestamp,$this->dateTimeFormats['long_date']);
	}
	public  function strShortTime($timestamp)
	{
		return  $this->formatDate($timestamp,$this->dateTimeFormats['short_time']);
	}
	public  function strLongTime($timestamp)
	{
		return  $this->formatDate($timestamp,$this->dateTimeFormats['long_time']);
	}
	public  function strShortDateTime($timestamp)
	{
		return  $this->formatDate($timestamp, $this->dateTimeFormats['short_date_time']);
	}
	public  function strLongDateTime($timestamp)
	{
		return   $this->formatDate($timestamp,$this->dateTimeFormats['long_date_time']);
	}
	public  function strFullDateTime($timestamp)
	{
		return  $this->formatDate($timestamp,$this->dateTimeFormats['full_date_time']);
	}
	public  function strMonthDay($timestamp)
	{
		return  $this->formatDate($timestamp,$this->dateTimeFormats['month_day']);
	}
	public  function strYearMonth($timestamp)
	{
		return  $this->formatDate($timestamp,$this->dateTimeFormats['year_month']);
	}
	public  function strISODate($timestamp,$UTC=false)
	{
		$timestamp = is_numeric($timestamp)? $timestamp:strtotime($timestamp);
		return date('c',$timestamp);
	}
	public  function strDayDateTime($timestamp)
	{
		$timestamp = is_numeric($timestamp)? $timestamp:strtotime($timestamp);
		return  $this->formatDate($timestamp, '%A %d, ' . $this->dateTimeFormats['t']); 
	}
	public  function formatMoney($number,$decimals=null)
	{
		$decimals = is_null($decimals)?$this->currencyFormat['decimals']: $decimals;
		return number_format($number,$decimals, $this->currencyFormat['separators'][1],$this->currencyFormat['separators'][0]);
	}
	public  function formatMumber($number,$decimals=null)
	{
		$decimals = is_null($decimals)?$this->numberFormat['decimals']: $decimals;
		return number_format($number,$decimals, $this->numberFormat['separators'][1],$this->numberFormat['separators'][0]);
	}
	public  function formatPercent($number,$decimals=null)
	{
		$decimals = is_null($decimals)?$this->percentFormat['decimals']: $decimals;
		return number_format($number,$decimals, $this->percentFormat['separators'][1],$this->percentFormat['separators'][0]);
	}
}
?>