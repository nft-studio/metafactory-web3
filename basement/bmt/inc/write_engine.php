<?php
	$includePosition='../';
	include('core.php');
   	$mode=returnConnectivityStat();
    require_once('dotenv.php');	
	
	$permissionsErrors='';
	
	include('configurations.php');
	include('setpermissions.php');
	include('navigation.php');	
	include('validate.user.php');
	include('write_htaccess.php');   
	include('write_sitemap.php');  
	include('write_rss.php'); 
	
	if($check_htaccess==true){
		echo '
			<div class="widget-header-block" style="margin-top:-20px;">
				<h4 class="widget-header"><i class="fa fa-ok" style="color:##37ff2c;"></i> .htaccess</h4>
			</div>
			<pre class="prettyprint linenums">'.$htaccess.'</pre>';
	}else{
		echo '<h4 class="widget-header"><i class="fa fa-remove" style="color:##37ff2c;"></i>
		Si è verificato un errore nella scrittura del file .htaccess, controllare.</h4>';
	}
	
	if($check_sitemap==true){
		echo '<div class="widget-header-block">
				<h4 class="widget-header"><i class="fa fa-ok" style="color:##37ff2c;"></i> sitemap.xml</h4>
			  </div>
			  <pre class="prettyprint linenums">'.$sitemap.'</pre>';
	}else{
		echo '<h4 class="widget-header"><i class="fa fa-remove" style="color:##37ff2c;"></i>Si è verificato un errore nella scrittura del file sitemap.xml, controllare.</h4>';
	}
	
	if($makeRss=='yes'){
		if($check_rss==true){
			echo '<div class="widget-header-block">
					<h4 class="widget-header"><i class="fa fa-ok" style="color:##37ff2c;"></i> rss.xml</h4>
				  </div>
				  <pre class="prettyprint linenums">'.$rss.'</pre>';
		}else{
			echo '<h4 class="widget-header"><i class="fa fa-remove" style="color:##37ff2c;"></i>Si è verificato un errore nella scrittura del file rss.xml, controllare.</h4>';
		}
	}
?>