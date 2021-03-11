<?php
session_start();
session_destroy(); //kill the user's session
setcookie("UserCookie", "", time() - 3600); //kill the user's cookie
header("Location: ?page=home.php");
?>