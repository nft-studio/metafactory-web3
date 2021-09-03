<?php 
	  					$configs=returnDBObject("SELECT * FROM configs",array(),1);
						
						foreach($configs as $config){				  
							switch($config["code"]){	
										
										case "siteurl":
											$siteurl=strip_tags($config["value"]);
										break;
										
											
										
										case "subdomain_offline":
											$subdomain_offline=strip_tags($config["value"]);
										break;
										
											
										
										case "subdomain_online":
											$subdomain_online=strip_tags($config["value"]);
										break;
										
											
										
										case "debug_mode":
											$debug_mode=strip_tags($config["value"]);
										break;
										
											
										
										case "newsletter_mail":
											$newsletter_mail=strip_tags($config["value"]);
										break;
										
											
										
										case "newsletter_from":
											$newsletter_from=strip_tags($config["value"]);
										break;
										
											
										
										case "ieblock":
											$ieblock=strip_tags($config["value"]);
										break;
										
											
										
										case "contattimail":
											$contattimail=strip_tags($config["value"]);
										break;
										
											
										
										case "mail_host":
											$mail_host=strip_tags($config["value"]);
										break;
										
											
										
										case "mail_port":
											$mail_port=strip_tags($config["value"]);
										break;
										
											
										
										case "mail_secure":
											$mail_secure=strip_tags($config["value"]);
										break;
										
											
										
										case "mail_username":
											$mail_username=strip_tags($config["value"]);
										break;
										
											
										
										case "mail_password":
											$mail_password=strip_tags($config["value"]);
										break;
										
											
										
										case "mail_name":
											$mail_name=strip_tags($config["value"]);
										break;
										
											
										
										case "backup_pattern":
											$backup_pattern=strip_tags($config["value"]);
										break;
										
											
										
										case "backup_retain":
											$backup_retain=strip_tags($config["value"]);
										break;
										
											
										
										case "selected_language":
											$selected_language=strip_tags($config["value"]);
										break;
										
										}
							
							} 
							
							$sub=returnDBObject("SELECT * FROM configs WHERE code=?",array("subdomain_".$mode));
							$subdomain=$sub["value"];
							define("subdomain", $subdomain);
						?>