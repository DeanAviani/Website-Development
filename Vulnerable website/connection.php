<?php

	//connection details to the site's DB
	$server_name="localhost";
	$user_name="nitzanyc_root";
	$password="12345";
	$database_name="nitzanyc_cookingdb";
	
	//Create connection
	$conn = mysqli_connect($server_name, $user_name, $password, $database_name);
	
	//Check connection
	if($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>