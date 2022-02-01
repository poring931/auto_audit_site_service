<?
error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');

error_reporting(E_ALL);
ini_set('display_errors', 1);
$apikey= 'AIzaSyC6ocJXkmRhvPbJ8P-ei7uXffTYTTYDW1s';
$url_check = 'https://lightup.su';
$ch = curl_init();

$url = "https://validator.w3.org/nu/?doc=".$url_check.'&out=json';

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HEADER, 'Content-Type: text/html; charset=utf-8');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");
$content = curl_exec($ch);

curl_close($ch);

// echo '<pre>';
// $decoded_data = json_decode($content, true);
// var_dump($decoded_data);
// echo '</pre>';
 $count_errors=0;
foreach ($decoded_data["messages"] as $key => $value) {
    if ($value == 'error'){
        $count_errors++;
    }
}

echo  $count_errors;