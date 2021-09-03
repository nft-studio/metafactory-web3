<?php
$row_rs_languages = returnDBObject("SELECT * FROM languages ORDER BY id ASC", [], 1);
$i = 0;
$languages = [];
foreach ($row_rs_languages as $row) {
	$languages[$i]['uni_code'] = $row['uni_code'];
	$languages[$i]['output_name'] = $row['output_name'];
	$i++;
}

$file = '../.htaccess';
$fp = fopen($file, 'w');

$htaccess = '
 		 RewriteEngine On
 		 Options -Multiviews
 		 Options -Indexes
 		 <IfModule mod_security.c>
 		 	SecFilterEngine Off
 		 	SecFilterScanPOST Off
		 </IfModule>
		 <Files .env>
			order allow,deny
			Deny from all
		</Files>
		<Files *.sh>
		   order allow,deny
		   Deny from all
	   	</Files>
		<Files *.sql>
			order allow,deny
			Deny from all
		</Files>
';

if (force_ssl != 'force_ssl' && force_ssl == 'on') {
	$htaccess .= "
		 RewriteCond %{HTTPS} !=on
    	 RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R,QSA]
		 ";
}
$htaccess .= "
		#CUSTOM-DATATYPES#";

$tables = list_tables();
foreach ($tables as $table) {
	$name_parts = explode('_', $table);
	if ($name_parts[0] == 'datatype') {

		$htaccess .= "
     
		#" . strtoupper($name_parts[1]) . "#
		RewriteRule bmt/datatype-" . $name_parts[1] . "/new bmt/customdata.php?datatype=" . $name_parts[1] . "&action=new [L] 
		RewriteRule bmt/datatype-" . $name_parts[1] . "/([^/]+)/mod bmt/customdata.php?datatype=" . $name_parts[1] . "&action=mod&id=$1 [L] 
		RewriteRule bmt/datatype-" . $name_parts[1] . "/([^/]+)/del bmt/customdata.php?datatype=" . $name_parts[1] . "&delete=yes&id=$1 [L] 
		RewriteRule (\W|^)bmt/datatype-" . $name_parts[1] . "(\W|$) bmt/customdata.php?datatype=" . $name_parts[1] . " [L]";
	}
}

