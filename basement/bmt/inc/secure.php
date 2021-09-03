<?php
header("strict-transport-security: max-age=10");
require_once 'purify/HTMLPurifier.auto.php';

$actual_link = "http://$_SERVER[HTTP_HOST]";
$full_link = $_SERVER['REQUEST_URI'];
preg_match('#%3Cscript(.*?)%3E(.*?)%3C/script%3E#is', $full_link, $matches, PREG_OFFSET_CAPTURE);

if (count($matches) > 0) {
    die();
    header('location: /');
}
if (strpos($full_link, 'script') !== false) {
    die();
    header('location: /');
}

$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
