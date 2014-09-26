<?php

//http://www.wunderground.com/weather/api/d/documentation.html

$emoncms_apikey = 'xxxxx'; //2348798273487237489723847234
$wunderground_apikey = 'yyyyy'; // 3h287rhy23828
$myLatitude = '00000'; //52.00000
$myLontitude = '11111'; // 4.80000

// fetch current weather data from wunderground
$json_string = file_get_contents('http://api.wunderground.com/api/' . $wunderground_apikey . '/conditions/q/'. $myLatitude .',' . $myLontitude . '.json');
$parsed_json = json_decode($json_string);

//extract data segments from wunderground json data
$temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
$relative_humidity = $parsed_json->{'current_observation'}->{'relative_humidity'};
$pressure_mb = $parsed_json->{'current_observation'}->{'pressure_mb'};
$wind_kph = $parsed_json->{'current_observation'}->{'wind_kph'};
$dewpoint_c = $parsed_json->{'current_observation'}->{'dewpoint_c'};
$visibility_km = $parsed_json->{'current_observation'}->{'visibility_km'};
$precip_1hr_metric = trim($parsed_json->{'current_observation'}->{'precip_1hr_metric'});

// prepare url for posting data to emoncms
$url = 'http://localhost/emoncms/input/post.json?node=2&json={humidity:' . $relative_humidity . ',pressure:' . $pressure_mb . ',wind:' . $wind_kph . ',temp:' . $temp_c .',dewpoint:' . $dewpoint_c . ',visibility:' . $visibility_km . ',rain:' . $precip_1hr_metric . '}&apikey=' . $emoncms_apikey;
echo $url;
//push data to emoncms
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$contents = curl_exec ($ch);
curl_close ($ch);

?>

