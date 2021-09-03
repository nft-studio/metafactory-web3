<?php 
	if(!isset($_SESSION)){
		ini_set('session.cookie_httponly', 1);
		ini_set('session.use_only_cookies', 1);
		ini_set('session.cookie_secure', 1);
		session_start();
		session_regenerate_id();
	}
	include('bmt/inc/secure.php'); 
	
	$purified=$purifier->purify($_SERVER['REQUEST_URI']); 
	if($purified!=$_SERVER['REQUEST_URI']){
		die();
		header('location: /');
	}
	include('inc/initialize.php');

	$page = returnDBObject("SELECT * FROM pages WHERE permalink=? AND language=?",array($route,$language)); 

	if(isset($_SESSION['success_message']) && $_SESSION['success_message']!=''){
		$successToShow=$_SESSION['success_message'];
		$_SESSION['success_message']='';
	}
	
	if(isset($_SESSION['error_message']) && $_SESSION['error_message']!=''){
		$errorToShow=$_SESSION['error_message'];
		$_SESSION['error_message']='';
	}
	
	if(isset($page['id'])){
		include('pages/'.$page['ref_page']);
	}else{
		$page = returnDBObject("SELECT * FROM pages WHERE permalink=? AND language=?",array($route,$selected_languages[0])); 
		include('pages/'.$page['ref_page']);
	}
