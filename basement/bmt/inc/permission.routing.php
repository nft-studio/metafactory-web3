<?php
	if(isset($permission_level)){
		if(getUserLevel($user['level'])<$permission_level){
			die('Accesso non consentito');
		}
	}
?>