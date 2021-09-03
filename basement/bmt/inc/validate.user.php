<?php
if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
	$_SESSION[$session_code]['Username'] = NULL;
	$_SESSION[$session_code]['Level'] = NULL;
	$_SESSION[$session_code]['id'] = NULL;
	$_SESSION['PrevUrl'] = NULL;
	unset($_SESSION[$session_code]['Username']);
	unset($_SESSION[$session_code]['Level']);
	unset($_SESSION[$session_code]['id']);

	setcookie($session_code . "_Username", '', -250000, '/', '.' . $_SERVER['HTTP_HOST']);
	setcookie($session_code . "_id", '', -2500000, '/', '.' . $_SERVER['HTTP_HOST']);
	setcookie($session_code . "_Level", '', -250000, '/', '.' . $_SERVER['HTTP_HOST']);
	header('location:/bmt/login');
}

if (isset($_SESSION[$session_code]['Username'])) {
	$user = returnDBObject("SELECT * FROM admins WHERE id=? AND password=?", array($_SESSION[$session_code]['id'], $_SESSION[$session_code]['pwd']));
}
if (isset($_COOKIE[$session_code . '_Username'])) {
	$user = returnDBObject("SELECT * FROM admins WHERE id=? AND password=?", array($_COOKIE[$session_code . '_id'], $_COOKIE[$session_code . '_pwd']));
}
if (!isset($user) && $route != 'login') {
	header('location: /bmt/login');
}
