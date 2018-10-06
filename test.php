<?php
	$to="7905183946";		//Number to dial
	$from="";	//userid in sipx
	$pass="";	//sipx pin (NOT SIP password)
	
	//replace sipx.gcgov.local with your sipx server
	$url = "http://192.168.1.77:5060/callcontroller/".$from."/".$to."?isForwardingAllowed=true"; 
	$ch = curl_init();     
	curl_setopt($ch, CURLOPT_URL, $url);  
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST); 
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERPWD, $from.":".$pass);
	$result = curl_exec($ch);  
	curl_close($ch);  
?> 	