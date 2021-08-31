<?php
	ini_set('display_errors', 'On');
    error_reporting(E_ALL);
	include 'connect.php';
	// Routes
	$tpl 	= 'includes/templates/'; // Template Directory
	//$lang 	= 'includes/languages/'; // Language Directory
	$func	= 'includes/functions/'; // Functions Directory
	$css 	= 'layout/css/'; // Css Directory
	$js 	= 'layout/js/'; // Js Directory
	$mdi    ='layout/mdi/'; //mdi durectory
	$fonts  ='layout/fonts/Ubuntu/';
	$scss   ='layout/scss/';
	$img    ='layout/images/';
	$psd    ='layout/PSD/';
	// Include The Important Files
	include $func . 'function.php';
	//include $lang . 'english.php';
	include $tpl . 'header.php';
	// Include Navbar On All Pages Expect The One With $noNavbar Vairable
	// if (!isset($noNavbar)) { include $tpl . 'navbar.php'; }