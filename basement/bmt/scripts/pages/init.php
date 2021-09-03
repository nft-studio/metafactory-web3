<?php 
	include('scripts/'.$datatype.'/phpFunctions.php');

	if(!isset($_GET['id']) && !(isset($_GET['action']))){
		include('scripts/'.$datatype.'/completeTable.php');
	}elseif(isset($_GET['action'])){

		include('scripts/'.$datatype.'/'.$_GET['action'].'.php');
	}
	
	include('scripts/'.$datatype.'/JSFunctions.php');
?>