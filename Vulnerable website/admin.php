<?php

	if(is_null($_SESSION["username"])){ //check if the user exist
		header("Location: ?page=login.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>

	<head>
	<body>
		<table BORDER=5 BORDERCOLOR=black>
			<tr>
				<th> Username </th>
				<th> Permission </th>
				<th> Change Permission </th>
			</tr>
			<?php 
				include 'connection.php';
				
				$username=$_SESSION["username"];
				$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username';");
				$data = mysqli_fetch_assoc($query);
				
				if($data["isadmin"] == false) //check if the user that are trying to access this page, have admin priviege. if he doesn't, he will forward back to the home page
					header("Location: ?page=home.php");
				
				else{
						// get the all users details from the DB of the site 
						$query = mysqli_query($conn, "SELECT * FROM users;");
							
							while($data = mysqli_fetch_assoc($query)) {
								echo "<tr><td>".$data["username"]."</td>";
										
								if($data["isadmin"] == true)
									echo "<td>Admin</td>";
								else
									echo "<td>Regular user</td>";
								
								echo "<td><a href='?page=change_permission.php&username=".$data["username"]."&isadmin=".$data["isadmin"]."'><img src='img/permission.png' height='30' width='30'></a></td>";
								
								echo "</tr>";
							}
							echo "</table>";
				}
			?>
		</table>
	</body>
</html>