$htaccess .= "										
			
	   	#CONFIGS#
		RewriteRule bmt/configs/new bmt/configs.php?action=new [L] 
		RewriteRule bmt/configs/([^/]+)/del bmt/configs.php?delete=yes&id=$1 [L]
		RewriteRule bmt/configs/([^/]+)/mod bmt/configs.php?action=mod&id=$1 [L] 
		RewriteRule (\W|^)bmt/configs(\W|$) bmt/configs.php [L] 
										
		#TRANSLATIONS#
		RewriteRule bmt/translations/new bmt/translations.php?action=new [L] 
		RewriteRule bmt/translations/([^/]+)/del bmt/translations.php?delete=yes&id=$1 [L] 
		RewriteRule bmt/translations/([^/]+)/mod bmt/translations.php?action=mod&id=$1 [L] 
		RewriteRule (\W|^)bmt/translations(\W|$) bmt/translations.php [L] 
		
		#LANGUAGES#
		RewriteRule bmt/languages/new bmt/languages.php?action=new [L] 
		RewriteRule bmt/languages/([^/]+)/del bmt/languages.php?delete=yes&id=$1 [L] 
		RewriteRule bmt/languages/([^/]+)/mod bmt/languages.php?action=mod&id=$1 [L] 
		RewriteRule (\W|^)bmt/languages(\W|$) bmt/languages.php [L] 
		
		#NEWSLETTER#
		RewriteRule bmt/manage-newsletter/send-newsletter/([^/]+) bmt/newsletter.php?action=send_n&id=$1 [L]
		RewriteRule bmt/manage-newsletter/tracking/([^/]+) bmt/newsletter.php?action=tracking&id=$1 [L]
		RewriteRule bmt/manage-newsletter/([^/]+)/mod bmt/newsletter.php?action=mod_n&id=$1 [L]
		RewriteRule bmt/manage-newsletter/utenti/([^/]+) bmt/newsletter.php?action=mod_u&id=$1 [L]
		RewriteRule bmt/manage-newsletter/inserisci-utente bmt/newsletter.php?action=ins_u [L]
		RewriteRule bmt/manage-newsletter/utenti bmt/newsletter.php?action=vis_u [L]
		RewriteRule bmt/manage-newsletter/new bmt/newsletter.php?action=ins_n [L]
		RewriteRule (\W|^)bmt/manage-newsletter(\W|$) bmt/newsletter.php [L] 
					
		#ADMINS#
		RewriteRule bmt/admins/new bmt/admins.php?action=new [L] 
		RewriteRule bmt/admins/([^/]+)/del bmt/admins.php?delete=yes&id=$1 [L]
		RewriteRule bmt/admins/([^/]+)/mod bmt/admins.php?action=mod&id=$1 [L] 
		RewriteRule (\W|^)bmt/admins(\W|$) bmt/admins.php [L] 
		
		#HTACCESS#
		RewriteRule bmt/manage-htaccess/new bmt/htaccess.php?action=new [L] 
		RewriteRule bmt/manage-htaccess/([^/]+)/del bmt/htaccess.php?delete=yes&id=$1 [L]
		RewriteRule bmt/manage-htaccess/([^/]+)/mod bmt/htaccess.php?action=mod&id=$1 [L] 
		RewriteRule (\W|^)bmt/manage-htaccess(\W|$) bmt/htaccess.php [L] 
		
		#LOGIN USER #
		RewriteRule login/([^/]+) pages/user.php?id=$1 [L] 

		#MENU#
		RewriteRule bmt/menu/new bmt/menu.php?action=new [L] 
		RewriteRule bmt/menu/([^/]+)/del bmt/menu.php?delete=yes&id=$1 [L]
		RewriteRule bmt/menu/([^/]+)/mod bmt/menu.php?action=mod&id=$1 [L] 
		RewriteRule (\W|^)bmt/menu(\W|$) bmt/menu.php [L] 
		
		#INFO#
		RewriteRule (\W|^)bmt/info(\W|$) bmt/info.php [L] 

		#USERS MANAGEMENT#
		RewriteRule (\W|^)bmt/users(\W|$) bmt/users.php [L] 
		
		#MINTING#
		RewriteRule (\W|^)bmt/minting(\W|$) bmt/minting.php [L] 

		#PASSWORD RESET#
		RewriteRule (\W|^)password-reset/([^/]+) pages/password-reset.php?token=$1 [L] 

		#NFTS#
		RewriteRule (\W|^)bmt/nfts(\W|$) bmt/nfts.php [L] 
		RewriteRule bmt/nft/([^/]+)/([^/]+) bmt/nft.php?contract=$1&id=$2 [L] 
		RewriteRule bmt/nft/([^/]+) bmt/nft.php?id=$1 [L] 
			
		#FILEMANAGER#
		RewriteRule (\W|^)bmt/file-manager(\W|$) bmt/filemanager.php [L] 

		#PAGES#
		RewriteRule (\W|^)bmt/reload-engine(\W|$) bmt/engine.php [L] 
		RewriteRule bmt/pages/new/layout/([^/]+) bmt/pages.php?action=new&layout=$1 [L] 
		RewriteRule bmt/pages/([^/]+)/mod/layout/([^/]+) bmt/pages.php?action=mod&id=$1&layout=$2 [L] 
		RewriteRule bmt/pages/([^/]+)/del bmt/pages.php?delete=yes&id=$1 [L] 
		RewriteRule bmt/pages/([^/]+)/mod bmt/pages.php?action=mod&id=$1 [L]
		RewriteRule bmt/pages/new bmt/pages.php?action=new [L] 
		RewriteRule (\W|^)bmt/pages(\W|$) bmt/pages.php [L] 
		
		RewriteRule bmt/manage-datatypes/([^/]+)/remove bmt/datatypes.php?remove=$1 [L] 
		RewriteRule bmt/manage-datatypes/([^/]+)/restore bmt/datatypes.php?restore=$1 [L] 
		RewriteRule bmt/manage-datatypes/([^/]+)/del bmt/datatypes.php?delete=yes&type=$1 [L] 
		RewriteRule bmt/manage-datatypes/([^/]+)/mod bmt/datatypes.php?action=mod&type=$1 [L] 
		RewriteRule bmt/manage-datatypes/new bmt/datatypes.php?action=new [L]
		RewriteRule bmt/manage-datatypes/backups bmt/datatypes.php?action=backups [L]
		RewriteRule (\W|^)bmt/manage-datatypes(\W|$) bmt/datatypes.php [L]
		        
        RewriteRule (\W|^)bmt/login/errore(\W|$) bmt/login.php?error=true [L] 
		RewriteRule (\W|^)bmt/login(\W|$) bmt/login.php [L] 
		RewriteRule (\W|^)bmt/logout(\W|$)  bmt/index.php?doLogout=true [L] 
		
		#CUSTOM HTACCESS#
		";

$row_rs_htaccess = returnDBObject("SELECT * FROM htaccess WHERE active=? ORDER BY ordine ASC ", array('SI'), 1);

if (isset($row_rs_htaccess[0]['id'])) {
	foreach ($row_rs_htaccess as $htaccessPage) {
		$htaccess .= "
			  " . $htaccessPage['line'];
	}
}

$htaccess .= "
		#WEBSITE#
		";


$row_rs_htaccess = returnDBObject("SELECT * FROM pages WHERE language!=? ORDER BY title ASC ", array($languages[0]['uni_code']), 1);

if (isset($row_rs_htaccess[0]['id'])) {
	foreach ($row_rs_htaccess as $htaccessPage) {
		$htaccess .= "
			  	RewriteRule " . $htaccessPage['language'] . "/" . $htaccessPage['permalink'] . " index.php?page=" . $htaccessPage['permalink'] . "&ln=" . $htaccessPage['language'] . " [L]";
	}
}

$row_rs_htaccess = returnDBObject("SELECT * FROM pages WHERE language=? ORDER BY title ASC ", array($languages[0]['uni_code']), 1);

if (isset($row_rs_htaccess[0]['id'])) {
	foreach ($row_rs_htaccess as $htaccessPage) {
		$htaccess .= "
			  	RewriteRule " . $htaccessPage['language'] . "/" . $htaccessPage['permalink'] . " index.php?page=" . $htaccessPage['permalink'] . "&ln=" . $htaccessPage['language'] . " [L]";
		$htaccess .= " 
			  	RewriteRule (\W|^)" . $htaccessPage['permalink'] . "(\W|$) index.php?page=" . $htaccessPage['permalink'] . " [L]";
	}
}

$check_htaccess = fwrite($fp, $htaccess);

fclose($fp);
