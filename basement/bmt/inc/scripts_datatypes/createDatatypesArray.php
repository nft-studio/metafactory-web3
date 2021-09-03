<?php
	$columns = list_columns($datatype);
	$custom_datatypes=array();
	foreach($columns as $row){
		if($row['Field']!='id' && $row['Comment']!='no'){
		$instructions=returnFieldInstructions($row['Comment']);
			if(isset($instructions['order']) && !isset($custom_datatypes[$instructions['order']])){
				$custom_datatypes[$instructions['order']]=$row;
			}else{
				$exist=1;
				$newOrder=0;
				if(isset($instructions['order'])){
					$newOrder=$instructions['order'];
				}
				while($exist==1){
					$newOrder++;
					if(!isset($custom_datatypes[$newOrder])){
						$exist=0;
					}
				}
				$custom_datatypes[$newOrder]=$row;  
			}
		}
	}
	ksort($custom_datatypes);
	
	$inputFields=array();
	
	foreach ($custom_datatypes as $field){ 
		$inputFields[$field['Field']]['instructions']=returnFieldInstructions($field['Comment']);
		if(isset($inputFields[$field['Field']]) && (!isset($inputFields[$field['Field']]['instructions']['type']) || $inputFields[$field['Field']]['instructions']['type']!='custom')){
			$inputFields[$field['Field']]['input'] = returnCorrectInputField($inputFields[$field['Field']]['instructions']['type'], $field['Field'], $inputFields[$field['Field']]['instructions']['required'], $inputFields[$field['Field']]['instructions']['specs'], isset($row_rs_single[$field['Field']]) ? $row_rs_single[$field['Field']] : '',$inputFields[$field['Field']]['instructions']['multiple']);
		}
	}
