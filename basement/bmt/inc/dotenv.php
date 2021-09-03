<?php
$dir = dirname(__FILE__);
$env = explode("\n", file_get_contents(str_replace("/bmt/inc","",$dir)."/.env"));
foreach ($env as $config) {
    $cc = explode("=", $config);
    if(isset($cc[1])){
    define(strtolower($cc[0]), $cc[1]);
    }
}
$session_code = session_code;
