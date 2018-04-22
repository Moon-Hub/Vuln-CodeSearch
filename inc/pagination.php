<?php

// PREPARE PAGINATION ARRAY

		/* 

		4 Possible array items in this order
		
		<-  PREV
		->  NEXT
		--> LAST
		<-- FIRST

		Array wont always have these 4 items

		*/

		$Prev = [];
		$Next = [];
		$Last = [];
		$First = [];

		$from = '<';
		$to = '>';

		$hasPrev = false;
		$hasNext = false;
		$hasLast = false;
		$hasFirst = false;

		$paginator = explode("," , $headers['link'][0]);

		foreach($paginator as $page) {

			if(strpos($page, 'rel="prev"')) {
				$hasPrev = true;
				$Prev[0] = getStringBetween($page, $from, $to);
			}

			if(strpos($page, 'rel="next"')) {
				$hasNext = true;
				$Next[0] = getStringBetween($page, $from, $to);
			}

			if(strpos($page, 'rel="last"')) {
				$hasLast = true;
				$Last[0] = getStringBetween($page, $from, $to);
			}

			if(strpos($page, 'rel="first"')) {
				$hasFirst = true;
				$First[0] = getStringBetween($page, $from, $to);
			}

		}

?>