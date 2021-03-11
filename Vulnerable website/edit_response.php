<?php
	session_start();
	
	if(is_null($_SESSION["username"])){ //check if user exist
		header("Location: ?page=login.php");
	}
	
	$errors="";
	include 'connection.php'; // get DB connection details
				
		if($_SERVER["REQUEST_METHOD"] == "POST") {
				
			$response_id = $_SESSION["response_id"];
			$post_id = $_SESSION["post_id"];
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
					//update response details with image
					$query = mysqli_query($conn, "UPDATE responsing SET response_desc='$new_desc' , image='$image' , filename=null WHERE id='$response_id' AND poster_id='$post_id';");
				}
				
				else{
						//upload a file to root folder
						$fileDestination = 'uploads/'.$fileName;
						move_uploaded_file($fileTmpName, $fileDestination);
						//update response details with file
						$query = mysqli_query($conn, "UPDATE responsing SET response_desc='$new_desc' , image=null , filename='$fileName' WHERE id='$response_id' AND poster_id='$post_id';");
					}
			}
				
			else{
				//update response details without file and image
				$query = mysqli_query($conn, "UPDATE responsing SET response_desc='$new_desc' , image=null, filename=null WHERE id='$response_id' AND poster_id='$post_id';");
			}

				if($query){
							header("Location: create_show_responses.php");
				}
				else
					$errors = "it didnt work!";
			}
			
			else {
					//get old response details
					$_SESSION["response_id"] = $_GET["id"];
					$_SESSION["post_id"] = $_GET["poster_id"];
					
					$response_id = $_SESSION["response_id"];
					$post_id = $_SESSION["post_id"];
					
					$query = mysqli_query($conn, "SELECT * FROM responsing WHERE id='$response_id' AND poster_id = '$post_id';");
					$data = mysqli_fetch_assoc($query);
				
					$old_desc = $data["response_desc"];
					$responser_image = $data['image'];
					$responser_file = $data['filename'];

					
					if(!empty($responser_image))	//update post details witout file and image
						$file= '<img src="data:image/jpeg;base64,'.base64_encode( $responser_image ).'" height="20%" width="15%"/>';
				
					else if(!empty($responser_file))//check if there is a file
						$file = $responser_file;
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
		<form action="?page=edit_response.php" method="POST" enctype="multipart/form-data">
			<b>File: </b><?php echo $file ?><input type="file" name="file"><br><br>
			<b>Description:</b><br>
			<textarea rows="10" name ="desc" cols="50"><?php echo $old_desc ?></textarea> <br><br>
			<input type="submit"><br>
			<p style=color:red;"> <?php echo $errors ?> </p>
		</form>
	</body>
</html>