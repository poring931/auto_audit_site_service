<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

function getpageindexed($name){
$weburl="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=site:".$name."&filter=0";
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $weburl);
curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt ($ch, CURLOPT_HEADER, 0);
curl_setopt ($ch, CURLOPT_NOBODY, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$json = curl_exec($ch);
curl_close($ch);
$data=json_decode($json,true);
if($data['responseStatus']==200)
return $data['responseData']['cursor']['resultCount'];
else
return false;
}

$name="https://broilclub.ru/"; //your domain name
echo getpageindexed($name); //get indexed page

$url = "https://www.google.com/search?q=https://broilclub.ru/";
$html = file_get_contents($url);
if (FALSE === $html) {
    throw new Exception(sprintf('Failed to open HTTP URL "%s".', $url));
}
var_dump($html)
$arr = explode('<div class="sd" id="resultStats">', $html);
$bottom = $arr[1];
$middle = explode('</div>', $bottom);
echo $middle[0];


?>