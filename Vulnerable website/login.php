<?php

	$errors="";
	$alert="";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		include 'connection.php';
		//get user details
		$username=$_POST["username"];
		$password=$_POST["password"];
		
		if(empty($username) or empty($password)){
				$errors = "Invaild inputs!";
			}
		else
		{	
			$query = mysqli_query($conn, "SELECT username FROM users WHERE username='$username';");
			$count = mysqli_num_rows($query);

			if($count > 0){ // check if username exists
				
				$query = mysqli_query($conn, "SELECT username, password FROM users WHERE username='$username' AND password ='$password';");
				$count = mysqli_num_rows($query);
   
				if($count > 0){
				//check if the user details (username and password) exists in the DB. if it is, the count value will be more than 0.
						$alert="Login succeeded";
						session_start();
						$_SESSION["username"] = $username;
						setcookie("UserCookie", $username);
						
						header("Location: ?page=home.php");
				}
				
				else
					$errors = "Login failed! wrong password";
			}
			
			else
				$errors = "Login failed! wrong username";

		}
	}
		
?>

<!DOCTYPE html>
<html>
	<body>
	<h2> Login page </h2>

		<form action="?page=login.php" method="POST">
			<input type="text" name="username" placeholder="Username"><font color="#fff">crow</font><br>
			<input type="password" name="password" placeholder="Password"><font color="#fff">123</font><br><br>
			<input type="submit"><br>
			<p style=color:red;> <?php echo $errors ?> </p>
			<p style=color:green;> <?php echo $alert ?> </p>

		</form>

	</body>
</html>