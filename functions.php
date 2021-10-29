<?php
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$dbname = "test";
	
	$appname = "OpenPaycheck";
	
	$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	if(mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	//else{ echo "JEEEEEEEEEEEEE!!!!!!!!!!!!";}
	
	function createTable($con, $name, $query){
		queryMysql($con, "CREATE TABLE IF NOT EXISTS $name($query)");
		echo "Table '$name' created or already exists.<br />";
	}
	
	function queryMysql($con, $query){
		$result = mysqli_query($con, $query) or die(mysqli_error($con));
		return $result;
	}
	
	function destroySession(){
		$_SESSION = array();
		
		if(session_id() != "" || isset($_COOKIE[session_name()])){
			setcookie(session_name(), '', time()-2592000, '/');
		}
		session_destroy();
	}
	
	function sanitizeString($con, $var){
		$var = strip_tags($var);
		$var = htmlentities($var);
		$var = stripslashes($var);
		return mysqli_real_escape_string($con, $var);
	}
?>