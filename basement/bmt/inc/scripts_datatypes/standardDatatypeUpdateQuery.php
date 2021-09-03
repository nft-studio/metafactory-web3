<?php
		 //standard fields
			$updateSQL = "UPDATE ".$datatype." SET ";
			
			$i=0;
			foreach($custom_datatypes as $field){
				if($i!=0){$updateSQL.=', ';}
				
				$instructions=returnFieldInstructions($field['Comment']);
				
				if($instructions['type']!='custom' && $instructions['type']!='file'){
					$updateSQL.=$field['Field'].'='.returnCorrectPostDatatype($_POST[$field['Field']],$instructions['type'],$instructions['multiple']);
				}elseif($instructions['type']=='file'){
					 
					 if($_FILES[$field['Field']]['name']!=''){
						 $path_parts = pathinfo($_FILES[$field['Field']]['name']);
						 
						 if (strtolower($path_parts['extension']) == 'png' || strtolower($path_parts['extension']) == 'zip' || strtolower($path_parts['extension']) == 'jpeg' || strtolower($path_parts['extension']) == 'gif' || strtolower($path_parts['extension']) == 'jpg' || strtolower($path_parts['extension']) == 'mp4' || strtolower($path_parts['extension']) == 'mov' || strtolower($path_parts['extension']) == 'avi' ||  strtolower($path_parts['extension']) == 'doc' || strtolower($path_parts['extension']) == 'docx' || strtolower($path_parts['extension']) == 'pdf' || strtolower($path_parts['extension']) == 'xls' || strtolower($path_parts['extension']) == 'xlsx') {
							 
							 $filename=date('dmyHis').toAscii(sanitize(substr(str_replace(' ','',trim(basename($path_parts['basename']))),0,5))).'.'.strtolower($path_parts['extension']);
							 
							 if(!file_exists($subroot.'contents/'.$instructions['specs'])){
								 mkdir($subroot.'contents/'.$instructions['specs'],0755,true);
							 }
							 
							 $target = $subroot.'contents/'.$instructions['specs'].'/'.$filename;
							 move_uploaded_file($_FILES[$field['Field']]['tmp_name'], $target);
							 $updateSQL.=$field['Field'].'='."'".$filename."'";
						  }else{
							  $updateSQL.=$field['Field'].'='."''";
						  }
					 }else{
						 $updateSQL.=$field['Field'].'='."'".$_POST['old_'.$field['Field']]."'";
					 }
				}else{
					$updateSQL.=$field['Field'].'='.$toStore[$field['Field']];	
				}
				
				$i++;
			}	
			$updateSQL.=" WHERE id='".$_POST['mod'.$datatype]."'";				   
		//standard fields
		
		runDBQuery($updateSQL);
		
		$_SESSION['success_message']=$bmt_locales[$route]['single'].' '.$bmt_locales[$bmt_locales[$route]['gender']]['modified'].'.';
		
		if(!isset($noRedirect)){ ?>
			<script type="text/javascript">
        		window.location = "<?php echo '/bmt/'.$internal_route; ?>";
        	</script> 
		<?php } ?>