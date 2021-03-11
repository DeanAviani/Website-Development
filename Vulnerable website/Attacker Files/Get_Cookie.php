<script> 
window.onload = function() {
// Creating a cookie after the document is ready 
    var cookies = document.cookie.split(";")
    var cookiePair = cookies[0].split("=");
    var cookie_user=cookiePair[1]; // remove ending parenthesis here 

	window.location.replace("http://192.168.206.1/test/ChangeInfo.php?username="+cookie_user); //this page navigates to ChangeInfo page with the username value
};
</script> 

<?php

?>

<!DOCTYPE html>
<html>

<head>
</head>

<body>
</body>
	<?php
		if($_SERVER["REQUEST_METHOD"] == "POST") 
			include 'footer.php';
	?>
</html>
