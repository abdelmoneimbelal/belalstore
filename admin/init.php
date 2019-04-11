<?php
	
	include 'connect.php';

	//Routes

	$tem1 = 'inc/tem/'; //temp dir
	$css = 'des/css/'; //css dir 
	$js = 'des/js/'; //js dir
	$lang ='inc/lang/'; //language dir
	$fun = 'inc/fun/'; //functions dir

	//include important file
	include $fun . 'fun.php';
	include $lang . 'en.php';
	include $tem1 . 'header.php';

	//include navbar all pages expect the one with $onnavbar vairable

	if (!isset($nonavbar)) {include $tem1 . 'navbar.php';}

	
	