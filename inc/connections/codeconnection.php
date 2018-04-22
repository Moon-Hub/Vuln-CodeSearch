<?php

		// API CONNECTION
		$url = 'https://api.github.com/search/code?q=' . urlencode($term) . '+' . 'language:' . $lang . '&per_page=' . $pp . '&page=1';
		$headers = [];
		$cInit = curl_init();
		curl_setopt($cInit, CURLOPT_URL, $url);
		curl_setopt($cInit, CURLOPT_RETURNTRANSFER, 1); // 1 = TRUE
		curl_setopt($cInit, CURLOPT_USERAGENT, $user); // $_SERVER['HTTP_USER_AGENT'] can be replaced with $user
		curl_setopt($cInit, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($cInit, CURLOPT_USERPWD, $user . ':' . $pwd);
		curl_setopt($cInit, CURLOPT_HTTPHEADER, array('Accept: application/vnd.github.v3.text-match+json')); // ADD THE HIGHLIGHTED CODE SECTION
		// curl_setopt($cInit, CURLOPT_HEADER, true);
		curl_setopt($cInit, CURLOPT_CONNECTTIMEOUT, 0); 
		curl_setopt($cInit, CURLOPT_TIMEOUT, 400); //timeout in seconds

		// this function is called by curl for each header received
		curl_setopt($cInit, CURLOPT_HEADERFUNCTION,
		  function($curl, $header) use (&$headers)
		  {
		    $len = strlen($header);
		    $header = explode(':', $header, 2);
		    if (count($header) < 2) // ignore invalid headers
		      return $len;

		    $name = strtolower(trim($header[0]));
		    if (!array_key_exists($name, $headers))
		      $headers[$name] = [trim($header[1])];
		    else
		      $headers[$name][] = trim($header[1]);

		    return $len;
		  }
		);

		// MAKE CURL OUTPUT READABLE
		$output = curl_exec($cInit);

		$items = json_decode($output, true); 
		curl_close($cInit); // CLOSE OUR API CONNECTION

?>