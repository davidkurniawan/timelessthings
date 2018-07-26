<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HTTP 404 Not Found</title>
<style>

</style>
</head>

<body>

<div id="msg_panel">
	<img src="/images/warning.jpg" />
    <div>
        <h1>HTTP 404 Bad Request</h1>
        <p>The link you followed is incorrect or outdated.</p>
    </div>
</div>

</body>
</html>
