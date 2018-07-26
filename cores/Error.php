<?php
if(!defined('ERROR_LOG'))
	define('ERROR_LOG','error.log');
	
function isDebugMode()
{
	return (defined('DEBUG_MODE')? intval(DEBUG_MODE) ==1: false);
}
class ErrorLog
{
	static public function delete()
	{
		@unlink (ERROR_LOG);
	}
	static public function append($errno, $errmsg, $filename, $linenum)
	{
		$err =  date("Y-m-d H:i:s") . "\t" . $errno  . "\t" . $errmsg . "\t" . $filename . "\t" . $linenum . "\n";
		error_log($err, 3, ERROR_LOG);
	}
}

function errorHandler($errno, $errmsg, $filename, $linenum) 
{
	$errortype = array (
                E_ERROR              => 'Error',
               // E_WARNING          => 'Warning',
                E_PARSE              => 'Parsing Error',
                //E_NOTICE           => 'Notice',
                E_CORE_ERROR         => 'Core Error',
               // E_CORE_WARNING     => 'Core Warning',
                E_COMPILE_ERROR      => 'Compile Error',
               // E_COMPILE_WARNING  => 'Compile Warning',
                E_USER_ERROR         => 'Error',
                E_USER_WARNING       => 'Warning',
                E_USER_NOTICE        => 'Notice',
               // E_STRICT           => 'Runtime Notice',
                E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'
	);
		$isDbError = substr($errmsg,0,5)=='E_DB~';
		if($isDbError) $errmsg = substr($errmsg,5);
		$errtitle   = $isDbError? QueryHistory::getLastQuery('provider') . ' Error': $errortype[$errno];
		ErrorLog::append($errno, $errmsg, $filename, $linenum);
		
	if(isDebugMode())
	{
		Response::clearContent();
		$err = new ErrorException($errmsg);
	?>
    <html><head><title><?php echo $errtitle . " in '".Request::pathUrl()."'"  ?></title></head>
    <body style="margin:15px;font-family:Verdana, Arial, Helvetica, sans-serif">
	<div>
	<b style="font-size:14pt;color:#FF0000"><?php echo $errtitle . " in '".Request::pathUrl()."'"  ?></b>
	<div><?php echo $errmsg.', in file '.$filename.' on line <b>'.$linenum.'</b>' ?></div><br />
	<?php
    if($isDbError){
        $err_sql = QueryHistory::getLastQuery('sql');
		if(!empty( $err_sql)){
    ?>
	<div style="margin-bottom:5px"><b>SQL syntax:</b></div>
	<div style="background-color:#FFFFCC; padding:10px;">
		<pre><?php echo $err_sql; ?></pre>
	</div><br />
    <?php
    }}
    ?>
	<div style="margin-bottom:5px;"><b>Stack Trace:</b></div>
	<div style="background-color:#FFFFCC; padding:10px;">
		<pre><?php echo $err->getTraceAsString(); ?></pre>
	</div>
	</div>
    </body></html>
	<?php
		exit;
	}else
	{
		if($errno != E_NOTICE)
			Response::setStatus(501,true);
	}
}

set_error_handler('errorHandler',E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR |  E_USER_NOTICE | E_USER_WARNING | E_RECOVERABLE_ERROR);
?>