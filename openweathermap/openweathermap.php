<?php

// Module for pulling wind data from openweathermap to emoncms
// More information: http://openweathermap.org/api

// Define parameters
$emoncms_apikey = 'xxxxx'; //2348798273487237489723847234
$openweathermap_apikey = 'yyyyy'; // 3h287rhy23828
$myLatitude = '00000'; //52.00000
$myLontitude = '11111'; // 4.80000

// Fetch data from openweathermap
$json_string = file_get_contents('http://api.openweathermap.org/data/2.5/weather?lat='.$myLatitude.'&lon='.$myLontitude.'&units=metric&APPID=' . $openweathermap_apikey );
$parsed_json = json_decode($json_string);

// Fetch elements from json string
$wind_degrees = $parsed_json->{'wind'}->{'deg'};
$clouds = $parsed_json->{'clouds'}->{'all'};

// Compile url for posting to emoncms
$url = 'http://localhost/emoncms/input/post.json?node=2&json={clouds:' . $clouds . ',wind_degrees:' . $wind_degrees . '}&apikey=' . $emoncms_apikey;

// Post data to emoncms
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$contents = curl_exec ($ch);
curl_close ($ch);

?>

