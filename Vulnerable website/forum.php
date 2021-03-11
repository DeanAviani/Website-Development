<?php
	if(is_null($_SESSION["username"])){
		header("Location: ?page=login.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
<style>
	#img_center {
			  display: block;
			  margin-right: auto;
			}
</style>
</head>

<body>

<img id='img_center' src='img/create_post.png' height='30%' width='15%'><br>
<button onclick="location.href='?page=create_post.php'" type="button">
         Create a post</button><hr>
	
	<?php 
	
		include 'connection.php';
		//get all posts details
		$query = mysqli_query($conn, "SELECT id, post_title, poster FROM posting;");
		
		echo "<h2> Topics </h2>";
		while($data = mysqli_fetch_assoc($query)) {
			//shows all posts by link
			echo "<a href='?page=show_post.php&id=".$data["id"]."'>".$data["post_title"]."</a> <sub> by <b>".$data["poster"]."</b></sub><br><br>";
		}
	?>
</body>
</html>