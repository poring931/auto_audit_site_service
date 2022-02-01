<?
error_reporting(-1);
if ($_GET['url'] != '') {
header('Content-Type: text/html; charset=utf-8');

error_reporting(E_ALL);
ini_set('display_errors', 1);
$apikey= 'AIzaSyC6ocJXkmRhvPbJ8P-ei7uXffTYTTYDW1s';
$url_check = $_GET['url'];
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
$decoded_data = json_decode($content, true);


// echo '<pre>';
// var_dump($decoded_data);
// echo '</pre>';

$count_errors = 0;
$list_errors=array();
foreach ($decoded_data["messages"] as $error) {
    if ($error["type"] == 'error') {
        $list_errors[$count_errors] = $error["message"] . ' : <code>'. $error["extract"] . '</code>';
        $count_errors++;
        
    }
}

echo  $count_errors;
    echo ' <script>array_audit.w3org = "' . $count_errors . '"</script> ';
if ($count_errors == 0):
    echo 'Ошибок нет';
    echo '<style>#' . $_GET['blockID'] . '{background: #008000e0; color: white; } </style>';
else:
    echo '<div class="w3_org_errors_wrapper">';
        foreach ($list_errors as $error):
        $error_parts  = explode(":", $error);
        echo '<div class="w3_org_errors__item w3_org_errors__item-description">';
        echo $error_parts[0];
        echo '</div>';
        echo '<div class="w3_org_errors__item w3_org_errors__item-value">';
        echo $error_parts[1];
        echo '</div>';
        endforeach;
    echo '</div>';
    echo '<style>#' . $_GET['blockID'] . '{background: red; color: black; } </style>';
endif;



// echo '<pre>';
// var_dump($list_errors);
// echo '</pre>';

}