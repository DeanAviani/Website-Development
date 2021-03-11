<?php

	$errors="";
	$query="";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		include 'connection.php'; // DB connection details
		
		//get details from the form
		$username=$_POST["username"];
		$email=$_POST["email"];
		$password=$_POST["password"];
		
		if(empty($username) or empty($email) or empty($password) or !filter_var($email, FILTER_VALIDATE_EMAIL)){ //check if any input in the register form is empty
				$errors = "Invaild inputs!";
			}
		else
		{
			$query1 = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username';");

			if(mysqli_num_rows($query1)==1) // check if the username already exists
				$errors = "Username already exists!";

			else{
				//create new user in 'users' DB
				$query = mysqli_query($conn, "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password');");
				echo "<script type='text/javascript'>alert('User Created!');</script>";
				header( "refresh:0.1; url=?page=home.php" );
				}
		}	
	}
?>

<!DOCTYPE html>
<html>
	<body>
	<h2> Register page </h2>
		<form action="?page=register.php" method="POST">
			<input type="text" name="username" placeholder="Username"><br>
			<input type="text" name="email" placeholder="E-mail"><br>
			<input type="password" name="password" placeholder="Password"><br><br>
			<input type="submit">
			<br>
			<p style=color:red;"> <?php echo $errors ?> </p>
		</form>
		
	</body>
</html>