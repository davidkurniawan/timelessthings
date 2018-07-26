<?php


class Ipsum
{
	
	private static $__sentences;
	private static $__words;
	private static $len_words;
	

	public static function init()
	{
		
		$_sentences = "Mauris nec mauris luctus et ultrices posuere eget tortor scelerisque. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed congue mauris. Aliquam condimentum sagittis nisi. Suspendisse vehicula congue elit. Curabitur pulvinar auctor pede. In hac habitasse platea dictumst. Vivamus sed pede ac mauris elementum rhoncus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Ut convallis. In lacinia, neque ac dictum mollis, mauris lectus luctus lacus, id tincidunt enim velit sed augue. Nulla ligula. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vestibulum leo purus, egestas at, placerat sit amet, blandit aliquam, arcu. Donec dapibus lectus ut enim. Phasellus eros. Quisque pretiumeros sit amet sapien. Duis nunc ipsum, mollis quis, hendrerit quis, placerat ac, nunc. Nulla tincidunt felis a nisi. Phasellus pellentesque consequat felis. Nam eros. Phasellus auctor, lacus vitae porttitor rhoncus, urna orcilaoreet ligula, quis eleifend orci orci vel dui. Lorem ipsum dolor etiam purus sapien, semper quis, lobortis ut, imperdiet sed, massa.lacus. Vestibulum  turpis in lacus tincidunt facilisis. hac habitasse platea dictumst. Donec porttitor libero vitae arcu. Sed volutpat lectus vitae mi. Vestibulum in quam. Fusce tincidunt turpis. Fusce cursus leo. Pellentesque nibh. Donec condimentum ipsum non dui. Nullam mi arcu pretium eu, sagittis eget, suscipit a, velit. Vivamus convallis velit a orci interdum condimentum. Praesent vitae urna et mi convallis aliquet. Nunc semper erat sit amet enim. Praesent mattis ultricies nisi. Quisque id leo quis tellus porta rhoncus. Fusce ornare posuere odio. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec consequat, magna nec tempor tincidunt, odio dui dictum ipsum, sed sagittis dolor lacus eget nulla. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas pulvinar metus ac dui. Ut sit amet orci. Donec nisl lectus, egestas , dapibus , tincidunt , magna. Mauris nec mauris.Nulla ligula ultricies dapibus. Aliquam  sem eget tortor scelerisque aliquam. Pellentesque feugiat enim ut erat. Nunc ut velit in magna aliquet malesuada. Ut mattis, sem non bibendum viverra, lorem libero commodo urna, quis laoreet mauris nisi a pede. In ligula lectus, pellentesque sed, ultricies elementum, lacinia condimentum, dolor. Etiam nec massa. Quisque commodo dapibus tellus. Vivamus blandit, sapien ac vehicula tempor, elit lacus egestas lacus, id eleifend dui pede nec ipsum";
		
		$_words = "lorem ipsum dolor sit ame consectetuer adipiscing elit sed congue mauris aliquam condimentum sagittis nisi suspendisse vehicula curabitur pulvinar auctor pede hac habitasse platea dictumst vivamus elementum rhoncus vestibulum ante primis faucibus orci luctus ultrices posuere cubilia curae convallis lacinia neque dictum mollis lectus lacus tincidunt enim velit augue nulla ligula fusce ornare odio donec consequat magna nec tempor dui eget pellentesque habitant morbi tristique senectus netus malesuada fames turpis egestas maecenas metus amet nisl dapibus est ultricies sem tortor scelerisque feugiat erat nunc aliquet mattis non bibendum viverra libero commodo urna quis laoreet etiam massa quisque tellus blandit sapien eleifend leo purus placerat arcu phasellus eros pretium duis hendrerit felis nam vitae porttitor vel semper lobortis imperdiet facilisis volutpat quam cursus nibh nullam suscipit interdum praesent porta";
	
		self::$__sentences = explode(".",$_sentences);
		self::$__words = explode(" ",$_words);
		self::$len_words = count(self::$__words);
	}
	public static function get_words($numwords=4)
	{
		$ar=array();
		for ($i = 0; $i < $numwords; $i++)
		{
			$ar[] = self::$__words[ rand(0,self::$len_words-1) ];
		}
		return ucfirst(implode(" ", $ar));
	}
	public static function get_title($numwords=4)
	{
		return ucwords(self::get_words($numwords));
	}
	public static function words($numwords=4)
	{
		echo self::get_words($numwords);
	}
	public static function title($numwords=4)
	{
		echo self::get_title($numwords);
	}
	public static function getP()//$min= 4, $numP=5)
	{
		for($i=0; $i< rand(4,5); $i++)
		{
			$r = rand(60,150);
			echo "<p>";
			self::words($r);
			echo "</p>\r\n";
		}
		
	}	
	public static function getPa()//$min= 4, $numP=5)
	{
		$retval = array();
		for($i=0; $i< rand(4,5); $i++)
		{
			$r = rand(60,150);
			$retval[]= "<p>";
			$retval[]= self::get_words($r);
			$retval[]= "</p>\r\n";
		}
		return implode("",$retval);
	}	
	
}

ipsum::init();





















?>