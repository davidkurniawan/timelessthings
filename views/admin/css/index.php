<?php

	//header('Expires: ' . gmdate('r', time() + 315359944) );
	//header('Cache-Control: public, max-age=315359944');
	header('Content-type: text/css');
	
  ob_start("compress");
  function compress($buffer) {
    /* remove comments */
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', ' ', $buffer);
    /* remove tabs, spaces, newlines, etc. */
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), ' ', $buffer);
    return $buffer;
  }
	
	$cssfiles = array();
	$css_dir = dirname(__FILE__);
	if ($handle = @ opendir($css_dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") 
			{
				if(preg_match('/^(.*)\.css+$/',$file))
				{
					$cssfiles[] =  $css_dir .DIRECTORY_SEPARATOR.$file;
				}
			}
		}
		closedir($handle);
	}
	
	//
	sort($cssfiles);
	foreach($cssfiles as $cssfile)
	{
		//echo $cssfile . "<br>";
		require  $cssfile;
	}
	ob_end_flush();
	
?>