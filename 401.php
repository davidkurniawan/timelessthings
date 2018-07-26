<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HTTP 401 Unauthorized</title>
<style>

</style>
</head>

<body>

<div id="msg_panel">
	
    <div>
        <h1>HTTP 401 Unauthorized</h1>
        <p>You do not have permission to view this page</p>
    </div>
</div>

</body>
</html>
