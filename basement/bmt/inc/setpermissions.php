<?php
	if(!is_writable('inc/db_backup/')){
		mkdir('inc/db_backup/');
	}
	if(!is_writable('inc/configurations.php')){
		$permissionsErrors.='Impossibile scrivere il file delle configurazioni<br>';
	}
	if(!is_writable('../.htaccess')){
		$permissionsErrors.='Impossibile scrivere il file .htaccess<br>';
	}
	if(!is_writable('../sitemap.xml')){
		$permissionsErrors.='Impossibile scrivere il file sitemap.xml<br>';
	}
	if(!is_writable('../contents/')){
		$permissionsErrors.='Impossibile scrivere nella cartella dei contenuti<br>';
		mkdir('../contents/');
	}
	if(is_dir('../contents/')){
		foreach(scandir('../contents/') as $dir){
	    	if((is_dir('../contents/'.$dir))&&($dir!='..')){
		        if(!is_writable('../contents/'.$dir)){
		        	$permissionsErrors.='Impossibile scrivere nella cartella "'.$dir.'"<br>';
		        }
	        }
	    }
	}
  
?>