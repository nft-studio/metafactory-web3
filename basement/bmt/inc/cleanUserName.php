<?php
$str=$_POST['toClean'];
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
	$clean = strtolower(trim($clean, ''));
	$clean = preg_replace("/[\/_|+ -]+/", '', $clean);

	
echo $clean;
