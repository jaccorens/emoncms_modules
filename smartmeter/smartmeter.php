<?php

// this script runs every 10 seconds, that why we put it in a while loop.
// Define parameters
$emoncms_apikey = 'xxxxx'; //2348798273487237489723847234
$fp4allLoggerIP = '192.168.20.252';

$expireTime = time() + 60;

while (time() < $expireTime) {
	$xml = simplexml_load_file('http://'.$fp4allLoggerIP.'/log/status.xml');

	$ein1 = $xml->ein1; // energy import tariff 1
	$ein2 = $xml->ein2; // energy import tariff 2
	$euit1 = $xml->euit1; // energy export tariff 1
	$euit2 = $xml->euit2; // energy export tariff 2
	$pin = $xml->pin; // power import now
	$puit = $xml->puit; // power export now
	$c1m = $xml->c1m; // gas cubical meters total
	$c1mh = $xml->c1mh; // gas cubical meters last hour

	$url = 'http://localhost/emoncms/input/post.json?node=5&json={ein1:' . $ein1 . ',ein2:' . $ein2 . ',euit1:' . $euit1 .',euit2:' . $euit2 .',pin:' . $pin .',puit:' . $puit .',c1m:' . $c1m .',c1mh:' . $c1mh . '}&apikey='.$emoncms_apikey;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$contents = curl_exec ($ch);
	curl_close ($ch);
	sleep(10);
}
?>
