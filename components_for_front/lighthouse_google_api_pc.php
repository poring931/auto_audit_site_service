<?
header('Content-Type: text/html; charset=utf-8');

if ($_GET['url'] != '') {


    $check_url = $_GET['url'];

$category = '&category=performance';
$strategy = '&strategy=desktop';
$api_key  = '&key=AIzaSyDyyjB83Jr71JXzrtKaCUiwe4YntD6gQoY';

$new_url = $check_url . $category . $strategy . $api_key;

$url     = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . $new_url;



$ch      = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$data = curl_exec($ch);
curl_close($ch);

$decoded_data = json_decode($data, true);

$response = [];

if (isset($decoded_data['lighthouseResult'])) {
    $result = $decoded_data['lighthouseResult'];

    $response['requested_url'] = isset($result['requestedUrl']) ? $result['requestedUrl'] : '';

    $audits         = $result['audits'];

    $performance    = isset($result['categories']['performance']['score']) ? $result['categories']['performance']['score'] : 0;  //0.74
    $seo_audit_refs = isset($result['categories']['seo']['auditRefs']) ? $result['categories']['seo']['auditRefs'] : [];         //array

    $response["PC"]['page_score'] = $performance * 100;

    $encoded_screenshot = $audits['final-screenshot']['details']['data'];
    $response["PC"]['screenshot'] = str_replace(array('_', '-'), array('/', '+'), $encoded_screenshot);
    $response["PC"]["cumulative-layout-shift"] = $audits["cumulative-layout-shift"]["displayValue"];
    $response["PC"]["largest-contentful-paint"] = $audits["largest-contentful-paint"]["numericValue"] . 'мс | ' . $audits["largest-contentful-paint"]["score"];
    $response["PC"]["total-blocking-time"] = $audits["total-blocking-time"]["score"];
    $response["PC"]["speed-index"] = $audits["speed-index"]["score"]; //(https://web.dev/speed-index/



}
// var_dump($result);

echo '<br>';
echo '<img src="'. $response["PC"]["screenshot"].'" />';
echo '<br>';
echo 'Скорость ПК : '. $response["PC"]["page_score"];
    echo ' <script>array_audit.googlepc = "' . $response["PC"]["page_score"] . '"</script> ';
    echo ' <script>array_audit.imagepc = "' . $response["PC"]["screenshot"] . '"</script> ';
echo '<br>';
echo 'Совокупное смещение макета (CLS) баллы: ' . $response["PC"]["cumulative-layout-shift"];
echo '<br>';
echo 'Совокупное смещение макета (LCP) : ' . $response["PC"]["largest-contentful-paint"];
echo '<br>';
echo 'FID (задержка после первого ввода)  (FID) : ' . $result["audits"]["max-potential-fid"]["numericValue"] . 'мс|' . $result["audits"]["max-potential-fid"];
echo '<br>';
echo 'Размер страницы : ' . $result["audits"]["total-byte-weight"]["displayValue"];

}