<?php
if (!isset($_SESSION)) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 1);
    session_start();
    session_regenerate_id();
}
include('bmt/inc/secure.php');

$purified = $purifier->purify($_SERVER['REQUEST_URI']);
if ($purified != $_SERVER['REQUEST_URI']) {
    die();
    header('location: /');
}
include('inc/initialize.php');
if (api_active == 'on') {
    // Handle inputs
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $json = file_get_contents('php://input');
        $data = json_decode($json);
    }

    // Try to render endpoint
    $rendered = false;
    if (isset($_GET['request'])) {
        $endpoint = 'endpoints/' . $_GET['request'] . '.php';
        if (is_file($endpoint)) {
            $rendered = true;
            include($endpoint);
        }
    }

    // Print error message if nothing was rendered
    if (!$rendered) {
        echo '<pre>Can\'t process request.</pre>';
    }
}
