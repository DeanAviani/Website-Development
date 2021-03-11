<?php
	
if(is_null($_SESSION["username"])){
	header("Location: ?page=login.php");
}
$directory = "";
echo "<h2>Recipes</h2>";


function show_directory($directory)
{
    // Checks whether a file or directory exists    
    if(file_exists($directory))
    {   
        $dp = opendir($directory); //get the directory path 
       
        while($line = readdir($dp)) // get the filenames in the folder
        {   
            if($line != "." && $line != ".." && $line != ".htaccess")
				//show links of the files that exist in specific directory path 
                echo "<a href=\"" . $directory . "/" . $line . "\" target=\"_blank\">" . $line . "</a><br><br>";   
        }
    }
    
    else
        echo "This directory doesn't exist!";
}

$directory = $_GET["directory"];
show_directory($directory);

?>

<!DOCTYPE html>
<html>
	<head>
	</head>

	<body>
				
	</body>
</html>