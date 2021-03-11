<?php	
		include 'connection.php';  // get DB connection details
		
		//get response detials
		$poster_id=$_GET["poster_id"];
		$response_id=$_GET["id"];
		
		//delete post
		$query = mysqli_query($conn, "DELETE FROM responsing WHERE id='$response_id' AND poster_id='$poster_id';");
		
		//get all IDs of responses
		$query = mysqli_query($conn, "SELECT * FROM responsing WHERE poster_id='$poster_id';");
		
		while($data = mysqli_fetch_assoc($query)) {
			//Update the ID of comments following the deletion of a comment in specific post
			if($data["id"] > $response_id){
				$query1 = mysqli_query($conn, "UPDATE responsing SET id=".$data["id"]."-1 WHERE id=".$data["id"]." AND poster_id='$poster_id';");
			}
		}
		
		header("Location: create_show_responses.php");
?>

