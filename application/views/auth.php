
<?php
  // User name and password for authentication
  $username = 'admin';
  $password = 'admin';
  if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    ($_SERVER['PHP_AUTH_USER'] != $username) || ($_SERVER['PHP_AUTH_PW'] != $password)) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm=" Lucky_pixeldot"');
    exit('<h2>Lucky_pixeldot </h2>Sorry, you must enter a valid user name and password to access this page.');
  }
?>
