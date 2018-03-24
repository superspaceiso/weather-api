<?php

require_once "api.php";

$city = "Darlington";
$country = "UK";
$language = "en";
$units = "metric";

$api_url = "http://api.openweathermap.org/data/2.5/forecast/daily?q=".$city.",".$country."&lang=".$language."&units=".$units."&cnt=5&appid=".$api_key;

// Open connection
$ch = curl_init();
// Set the url, number of GET vars, GET data
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json')
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Execute request
$result = curl_exec($ch);
// Close connection
curl_close($ch);
// get the result and parse to JSON
$result_arr = json_decode($result, true);

//print_r($result_arr);

echo "<div id=\"location\">",$city,", ",$country,"</div>";

foreach ($result_arr["list"] as $day => $value) {
    $date = date("D, j M",$value["dt"]);
    $temp_max = round($value["temp"]["max"],1,PHP_ROUND_HALF_UP);
    $temp_min = round($value["temp"]["min"],1,PHP_ROUND_HALF_UP);
    $weather_type = $value["weather"][0]["main"];
    $weather_description = ucwords($value["weather"][0]["description"]);

    echo "<div class=\"day\">";
    echo "<div class=\"dayheader\">",$date,"</div>";
    switch ($weather_type) {
      case "Clear":
        echo "<div class=\"weather\">","<i class=\"wi wi-day-sunny scale\"></i>","</div>";
        break;
      case "Rain":
        echo "<div class=\"weather\">","<i class=\"wi wi-rain scale\"></i>","</div>";
        break;
      case "Clouds":
        echo "<div class=\"weather\">","<i class=\"wi wi-cloudy scale\"></i>","</div>";
        break;
      case "Mist":
        echo "<div class=\"weather\">","<i class=\"wi wi-fog scale\"></i>","</div>";
        break;
      case "Drizzle":
        echo "<div class=\"weather\">","<i class=\"wi wi-rain-mix scale\"></i>","</div>";
        break;
      case "Snow":
        echo "<div class=\"weather\">","<i class=\"wi wi-snow scale\"></i>","</div>";
        break;
    }

    echo "<div class=\"weatherdescription\">",$weather_description,"</div>";
    echo "<div class=\"dayhigh\">",$temp_max,"&deg;","</div>";
    echo "<div class=\"daylow\">",$temp_min,"&deg;","</div>";
    echo "</div>";
}

?>
