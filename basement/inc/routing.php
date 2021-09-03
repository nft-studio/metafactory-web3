<?php

	$splash=returnDBObject("SELECT * FROM pages WHERE permalink=?",array('splash'));
	if(isset($_GET['page'])){
		$checkPage = str_replace("'","",$purifier->purify($_GET['page']));
	}
	if(!isset($_GET['page'])){
		{
			$route='homepage';
			$datatype='homepage';
		}
	}else{
		$datatype='';
		$result = returnDBObject("SHOW TABLES FROM ".database_connect,array());
		foreach($result as $res){
			$ch=explode('_',$res[0]);
			if(isset($ch[1]) && $ch[1]==$checkPage){
				$datatype=$checkPage;
				$route=$checkPage;
			}
		}
		if(!isset($route) && $datatype==''){
			$route=$purifier->purify($_GET['page']);
		}
	}
?>