<?php
$longUrl=explode('/',str_replace($subdomain,'',$_SERVER['PHP_SELF']));
$route=str_replace('.php','',$longUrl[2]);

$tables = returnDBObject('SHOW TABLES',array(),1);
$dataTypes=array();

foreach($tables as $table){
	$name_parts=explode('_',$table[0]);
	if( ($name_parts[0]=='datatype') ){
		array_push($dataTypes, $name_parts[1]);
	}
}
?>