<?php
	if (!isset($_SESSION)) {
	  session_start();
	}
	include('secure.php');
    require_once('dotenv.php');	
	if(debug_mode=='on'){error_reporting(E_ALL); ini_set('display_errors', 'On'); }
	include('core.php');
	$mode=returnConnectivityStat();
	
	$permissionsErrors='';
	
	if(is_dir('classes/')){
		foreach(scandir('classes/') as $file) {
			if($file!='.' && $file!='..' && $file!='.DS_Store'){
				if(strpos('class.', $file)!==-1){
					include('classes/'.$file);
				}
			}
		}
	}
	
	if(isset($_SESSION['success_message'])){
		$success_notice=$_SESSION['success_message'];
		unset($_SESSION['success_message']);
	}
	if(isset($_SESSION['error_message'])){
		$error_notice=$_SESSION['error_message'];
		unset($_SESSION['error_message']);
	}
	
	$labels = [ 
		"creato" => "created",
		"eliminato" => "deleted",
		"modificato" => "changed"
	];
	
	include('configurations.php');
	include('setpermissions.php');
	include('navigation.php');	
	include('validate.user.php');
	include('scripts/locales/en.php'); 
	include('write_htaccess.php');   
	include('write_sitemap.php');  
	include('write_rss.php'); 
	include('permission.routing.php');
	setlocale(LC_MONETARY, 'en_EN');	
	
?>