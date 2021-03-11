<?php
		
	if(is_null($_SESSION["username"])){
		header("Location: ?page=login.php");
	}
?>
			
		<?php 

			include 'connection.php'; //DB connection details
		
			$errors="";
			$post_id = $_GET["id"];
			$_SESSION["post_id"] = $post_id;
			
			$query = mysqli_query($conn, "SELECT * FROM posting WHERE id='$post_id';"); // get specific post by post ID
			$data = mysqli_fetch_assoc($query);
			$count = mysqli_num_rows($query); 
			
			if($count == 0){ // if post ID is not exists, we will redirect to forum page
				header("Location: ?page=forum.php");
			}
			else{
					//get user details
					$username = $_SESSION["username"];
					$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username';");
					$data = mysqli_fetch_assoc($query);
					
					if($data["isadmin"]==true){
						//check if logged in user have admin privilage
						echo "<a href='?page=edit_post.php&id=".$post_id."'><img id='img_right' src='img/edit_post.png' height='30' width='30' title='Edit post'></a>";
						echo "<a href='?page=delete_post.php&id=".$post_id."'><img id='img_right' src='img/delete_post.png' height='30' width='30' title='Delete post'></a>";
					}
					//get post details
					$query = mysqli_query($conn, "SELECT * FROM posting WHERE id='$post_id';");
					$data = mysqli_fetch_assoc($query);
					$poster_image = $data['image'];
					$poster_file = $data['filename'];

					echo "<h2>Topic: ".$data["post_title"]."</h2>";
					echo "<b>".$data["poster"]." said: </b>";


					if(!empty($poster_image)){
						//show an image
							echo "&emsp;".$data["post_desc"]."<br>";
							echo '<img src="data:image/jpeg;base64,'.base64_encode( $poster_image ).'" height="20%" width="20%"/><br><hr><br>';
					}
					
					else if(!empty($poster_file)){
						//get file folder
						$files = scandir("uploads"); // get List of files inside the specified path
						
						for($a = 2; $a < count($files); $a++){
							//show file from the List of files varible
							if($files["$a"] == $poster_file){
								echo "&emsp;".$data["post_desc"]."<br>";
								echo "<a href='uploads/$files[$a]' target='_blank'><img src='img/file.png' height='40' width='40' title='click to see the file'></a><br><hr><br>";
							}
						}
					}
				
					else// show response message
						echo "&emsp;".$data["post_desc"]."<br><hr><br>";
					
					echo "<iframe src='create_show_responses.php' width='100%' height='700'></iframe>"; // show responses page 
			}
		?>
		
<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<style>
				#img_right{
					float:right;
					display:inline-block;
					padding-left: 18px;
					}	
		</style>
	</head>

	<body>
	</body>
</html>