<?php 

/*
CREATE TABLE SITESLOG
(INTEGER PRIMARY KEY,
SITEID   TEXT,
TIME     INT);

CREATE TABLE STATUS
(SITEID   TEXT,
TIME     INT,
LASTSTATE   INT,
STATE INT);

*/


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

$thesiteid = '777833257';
$onesite = 'https://api.uptimerobot.com/getMonitors?apiKey=u332704-0762d00a28f908b5320edd51&logs=1&alertContacts=1&responseTimes=1&responseTimesAverage=180&monitors='.$thesiteid.'&format=json';
$allsites = 'https://api.uptimerobot.com/getMonitors?apiKey=u332704-0762d00a28f908b5320edd51&format=json';

	
$jsonwebsites = file_get_contents($allsites);
$clean = substr( $jsonwebsites, 0, -1 );
$cleaned = substr($clean, 19);
$websites = json_decode($cleaned, true);
$monitors = $websites['monitors']['monitor'];
$log = $monitors['log'];


/*
echo '<pre>';
print_r($log);
echo '</pre>';
*/


$db->exec('delete from status');

foreach ($monitors as $status){

$a = $status['status'];
$b = $status['id'];
	
// sets 'status' table	
$db = new MyDB();	

/*
$insertsql =<<<EOF
	INSERT INTO STATUS (SITEID, TIME, LASTSTATE, STATE)
	VALUES (0000000, 000000, 0, 0);
	
EOF;
*/
	
$updatesql =<<<EOF
INSERT OR REPLACE into STATUS (SITEID, TIME, LASTSTATE, STATE) values ($b, time(), 0, $a);
EOF;
$db->exec($updatesql);
	
// end query
	
}


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
		} else {
			end;
		}

} 


?>
