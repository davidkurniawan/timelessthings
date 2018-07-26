<?php 
			$this->englishName    = "English (South Africa)"; 
			$this->nativeName     = "English (South Africa)"; 
			$this->language       = "en"; 
			$this->textDirection   = "ltr"; 
			$this->numberFormat   = array 
			( 
				"separators"      => array(" ","."), 
				"groupsizes"      => array(3), 
				"decimals"        => 2, 
				"paterns"         => array("-n","n") 
			); 
			$this->currencyFormat = array 
			( 
				"separators"      => array(" ","."), 
				"groupsizes"      => array(3), 
				"decimals"        => 2, 
				"paterns"         => array("\$-n","\$ n"), 
				"symbol"          => "R" 
			); 
			$this->percentFormat = array 
			( 
				"separators"      => array(" ","."), 
				"groupsizes"      => array(3), 
				"decimals"        => 2, 
				"paterns"         => array("-n%","n%"), 
				"symbol"          => "%" 
			); 
			
			$this->firstDayOfWeek     =  0; 
			$this->dayNames           =  array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"); 
			$this->abbrDayNames       =  array("Sun","Mon","Tue","Wed","Thu","Fri","Sat"); 
			$this->shortDayNames      =  array("Su","Mo","Tu","We","Th","Fr","Sa"); 
			$this->monthNames         =  array("January","February","March","April","May","June","July","August","September","October","November","December"); 
			$this->abbrMonthNames     =  array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"); 
			$this->meridiemNames      =  array("am"=>"am","AM"=>"AM","pm"=>"pm","PM"=>"PM"); 
			
			$this->dateTimeFormats = array 
			( 
				"short_date"     => "%Y/%m/%d", 
				"long_date"      => "%d %B %Y", 
				"short_time"     => "%I:%M %P", 
				"long_time"      => "%I:%M:%S %P", 
				"short_date_time"=> "%Y/%m/%d %I:%M %P", 
				"long_date_time" => "%d %B %Y %I:%M %P", 
				"full_date_time" => "%d %B %Y %I:%M:%S %P", 
				"year_month"     => "%B %Y", 
				"month_day"      => "%d %B" 
			); 
?>