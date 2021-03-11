<?php 
session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Food Blog</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h1>Food Blog</h1>
    <div id="wrapper">
    <div id="menu">
        <a class="item" href="?page=home.php">Home</a> &emsp;
         
		 <?php
			
			if(isset($_SESSION["username"])){
					include 'connection.php';
					
					//get user data	
					$username=$_SESSION["username"];
					$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username';");
					$data = mysqli_fetch_assoc($query);
					
					//show pages of exist user
					if(isset($_SESSION["username"])){
						echo '<a class="item" href="?page=forum.php">Forum</a> &emsp;';
						echo '<a class="item" href="?page=recipes.php&directory=receipes">Receipes</a> &emsp;';
						echo '<a class="item" href="?page=user_settings.php">User Settings</a> &emsp;';
						echo '<a class="item" href="?page=contact.php">Contact Us</a> &emsp;';

					}
				}
		 ?>
		 
		<div id="userbar">
		    <?php

				//show page of guest
				if(isset($_SESSION["username"])){
					echo 'Hello <b>' . $_SESSION["username"] . '.</b> Not you? <a class="item" href="?page=signout.php">Sign out</a>&emsp;';
					
					//show page of admin user
					if($data["isadmin"] == true){
						echo '<a class="item" href="?page=admin.php">Admin</a> &emsp;';
					}
				}
				//show page of guest
				else
					echo '<a class="item" href="?page=login.php">login</a> &emsp; <a class="item" href="?page=register.php">create an account</a>';
			?>
		</div>

    </div>
    <div id="content">
