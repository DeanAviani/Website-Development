<?php
	if(is_null($_SESSION["username"])){//check if the user exist
		header("Location: ?page=login.php");
	}
	
	$errors="";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		include 'connection.php';  // get DB connection details
	
		//get post details
		$poster = $_SESSION["username"];
		$title = $_POST["title"];
		$post_desc = $_POST["desc"];
		
		if(empty($title) or empty($post_desc)) { //check if the user filled the inputs in a post
			$errors = "Invalid inputs!";
		}
		
		else{
				//get the last post ID
				$query1 = mysqli_query($conn, "SELECT * FROM posting WHERE id=(SELECT max(id) FROM posting);");
				
				if(mysqli_num_rows($query1)==0) //check if there is pervious post in the DB. if this is not the case, the ID of the new post will be 1
						$post_id=1;
				
				else{
						$data = mysqli_fetch_assoc($query1); // if there is a previous post, The new post will get an ID with a number greater than 1 of the ID of the previous post
						$post_id=$data["id"]+1;
				}
				
				$file=$_FILES['file']; //A global array of items which are being uploaded
				
				$fileName = $_FILES['file']['name']; // file full name: name + type (with separating dot)
				$fileTmpName = $_FILES['file']['tmp_name']; // file source location name
				$fileError = $_FILES['file']['error']; // file error

				$fileExt = explode('.', $fileName); // ARRAY of file full name: name + type (without separating dot)
				$fileActualExt = strtolower(end($fileExt)); // get the last element in the ARRAY (file's Type)
				
				$allowed = array('jpg', 'jpeg', 'png'); //Limit File Type
				
				if($fileError == 0){ //file object exist
					
					if(in_array($fileActualExt, $allowed)){
						//upload an image to DB
						$image= addslashes(file_get_contents($fileTmpName));
						//upload post details to DB 'posting'
						$query = mysqli_query($conn, "INSERT INTO posting(id, poster, post_title, post_desc, image) VALUES ('$post_id', '$poster', '$title', '$post_desc', '$image');");
					}
				
					else{
						//upload a file to root folder
						$fileDestination = 'uploads/'.$fileName;
						move_uploaded_file($fileTmpName, $fileDestination);
						//upload post details to DB 'posting' with a file
						$query = mysqli_query($conn, "INSERT INTO posting(id, poster, post_title, post_desc, filename) VALUES ('$post_id', '$poster', '$title', '$post_desc', '$fileName');");

					}
				}
				
				else 	//upload post details to DB 'posting' witout a file
					$query = mysqli_query($conn, "INSERT INTO posting(id, poster, post_title, post_desc) VALUES ('$post_id', '$poster', '$title', '$post_desc');");

				
				if($query) { //check if the query succed
					header("Location: ?page=forum.php");
				}
				
				else
					$errors = "it didnt work!";
			}
	}
?>

<!DOCTYPE html>
<html>
	<head>
	</head>

	<body>
		<h2>Create a new post </h2>
		<form action="?page=create_post.php" method="POST" enctype="multipart/form-data">
			<input type="text" name="title" placeholder="Title"><br><br>
			<input type="file" name="file"><br><br>
			<textarea rows="25" name ="desc" cols="50" placeholder="Post description"></textarea> <br><br>
			<input type="submit"><br>
			<p style=color:red;"> <?php echo $errors ?> </p>
		</form>

	</body>
</html>