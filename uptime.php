<?php 

class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('test.db');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
	}


$thesiteid = '777833380';
$onesite = 'https://api.uptimerobot.com/getMonitors?apiKey=u332704-0762d00a28f908b5320edd51&logs=1&alertContacts=1&responseTimes=1&responseTimesAverage=180&monitors='.$thesiteid.'&format=json';
$allsites = 'https://api.uptimerobot.com/getMonitors?apiKey=u332704-0762d00a28f908b5320edd51&format=json';

	
$jsonwebsites = file_get_contents($allsites);
$clean = substr( $jsonwebsites, 0, -1 );
$cleaned = substr($clean, 19);
$websites = json_decode($cleaned, true);
$monitors = $websites['monitors']['monitor'];


foreach ($monitors as $monitor){
	$a = $monitor['status'];
	$b = $monitor['id'];
	$siteids[$b] = $a;
	if ($a == 9){
		
	$sql =<<<EOF
	INSERT INTO SITESLOG (ROWID,SITEID,TIME)
	VALUES (NULL, $b, time());
EOF;
	
	
   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Records created successfully\n";
   }
   $db->close();
	}
	
}

/*
CREATE TABLE SITESLOG
(INTEGER PRIMARY KEY,
SITEID   TEXT,
TIME     INT);
*/

/*
echo '<pre>';
print_r($downarray);
echo '</pre>';
*/


$data = '';
foreach ($monitors as $monitor){
	
		
	$m_name = $monitor['friendlyname'];
	$m_url = $monitor['url'];
	$m_status = $monitor['status'];	
	$m_id = $monitor['id'];
	
	if ($m_status == 9){	

		$message = 'SITE DOWN -- '.$m_name.' ('.$m_url.')'; 
		$username = "TIF Web Monitor";
		$channel = "#zzz_testing";
		$icon = ":warning:";
		$color = "#36a64f";
		$pretext = '';
		 
		$data = "payload=" . json_encode(array(         
		        "channel"       =>  $channel,
		        "username"		=>	$username,
		        "color"			=>	$color,
		        "pretext"		=>	$pretext,
		        "text"          =>  $message,
		        "icon_emoji"    =>  $icon
		));
	
		$url = 'https://hooks.slack.com/services/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';
		         
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		echo var_dump($result);
		if($result === false)
		{
		    echo 'Curl error: ' . curl_error($ch);
		}
		curl_close($ch);
	} 
} 

?>
