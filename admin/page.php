<?php 
	
	$do = '';

	if (isset($_GET['do'])) {
		$do = $_GET['do'];
	} else {
		$do = 'manage';
	}

	//if the page is the main page 

	if ($do == 'manage') {
		echo "Welcom In Category page ";
		echo '<a href="page.php?do=add">Add New Category +</a>';

	} elseif ($do == 'add') {
		echo 'You are In Add page';

	} elseif ($do == 'insert') {
		echo 'You are In Insert page';	

	} else {
		echo "Error: This Page Is Not Found";
	}