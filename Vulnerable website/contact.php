<?php
	
	if(is_null($_SESSION["username"])){
		header("Location: ?page=login.php");
	}
	
	$error_send_message="";
	$error_check_connection="";
	$result_send_message="";
	$result_check_connection="";
	
		 if(isset($_POST["check"])){
			//execute ping command 
			$address = $_POST["IP_address"];
			$result_check_connection= shell_exec("ping ".$address);
		 }
		
		else if(isset($_GET["desc"])){
			$post_desc = $_GET["desc"];
		
			if(empty($post_desc))
				$error_send_message = "Invalid inputs!";
			else{
				$result_send_message= "Your message: \"".$post_desc. "\" was sent!"; // show the user's message
				
				//SMTP Server configuration
				ini_set('SMTP', "mail.smtp2go.com");
				ini_set('smtp_port', "25");
				ini_set('sendmail_from', "email@domain.com");
				
				mail("admin@foodblog.com", "User message",$post_desc); // send the user's message to the admin
			}
		}
?>

<!DOCTYPE html>
<html>
	<head>
	</head>

	<body>
		<h2>Contact Us</h2>
		<p>Before you report a problem, please check if your connection is stable.</p>
		
			<form action="?page=contact.php" method="POST">
				Server IP: <input type="text" name= "IP_address"value='<?php echo $_SERVER['SERVER_ADDR'];?>' readonly>
				<input type="submit" value="Check connection to the server" name="check"><br>
				<p style=color:red;"> <?php echo $error_check_connection ?> </p>
				<p style=color:green;"> <?php echo $result_check_connection ?> </p>
			</form>
		
		<br><p>If the connection is stable, leave us a message and we'll get back to you as soon as possible</p>
		<form action="index.php" method="GET">
			<input type="hidden" name="page" value="contact.php">
			<textarea rows="25" name ="desc" cols="50" placeholder="send us a message"></textarea> <br><br>
			<input type="submit"><br>
			<p style=color:red;"> <?php echo $error_send_message ?> </p>
			<p style=color:green;"> <?php echo $result_send_message ?> </p>
		</form>
	</body>
</html>