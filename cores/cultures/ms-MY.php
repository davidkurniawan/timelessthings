<?php 
			$this->englishName    = "Malay (Malaysia)"; 
			$this->nativeName     = "Bahasa Melayu (Malaysia)"; 
			$this->language       = "ms"; 
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
				"decimals"        => 0, 
				"paterns"         => array("(\$n)","\$n"), 
				"symbol"          => "RM" 
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
			$this->dayNames           =  array("Ahad","Isnin","Selasa","Rabu","Khamis","Jumaat","Sabtu"); 
			$this->abbrDayNames       =  array("Ahad","Isnin","Sel","Rabu","Khamis","Jumaat","Sabtu"); 
			$this->shortDayNames      =  array("A","I","S","R","K","J","S"); 
			$this->monthNames         =  array("Januari","Februari","Mac","April","Mei","Jun","Julai","Ogos","September","Oktober","November","Disember"); 
			$this->abbrMonthNames     =  array("Jan","Feb","Mac","Apr","Mei","Jun","Jul","Ogos","Sept","Okt","Nov","Dis"); 
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