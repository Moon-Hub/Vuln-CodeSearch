<?php

// GRAB EXTRA INFORMATION ABOUT THE FILES REPOSITORY WITH CURL - IN THIS CASE THE STARGAZERS_COUNT

	// API CONNECTION
	$matchurl = $item['text_matches'][$i]['object_url'];

	$cThird = curl_init();
	curl_setopt($cThird, CURLOPT_URL, $matchurl);
	curl_setopt($cThird, CURLOPT_RETURNTRANSFER, 1); // 1 = TRUE
	curl_setopt($cThird, CURLOPT_USERAGENT, $user); // $_SERVER['HTTP_USER_AGENT'] can be replaced with $user
	curl_setopt($cThird, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($cThird, CURLOPT_USERPWD, $user . ':' . $pwd);
	curl_setopt($cThird, CURLOPT_CONNECTTIMEOUT, 0); 
	curl_setopt($cThird, CURLOPT_TIMEOUT, 400); //timeout in seconds

	// MAKE CURL OUTPUT READABLE
	$third = curl_exec($cThird);
	$obj = json_decode($third, true);
	curl_close($cThird);

?>