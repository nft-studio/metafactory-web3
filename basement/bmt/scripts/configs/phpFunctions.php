<?php
	
	$row_rs_all = returnDBObject("SELECT * FROM ".$datatype, [], 1);
	
	$file = 'inc/configurations.php';
	$fp = fopen($file, 'w');
	  
	$configs=returnDBObject("SELECT * FROM configs",array(),1);
	
	/*WRITING CONFIG FILE*/
	
	if($configs[0]['id']!=''){
	  	$file_locales='<?php 
	  					$configs=returnDBObject("SELECT * FROM configs",array(),1);
						
						foreach($configs as $config){				  
							switch($config["code"]){';
								
								foreach($configs as $config){
									if($config!=''){
										$file_locales.='	
										
										case "'.$config['code'].'":
											$'.$config['code'].'=strip_tags($config["value"]);
										break;
										
										';
									}
								}
							$file_locales.='}
							
							} 
							
							$sub=returnDBObject("SELECT * FROM configs WHERE code=?",array("subdomain_".$mode));
							$subdomain=$sub["value"];
							define("subdomain", $subdomain);
						?>';
	  }else{$file_locales='';}
	  
	  fwrite($fp, $file_locales);
	  fclose($fp);
	
	/*WRITING CONFIG FILE*/
	
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
		$_SESSION['success_message']=$bmt_locales[$route]['single'].' '.$bmt_locales['deleted'].'.';
?>
		<script type="text/javascript">
	    	window.location = "<?php echo '/bmt/'.$internal_route; ?>";
	    </script>
<?php
	}
?>