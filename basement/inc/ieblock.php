<?php
	$toBlock=returnDBObject("SELECT * FROM configs WHERE code=?",array('ieblock'));
	if($toBlock['value']==1){
		if($route!='ieblock'){
			if(detect_ie()=='1'){
				header('Location: /ieblock');
			}
		}
	}
?>