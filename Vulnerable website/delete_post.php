<?php	
		include 'connection.php'; //get DB connection details
		
		//get post details
		$poster_id=$_GET["id"];
		$query = mysqli_query($conn, "DELETE FROM posting WHERE id='$poster_id';");
		
		//delete specific
		$query = mysqli_query($conn, "DELETE FROM responsing WHERE poster_id='$poster_id';");

		
		// get an ID of all posts
		$query = mysqli_query($conn, "SELECT id FROM posting;");
		
		while($data = mysqli_fetch_assoc($query)) {
			if($data["id"] > $poster_id){
				//Update the other IDs of a posts following a specific post deletion
				$query1 = mysqli_query($conn, "UPDATE posting SET id=".$data["id"]."-1 WHERE id=".$data["id"].";");
				//Linking the responses to a post ID number to which they belong
				$query2 = mysqli_query($conn, "UPDATE responsing SET poster_id=".$data["id"]."-1 WHERE poster_id=".$data["id"].";");

			}
		}
		
		header("Location: ?page=forum.php");
?>

