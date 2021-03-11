<?php

	session_start();
		
	if(is_null($_SESSION["username"])){
		header("Location: ?page=login.php");
	}
?>

<?php
		include 'connection.php'; // get DB connection details
		
		$errors="";
		$poster_id = $_SESSION["post_id"];
			
		if($_SERVER["REQUEST_METHOD"] == "POST") { //check if the user submited a form
				$responser = $_SESSION["username"];
				$response_desc = $_POST["desc"];
							
				if(empty($response_desc)) {
					$errors = "Invalid inputs!";
				}
							
				else{
						$file=$_FILES['file']; //A global array of items which are being uploaded
				
						$fileName = $_FILES['file']['name']; // file full name: name + type (with separating dot)
						$fileTmpName = $_FILES['file']['tmp_name']; // file source location name
						$fileError = $_FILES['file']['error']; // file error

						$fileExt = explode('.', $fileName); // ARRAY of file full name: name + type (without separating dot)
						$fileActualExt = strtolower(end($fileExt)); // get the last element in the ARRAY (file's Type)
					
						$allowed = array('jpg', 'jpeg', 'png'); // which types of files allowed 
						
						$query1 = mysqli_query($conn, "SELECT * FROM responsing WHERE id=(SELECT max(id) FROM responsing WHERE poster_id='$poster_id');");
				
						if(mysqli_num_rows($query1)==0) //check if there is pervious post in the DB. if this is not the case, the ID of the new post will be 1
							$id=1;
				
						else{
							$data = mysqli_fetch_assoc($query1);// if there is a previous post, The new post will get an ID with a number greater than 1 of the ID of the previous post
							$id=$data["id"]+1;
						}
					
						if($fileError == 0){ //file object exist
						
							if(in_array($fileActualExt, $allowed)){
							//upload an image to DB
								
							$image= addslashes(file_get_contents($_FILES["file"]["tmp_name"]));
							$query1 = mysqli_query($conn, "INSERT INTO responsing(id, responser, response_desc, poster_id, image) VALUES ('$id', '$responser', '$response_desc', '$poster_id', '$image');");
							}
							
							else{
								//upload a file to root folder
								$fileDestination = 'uploads/'.$fileName;
								move_uploaded_file($fileTmpName, $fileDestination);
								//upload post details to DB 'posting' with a file
								$query1 = mysqli_query($conn, "INSERT INTO responsing(id, responser, response_desc, poster_id, filename) VALUES ('$id', '$responser', '$response_desc', '$poster_id', '$fileName');");
							}
						}
							
						else 	//upload post details to DB 'posting' without a file
							$query1 = mysqli_query($conn, "INSERT INTO responsing(id, responser, response_desc, poster_id) VALUES ('$id', '$responser', '$response_desc', '$poster_id');");
					}
			}
			
			$response_query = mysqli_query($conn, "SELECT * FROM responsing;");
			
			while($responser_data = mysqli_fetch_assoc($response_query)) {
				
				if($responser_data["poster_id"] == $poster_id){
					// get details of response message
					$responser_image = $responser_data['image'];
					$responser_file = $responser_data['filename'];
					$id = $responser_data['id'];

				$username = $_SESSION["username"];
				//Get details about the logged in user
				$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username';");
				$data = mysqli_fetch_assoc($query);
				
				if($data["isadmin"]==true){
					//check if the logged in user have admin privilages
					echo "<a href='edit_response.php?poster_id=".$poster_id."&id=".$id."'><img id='img_right' src='img/edit_response.png' height='30' width='30' title='Edit response'></a>";
					echo "<a href='delete_response.php?poster_id=".$poster_id."&id=".$id."'><img id='img_right' src='img/delete_response.png' height='30' width='30' title='Delete response'></a>";
				}

					echo "<b>".$responser_data["responser"]." said: </b>";
					
				if(!empty($responser_image)){
					//check if the resposnse icludes an image
					echo "&emsp;".$responser_data["response_desc"]."<br><br>";		
					echo '<img src="data:image/jpeg;base64,'.base64_encode( $responser_image ).'" height="20%" width="18%"/><br><hr>';
					echo '<object data="data:application/pdf;base64,<?php echo base64_encode(content) ?>" type="application/pdf" style="height:200px;width:60%"></object>';
				}
				
				else if(!empty($responser_file)){
					//check if the resposnse icludes a file
					$files = scandir("uploads"); // get List of files inside the specified path
						
						for($a = 2; $a < count($files); $a++){
							//show file from the List of files varible
							if($files["$a"] == $responser_file){
								echo "&emsp;".$responser_data["response_desc"]."<br>";
								echo "<a href='uploads/$files[$a]' target='_blank'><img src='img/file.png' height='40' width='40' title='click to see the file'></a><br><hr><br>";
							}
						}
				}
		
				else // show response message
					echo "&emsp;".$responser_data["response_desc"]."<br><hr><br>";						
				}
			}
?>

<!DOCTYPE html>
<html>
<head>
	<style>
		*{font-family: Arial;}
		
		#img_right{
			float:right;
			display:inline-block;
			padding-left: 18px;
		}	
	</style>
</head>

<body>
	<h3>Add a response </h3>
			<form action="?page=create_show_responses.php" method="POST" enctype="multipart/form-data">
				<br> <input type="file" name="file"><br><br>
				<textarea rows="10" name ="desc" cols="50" placeholder="Response description"></textarea> <br><br>
				<input type="submit"><br>
				<p style=color:red;"> <?php echo $errors ?> </p>
			</form>
</body>
</html>