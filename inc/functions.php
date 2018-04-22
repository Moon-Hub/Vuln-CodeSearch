<?php

	// MAKE VAR_DUMP READABLE 
	function var_dump_pre($mixed = null) {
		echo '<pre>';
		var_dump($mixed);
		echo '</pre>';
		return null;
	}

	function getStringBetween($str,$from,$to)
	{
	    $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
	    return substr($sub,0,strpos($sub,$to));
	}

?>