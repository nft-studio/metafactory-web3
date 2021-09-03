<?php
			
	$row_rs_all = returnDBObject("SELECT * FROM ".$datatype, [], 1);
	
	include('inc/scripts_datatypes/createDatatypesArray.php');
					
	if(isset($_GET['id'])){
		$row_rs_single=returnDBObject("SELECT * FROM ".$datatype." WHERE id=?",array($_GET['id']));
	}
	
	if(isset($_POST['new'.$datatype])){
		include('inc/scripts_datatypes/standardDatatypeInsertQuery.php');
	}
	
	if(isset($_POST['mod'.$datatype])){
		include('inc/scripts_datatypes/standardDatatypeUpdateQuery.php');
	}
	
	if(isset($_GET['delete'])){
		runDBQuery("DELETE FROM ".$datatype." WHERE id=?",array($_GET['id']));
		$_SESSION['success_message']=$bmt_locales['admins']['single'].' '.$bmt_locales['deleted'].'.';
?>
		<script type="text/javascript">
	    	window.location = "<?php echo '/bmt/'.$internal_route; ?>";
	    </script>
<?php
	}
?>