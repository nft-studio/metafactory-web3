<?php
$str=$_POST['toClean'];
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

	
	$htaccess= file_get_contents('../../../.htaccess');
	
if((!preg_match("/\b".$clean."\b/i",$htaccess))||(!preg_match("/\b".$_POST['language']."\/".$clean."\b/i",$htaccess)))  {
	echo $clean;
}else{
	echo 'false';
}
?>