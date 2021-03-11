<?php
include 'header.php'; // get content from header page
	
	if(empty($_GET['page']))
	    $page='home.php'; // if there is no a page name, the defualt will be the home page.
	else
		$page = $_GET['page']; // this parameter gets the page name from the URL. 
	    
	require($page); // this line is responsible to show a page

include 'footer.php'; // get content from header page
?>