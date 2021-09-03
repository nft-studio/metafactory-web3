<?php
	$row_rs_sitemap = returnDBObject("SELECT * FROM pages", [], 1);
  if(!isset($includePosition)){
  	$includePosition='';
  }
  $file = $includePosition.'../sitemap.xml';
  
  $sitemap_file = fopen($file, 'w');
  
  $sitemap='<?xml version="1.0" encoding="UTF-8"?>
  <urlset xmlns="http://www.google.com/schemas/sitemap/0.9">';
  foreach($row_rs_sitemap as $page){
	$sitemap.='  
		<url>
	        <loc>'.$siteurl.'/'.$page['language'].'/'.$page['permalink'].'</loc>
	        <lastmod>'.date('Y-m-d').'</lastmod>
	        <changefreq>'.$page['change_freq'].'</changefreq>
	        <priority>'.$page['priority'].'</priority>
	    </url>';
	
  }

  $sitemap.='</urlset>';

  $check_sitemap= fwrite($sitemap_file, $sitemap); 
 
  fclose($sitemap_file);
?>