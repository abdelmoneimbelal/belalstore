<?php

	// error reporting

	ini_set('display_errors', 'on');
	error_reporting(E_ALL);
	
	include 'admin/connect.php';

	$sessionuser = '';
	if (isset($_SESSION['user'])) {
		$sessionuser = $_SESSION['user'];
	}

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