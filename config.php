
<?php
      
define( 'BASE_PATH', 'todo-app/');
define('DB_HOST', 'localhost');
define('DB_NAME', 'todo-app');
define('DB_USERNAME','todo-app-user');
define('DB_PASSWORD','yjdsqgfhjkm');


$mysqli  = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()) {
	echo("Failed to connect, the error message is : ". mysqli_connect_error());
	exit();
}
    ?>