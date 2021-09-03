<?php	
	require_once('bmt/inc/dotenv.php');	
	if(debug_mode=='on'){
		error_reporting(E_ALL); ini_set('display_errors', 'On'); 
	}else{
		error_reporting(E_ALL); ini_set('display_errors', 'Off'); 
	}
	include('bmt/inc/core.php');
	$mode = returnConnectivityStat();
    include('bmt/inc/configurations.php');
	include('inc/mobiledetect.php');
	include_once('bmt/scripts/locales/language_detection.php'); 
	include('inc/language_definition.php');
	include('inc/locales.php');
	include('inc/routing.php');
?>