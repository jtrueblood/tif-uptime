<?php
if ($new == 9){	

		$message = 'SITE DOWN -- '.$friendlyname[$$get].' ('.$url[$get].')'; 
		$username = "TIF Web Monitor";
		$channel = "#zzz_testing";
		$icon = ":warning:";
		$color = "#36a64f";
		$pretext = '';
	
	}
	
	if ($new == 2){	

		$message = 'SITE UP -- '.$friendlyname[$$get].' ('.$url[$get].')'; 
		$username = "TIF Web Monitor";
		$channel = "#zzz_testing";
		$icon = ":white_check_mark:";
		$color = "#36a64f";
		$pretext = '';
	
	}
	
if ($new == 0){	

		$message = 'SITE MONITOR PAUSED -- '.$friendlyname[$$get].' ('.$url[$get].')'; 
		$username = "TIF Web Monitor";
		$channel = "#zzz_testing";
		$icon = ":double_vertical_bar:";
		$color = "#36a64f";
		$pretext = '';
	
	}
	
if ($slackstatus == 98){	

		$message = 'TIF WEB MONITOR STARTED'; 
		$username = "TIF Web Monitor";
		$channel = "#zzz_testing";
		$icon = ":desktop_computer:";
		$color = "#36a64f";
		$pretext = '';
	
	}
	 
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
?>