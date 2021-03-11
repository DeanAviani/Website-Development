<?php	
		include 'connection.php';
	
		$username=$_GET["username"];
		$isadmin=$_GET["isadmin"];

		$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username';");
		$data = mysqli_fetch_assoc($query);
		
		// changes the premission of user
		if($isadmin == true)
			$query = mysqli_query($conn, "UPDATE users SET isadmin=false WHERE username='$username';");
		else
			$query = mysqli_query($conn, "UPDATE users SET isadmin=true WHERE username='$username';");
		
		header("Location: ?page=admin.php");
?>
