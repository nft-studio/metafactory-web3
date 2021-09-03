<?php
	$row_rs_all = returnDBObject("SELECT * FROM ".$datatype, [], 1);
	
	if(isset($_GET['id'])){
		$row_rs_single=returnDBObject("SELECT * FROM ".$datatype." WHERE id=?",array($_GET['id']));
	}
	
	include('inc/scripts_datatypes/createDatatypesArray.php');
	$languages=returnDBObject("SELECT * FROM languages",array(),1);
	
	/*WRITING LOCALES FILE*/
	
	$translations=returnDBObject("SELECT * FROM translations",array(),1);
	$file = '../inc/locales.php';
	$fp = fopen($file, 'w');
	
	if(isset($translations[0]['id'])){
	  	$file_locales='<?php ';
	  		foreach ($translations as $array){
		  		$traslate_languages=json_decode($array['locales'],1);
		  		foreach($traslate_languages as $ln){
		  			if($array['is_html']=='NO'){
				  		$locale=strip_tags($ln['locale']);
			  		}else{
				  		$locale=$ln['locale'];
			  		}
		  			$file_locales.='
		  			$website_translations["'.$array['globale'].'"]["'.$ln['language'].'"]="'.str_replace('"','\"',$locale).'";
		  			if(isset($website_translations["'.$array['globale'].'"][$language])){ $'.$array['globale'].'=$website_translations["'.$array['globale'].'"][$language];}';
		  		}
	  		}								
		$file_locales.=' ?>';
	}else{$file_locales='';}
	  
	fwrite($fp, $file_locales);
	fclose($fp);
	
	/*WRITING LOCALES FILE*/				
	
	if(isset($_POST['new'.$datatype])){
		
		//custom fields
			$toStore['globale']="'".$_POST['globale']."'";
			$array_locales=array();
			$i=0;
			foreach($languages as $language){
				array_push($array_locales, array(
					"language"=>$language['uni_code'],
					"locale"=>str_replace('"','\"',str_replace(array("\r\n", "\r", "\n"),'',preg_replace('/\s\s+/',' ',str_replace("\r",'',str_replace("\n", '',str_replace(PHP_EOL, '',$_POST['locales'][$i]))))))
				));
				$i++;
			}
			$toStore['locales']="'".str_replace("'","\'",json_encode($array_locales))."'";
		//custom fields
		
		include('inc/scripts_datatypes/standardDatatypeInsertQuery.php');

	}
	
	if(isset($_POST['mod'.$datatype])){
		
		//custom fields
			$toStore['globale']="'".$_POST['globale']."'";
			$array_locales=array();
			$i=0;
			foreach($languages as $language){
				array_push($array_locales, array(
					"language"=>$language['uni_code'],
					"locale"=>str_replace('"','\"',str_replace(array("\r\n", "\r", "\n"),'',preg_replace('/\s\s+/',' ',str_replace("\r",'',str_replace("\n", '',str_replace(PHP_EOL, '',$_POST['locales'][$i]))))))
				));
				$i++;
			}
			$toStore['locales']="'".str_replace("'","\'",json_encode($array_locales))."'";
		//custom fields
		
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