<?php
if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found");
	exit ;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$ismobile = Request::userAgent() -> isMobile();

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>HTTP 404 Not Found</title>

	</head>

	<body>



	
		<div id="pageContents">
			<div class="container">

				<div>
					<h1>HTTP 404 Not Found</h1>
					
				</div>
			</div>

		</div>
		
		
		
		
	
	

		

	</body>
</html>
