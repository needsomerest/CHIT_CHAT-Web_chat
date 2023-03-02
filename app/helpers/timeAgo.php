<?php

// setting up the time Zone
// It Depends on your location or your P.c settings
define('TIMEZONE', 'Asia/Bangkok');
date_default_timezone_set(TIMEZONE);

# Calculate how long ago you last seen message
function last_seen($date_time){

   #last time you seen message
   $timestamp = strtotime($date_time);	
   
   $strTime = array("second", "minute", "hour", "day", "month", "year");
   $length = array("60","60","24","30","12","10");

   #current Time 
   $currentTime = time();

   # Time difference between last time and current Time 
   if($currentTime >= $timestamp) {
		$diff     = time()- $timestamp;
		for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
		$diff = $diff / $length[$i];
		}

		$diff = round($diff);
		if ($diff < 59 && $strTime[$i] == "second") {
			return 'Active';
		}else {
			return $diff . " " . $strTime[$i] . "(s) ago ";
		}
		
   }
}