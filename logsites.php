<?php

function cache($file){
	$cache = 'logs/'.$file.'.txt';
	$get = file_get_contents($cache);
	$data = unserialize($get); 
	return $data;
}


$allsites = 'https://api.uptimerobot.com/getMonitors?apiKey=u332704-0762d00a28f908b5320edd51&format=json';
$jsonwebsites = file_get_contents($allsites);
$clean = substr( $jsonwebsites, 0, -1 );
$cleaned = substr($clean, 19);
$websites = json_decode($cleaned, true);
$monitors = $websites['monitors']['monitor'];



foreach ($monitors as $webs){
	$storeids[] = array($webs['id'], $webs['status']);
	$siteids[] = $webs['id'];
	$checkids[$webs['id']] = $webs['status'];
	$friendlyname[$webs['id']] = $webs['friendlyname'];
	$url[$webs['id']] = $webs['url'];
}
	
$cacheids = 'logs/siteids.txt';
$put = serialize($storeids);
file_put_contents($cacheids, $put);
	
$it = cache('checkids');

/*
echo '<pre>';
print_r($monitors);
echo '</pre>';
*/


foreach ($siteids as $get){


	$new = $checkids[$get];
	$last = cache($get);
	
	if ($last != $new){
		echo $get.' -- ('.$last.') -- ('.$new.') Updated<br/>';
		include_once('slack.php');
	} else {
		echo $get.' -- ('.$last.') -- ('.$new.')<br/>';
	}
	
	$cache = 'logs/'.$get.'.txt';
	$put = serialize($new);
	file_put_contents($cache, $put);
	
}


$cachecheck = 'logs/checkids.txt';
$put = serialize($checkids);
file_put_contents($cachecheck, $put);


//print_r($it);
?>