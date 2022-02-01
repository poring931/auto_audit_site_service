<?php
header('Content-Type: text/plain');

$url = "https://www.google.com/search?q=lightup.su";
$html = file_get_contents($url);
if (FALSE === $html) {
    throw new Exception(sprintf('Failed to open HTTP URL "%s".', $url));
}

$arr = explode('<div class="sd" id="resultStats">', $html);
$bottom = $arr[1];
$middle = explode('</div>', $bottom);
echo $middle[0];



var_dump($html);

https://developers.google.com/custom-search/