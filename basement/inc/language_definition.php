<?php
	$languages_array=returnDBObject("SELECT * FROM languages",array(),1);
	$selected_languages=array();
	
	foreach($languages_array as $language){
		array_push($selected_languages, $language['uni_code']); 
	}
	
	$languages=get_languages('data');
	if(!isset($_GET['ln'])){
		if( !in_array($languages[0][1], $selected_languages)){
			$language='en';
		}else{
			$language=$languages[0][1];
		}
	}else{
		$language=$_GET['ln'];	
	}
?>