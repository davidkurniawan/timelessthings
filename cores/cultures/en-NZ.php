<?php 
			$this->englishName    = "English (New Zealand)"; 
			$this->nativeName     = "English (New Zealand)"; 
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
				"symbol"          => "\$" 
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
			$this->meridiemNames      =  array("am"=>"a.m.","AM"=>"A.M.","pm"=>"p.m.","PM"=>"P.M."); 
			
			$this->dateTimeFormats = array 
			( 
				"short_date"     => "%e/%m/%Y", 
				"long_date"      => "%A, %e %B %Y", 
				"short_time"     => "%l:%M %P", 
				"long_time"      => "%l:%M:%S %P", 
				"short_date_time"=> "%e/%m/%Y %l:%M %P", 
				"long_date_time" => "%A, %e %B %Y %l:%M %P", 
				"full_date_time" => "%A, %e %B %Y %l:%M:%S %P", 
				"year_month"     => "%B %Y", 
				"month_day"      => "%d %B" 
			); 
?>