<?php

	if(is_null($_SESSION["username"])){ //check if the user exist
		header("Location: ?page=login.php");
	}
	
	$errors="";
	include 'connection.php';  // get DB connection details
			
	if($_SERVER["REQUEST_METHOD"] == "POST") {
				
				//get post details
				$post_id = $_SESSION["post_id"];
				$new_title=$_POST["title"];
				$new_desc = $_POST["desc"];
				
				$file=$_FILES['file']; //A global array of items which are being uploaded
				
				$fileName = $_FILES['file']['name']; // file full name: name + type (with separating dot)
				$fileTmpName = $_FILES['file']['tmp_name']; // file source location name
				$fileError = $_FILES['file']['error']; // file error

				$fileExt = explode('.', $fileName); // ARRAY of file full name: name + type (without separating dot)
				$fileActualExt = strtolower(end($fileExt)); // get the last element in the ARRAY (file's Type)
							
				$allowed = array('jpg', 'jpeg', 'png'); // allowed file types
				
				if($fileError == 0){ //file object exist
				
					if(in_array($fileActualExt, $allowed)){
						//upload an image to DB
						$image= addslashes(file_get_contents($fileTmpName));
						//update post details with image
						$query = mysqli_query($conn, "UPDATE posting SET post_title='$new_title' , post_desc='$new_desc' , image='$image' , filename=null WHERE id='$post_id';");
					}
					else{
							//upload a file to root folder
							$fileDestination = 'uploads/'.$fileName;
							move_uploaded_file($fileTmpName, $fileDestination);
							
							//update post details with file
							$query = mysqli_query($conn, "UPDATE posting SET post_title='$new_title' , post_desc='$new_desc' , filename='$fileName', image=null WHERE id='$post_id';");

						}
				}
					
				else{
						//update post details witout file and image
						$query = mysqli_query($conn, "UPDATE posting SET post_title='$new_title' , post_desc = '$new_desc' , image=null , filename=null WHERE id='$post_id';");
				}

				if($query)
					header("Location: ?page=forum.php");
				else
					$errors = "it didnt work!";
			}
			
		else {
					//get old post details
					$_SESSION["post_id"] = $_GET["id"];
					$post_id = $_SESSION["post_id"];
					$query = mysqli_query($conn, "SELECT * FROM posting WHERE id='$post_id';");
					$data = mysqli_fetch_assoc($query);
				
					$old_title = $data["post_title"];
					$old_desc = $data["post_desc"];
					$post_image = $data['image'];
					$post_file = $data['filename'];
					
					if(!empty($post_image)) //check if there is an image. if this is the case, the image will be save encoded in file paramater
							$file= '<img src="data:image/jpeg;base64,'.base64_encode( $post_image ).'" height="20%" width="15%"/>';	
						
					else if(!empty($post_file)) //check if there is a file
							$file = $post_file;
					else
						$file=null;
			}
?>

<!DOCTYPE html>
<html>
	<head>
		    <style>
				*{
					font-family: Arial;
				}
			</style>
	</head>

	<body>
		<h2>Edit a post </h2>
		<form action="?page=edit_post.php" method="POST" enctype="multipart/form-data">
			<b>Title: </b><input type="text" name="title" value="<?php echo $old_title ?>"><br><br>
			<b>File: </b><?php echo $file ?><input type="file" name="file"><br><br>
			<b>Description:</b><br>
			<textarea rows="25" name ="desc" cols="50"><?php echo $old_desc ?></textarea> <br><br>
			<input type="submit"><br>
			<p style=color:red;"> <?php echo $errors ?> </p>
		</form>

	</body>
</html>