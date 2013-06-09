<html>
<head>
	<title><?php $title ?> 's 博客后台管理</title>
</head>
<body>
	<?php
	 
	  $username = 'rock';
	  $password = 'roll';

	  if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
	    ($_SERVER['PHP_AUTH_USER'] != $username) || ($_SERVER['PHP_AUTH_PW'] != $password)) {
	    // The user name/password are incorrect so send the authentication headers
	    header('HTTP/1.1 401 Unauthorized');
	    header('WWW-Authenticate: Basic realm="Guitar Wars"');
	    exit('Sorry, you must enter a valid user name and password to access this manage pages!');
	  }
	?>
	<p>login</p>
</body>
</html>