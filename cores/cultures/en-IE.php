<?php 
			$this->englishName    = "English (Ireland)"; 
			$this->nativeName     = "English (Ireland)"; 
			$this->language       = "en"; 
			$this->textDirection   = "ltr"; 
			$this->numberFormat   = array 
			( 
				"separators"      => array(",","."), 
				"groupsizes"      => array(3), 
				"decimals"        => 2, 
				"paterns"         => array("-n","n") 
			); 
			$this->currencyFormat = array 
			( 
				"separators"      => array(",","."), 
				"groupsizes"      => array(3), 
				"decimals"        => 2, 
				"paterns"         => array("-\$n","\$n"), 
				"symbol"          => "€" 
			); 
			$this->percentFormat = array 
			( 
				"separators"      => array(",","."), 
				"groupsizes"      => array(3), 
				"decimals"        => 2, 
				"paterns"         => array("-n %","n %"), 
				"symbol"          => "%" 
			); 
			
			$this->firstDayOfWeek     =  1; 
			$this->dayNames           =  array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"); 
			$this->abbrDayNames       =  array("Sun","Mon","Tue","Wed","Thu","Fri","Sat"); 
			$this->shortDayNames      =  array("Su","Mo","Tu","We","Th","Fr","Sa"); 
			$this->monthNames         =  array("January","February","March","April","May","June","July","August","September","October","November","December"); 
			$this->abbrMonthNames     =  array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"); 
			$this->meridiemNames      =  array("am"=>"","AM"=>"","pm"=>"","PM"=>""); 
			
			$this->dateTimeFormats = array 
			( 
				"short_date"     => "%d/%m/%Y", 
				"long_date"      => "%d %B %Y", 
				"short_time"     => "%H:%M", 
				"long_time"      => "%H:%M:%S", 
				"short_date_time"=> "%d/%m/%Y %H:%M", 
				"long_date_time" => "%d %B %Y %H:%M", 
				"full_date_time" => "%d %B %Y %H:%M:%S", 
				"year_month"     => "%B %Y", 
				"month_day"      => "%d %B" 
			); 
?>