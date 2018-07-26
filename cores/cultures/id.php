<?php 
			$this->englishName    = "Indonesian"; 
			$this->nativeName     = "Bahasa Indonesia"; 
			$this->language       = "id"; 
			$this->textDirection   = "ltr"; 
			$this->numberFormat   = array 
			( 
				"separators"      => array(".",","), 
				"groupsizes"      => array(3), 
				"decimals"        => 2, 
				"paterns"         => array("-n","n") 
			); 
			$this->currencyFormat = array 
			( 
				"separators"      => array(".",","), 
				"groupsizes"      => array(3), 
				"decimals"        => 0, 
				"paterns"         => array("(\$ n)","\$ n"), 
				"symbol"          => "Rp" 
			); 
			$this->percentFormat = array 
			( 
				"separators"      => array(".",","), 
				"groupsizes"      => array(3), 
				"decimals"        => 2, 
				"paterns"         => array("-n %","n %"), 
				"symbol"          => "%" 
			); 
			
			$this->firstDayOfWeek     =  1; 
			$this->dayNames           =  array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"); 
			$this->abbrDayNames       =  array("Mg","Sen","Sel","Rabu","Kamis","Jumat","Sabtu"); 
			$this->shortDayNames      =  array("M","S","S","R","K","J","S"); 
			$this->monthNames         =  array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember"); 
			$this->abbrMonthNames     =  array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agust","Sep","Okt","Nop","Des"); 
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