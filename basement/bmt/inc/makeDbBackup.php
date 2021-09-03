<?php
	session_start();
	include('core.php');
	$mode=returnConnectivityStat();
	require_once('dotenv.php');
	include('configurations.php');
	include('validate.user.php');
	include('../classes/class.pclzip.php');
	
	$backups = scandir('db_backup', 1);
	foreach($backups as $folder){
		if( ($folder!='.')&&($folder!='..')&&($folder!='.DS_Store')&&($folder!=date('d-m-y')) ){
			$path_parts = pathinfo('inc/db_backup/'.$folder);
			if(!isset($path_parts['extension'])){
				$compressDB = new PclZip('db_backup/'.$folder.".zip");
				$compressDB->add('db_backup/'.$folder,PCLZIP_OPT_REMOVE_PATH, 'inc/db_backup');
				deleteDir('db_backup/'.$folder);
			}else{
				$date=explode('-',$path_parts['filename']);
				$dateConfront='20'.$date[2].'-'.$date[1].'-'.$date[0];
				if(strtotime($dateConfront) < strtotime($backup_retain) ){
					unlink('db_backup/'.$path_parts['filename'].'.'.$path_parts['extension']);
				}
			}
		}
	}
	
	if(!is_dir('db_backup/'.date('d-m-y'))){
		mkdir('db_backup/'.date('d-m-y'));
	}
	
	if(!is_dir('db_backup/'.date('d-m-y').'/'.session_id())){
		mkdir('db_backup/'.date('d-m-y').'/'.session_id());
	}
	
	backupDB(false,'db_backup/'.date('d-m-y').'/'.session_id().'/db_'.date($backup_pattern).'.sql');
	
	echo 'Done';
?>