<?php

// this script runs every 10 seconds, that why we put it in a while loop.
// Define parameters
$emoncms_apikey = 'xxxxx'; //2348798273487237489723847234
$fp4allLoggerIP = '192.168.20.252';

$expireTime = time() + 60;

while (time() < $expireTime) {
	$xml = simplexml_load_file('http://'.$fp4allLoggerIP.'/status.xml');

	$solar_power = $xml->gauge_power;
	$solar_temp = $xml->gauge_temp;
	$solar_vpv = $xml->gauge_vpv;

	// Compile url for posting to emoncms
	$url = 'http://localhost/emoncms/input/post.json?node=6&json={pv1_power:' . $solar_power . ',pv1_temp:' . $solar_temp . ',pv1_pvvolt:' . $solar_vpv . '}&apikey='.$emoncms_apikey;

	// Post data to emoncms
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$contents = curl_exec ($ch);
	curl_close ($ch);
	sleep(10);
}
?>
