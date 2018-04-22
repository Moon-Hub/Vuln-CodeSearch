<?php

// GRAB EXTRA INFORMATION ABOUT THE FILES REPOSITORY WITH CURL - IN THIS CASE THE STARGAZERS_COUNT

	// SEARCH PARAMETERS
	$term = $item['repository']['name'];

	// API CONNECTION
	$repourl = 'https://api.github.com/search/repositories?q=' . $term;
	$cSecond = curl_init();
	curl_setopt($cSecond, CURLOPT_URL, $repourl);
	curl_setopt($cSecond, CURLOPT_RETURNTRANSFER, 1); // 1 = TRUE
	curl_setopt($cSecond, CURLOPT_USERAGENT, $user); // $_SERVER['HTTP_USER_AGENT'] can be replaced with $user
	curl_setopt($cSecond, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($cSecond, CURLOPT_USERPWD, $user . ':' . $pwd);
	curl_setopt($cSecond, CURLOPT_CONNECTTIMEOUT, 0); 
	curl_setopt($cSecond, CURLOPT_TIMEOUT, 400); //timeout in seconds

	// MAKE CURL OUTPUT READABLE
	$secondary = curl_exec($cSecond);
	$repo = json_decode($secondary, true);
	curl_close($cSecond);
	
?>