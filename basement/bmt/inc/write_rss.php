<?php
  $tables = array();
  $tables = list_tables();
  $makeRss='no';
  foreach($tables as $table){  	
      if($table=='datatype_articoli'){
	     $makeRss='yes'; 
	  }
   }
  if($makeRss=='yes'){
	  $articoli = returnDBObject("SELECT * FROM datatype_articoli WHERE attivo=? ORDER BY data DESC",array('SI'));
	  $file = $includePosition.'../rss.xml';
	  $rss_file = fopen($file, 'w');
	  $rss='<rss version="2.0"> 
	  		  <channel>';
	  
	  foreach($articoli as $articolo){
			$rss.='
			    <item> 
			      <language>'.strtolower($articolo['lingua']).'-'.$articolo['lingua'].'</language>
			      <guid isPermaLink="false">'.$_SERVER['HTTP_HOST'].'-'.$articolo['id'].'</guid> 
			      <pubDate>'.date('r', strtotime($articolo['data'])).'</pubDate> 
			      <category domain="'.$_SERVER['HTTP_HOST'].'">'.str_replace(',','/',$articolo['categoria']).'</category>
			      <title>'.$articolo['titolo'].'</title> 
			      <description>'.str_replace('&nbsp;','',strip_tags($articolo['testo'])).'</description> 
			      <link>http://'.$_SERVER['HTTP_HOST'].'/blog/'.$articolo['id'].'/'.toAscii($articolo['titolo']).'</link> 
			      <author>'.$linkcontatti.'</author> 
			    </item>';
	   } 
	  $rss.='</channel>  
	  	 </rss> ';
	  	 
	   $check_rss=fwrite($rss_file, $rss); 
	   fclose($rss_file);
  }
?>