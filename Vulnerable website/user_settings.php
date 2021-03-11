<?php

	if(is_null($_SESSION["username"])){ //check if the user exist
		header("Location: ?page=login.php");
	}
	
	else{
			//get user details
			$username=$_COOKIE["UserCookie"];
			$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username';");
			$data = mysqli_fetch_assoc($query);
			
			$old_password = $data["password"];
			$old_email = $data["email"];
	}
	
	$errors="";
	$result="";

	if($_SERVER["REQUEST_METHOD"] == "POST") { //check if the user submited the form
		
		
		$username=$_POST["username"];

		//get new user details
		$new_password=$_POST["password"];
		$new_email=$_POST["email"];

		//change password or email of user
		
		if(empty($new_password) AND !empty($new_email)){
			$query = mysqli_query($conn, "UPDATE users SET email='$new_email' WHERE username='$username';");
			$result = "Email Changed Successfuly";
			header( "refresh:1; url=?page=user_settings.php" );
		}
		
		else if(!empty($new_password) AND empty($new_email))
		{
			$query = mysqli_query($conn, "UPDATE users SET password='$new_password' WHERE username='$username';");
			$result = "Password Changed Successfuly";
			header( "refresh:1; url=?page=user_settings.php" );
		}
		else if(!empty($new_password) AND !empty($new_email))
		{
			$query = mysqli_query($conn, "UPDATE users SET password='$new_password' , email='$new_email' WHERE username='$username';");
			$result = "Password or Email Changed Successfuly";
			header( "refresh:1; url=?page=user_settings.php" );
		}
		
		else
		{
			$errors="Password or Email fields can NOT be empty!";
		}
	}
		
?>

<!DOCTYPE html>
<html>
	<body>
	<h2> User Settings </h2>

		<form action="?page=user_settings.php" method="POST">
			<b>Username</b> <p><input type="text" value="<?php echo $_COOKIE["UserCookie"] ?>" disabled="disabled"></p>
			<input type="hidden" name="username" value="<?php echo $_COOKIE["UserCookie"] ?>">
			<b>Password</b> <p><input type="text" name="password" value="<?php echo $old_password ?>"></p>
			<b>Email</b> <p><input type="text" name="email" value="<?php echo $old_email ?>"><p>

			<input type="submit" value="Update Details"><br>
			<p style=color:red;"> <?php echo $errors ?> </p>
			<p style=color:green;"> <?php echo $result ?> </p>

		</form>

	</body>
</html>