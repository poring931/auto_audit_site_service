<?
// error_reporting(-1);
// header('Content-Type: text/html; charset=utf-8');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// $apikey= 'AIzaSyC6ocJXkmRhvPbJ8P-ei7uXffTYTTYDW1s';
// $url_check = 'https://lightup.su';
// $ch = curl_init();
// $url = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=".$url_check."&key=".$apikey;
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_HEADER, 0);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0');
// $content = curl_exec($ch);


// curl_close($ch);
// var_dump(json_decode($content, true));


$category = '&category=performance';
$strategy = '&strategy=desktop';
$strategy = '&strategy=mobile';
$api_key  = '&key=AIzaSyC6ocJXkmRhvPbJ8P-ei7uXffTYTTYDW1s';

$new_url = 'https://lightup.su'.$category.$strategy.$api_key;

$url     = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url='.$new_url;

$ch      = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$data = curl_exec($ch);
curl_close($ch);

$decoded_data = json_decode($data, true);

$response = [];

if(isset($decoded_data['lighthouseResult'])) {
    $result = $decoded_data['lighthouseResult'];

    $response['requested_url'] = isset($result['requestedUrl']) ? $result['requestedUrl'] : '';

    $audits         = $result['audits'];

    $performance    = isset($result['categories']['performance']['score']) ? $result['categories']['performance']['score'] : 0;  //0.74
    $seo_audit_refs = isset($result['categories']['seo']['auditRefs']) ? $result['categories']['seo']['auditRefs'] : [];         //array

    $response["PC"]['page_score'] = $performance * 100;

    $encoded_screenshot = $audits['final-screenshot']['details']['data'];
    $response["PC"]['screenshot'] = str_replace(array('_','-'),array('/','+'), $encoded_screenshot);
    $response["PC"]["cumulative-layout-shift"] = $audits["cumulative-layout-shift"]["displayValue"];
    $response["PC"]["largest-contentful-paint"] = $audits["largest-contentful-paint"]["numericValue"] .' | ' . $audits["largest-contentful-paint"]["score"];
    $response["PC"]["total-blocking-time"] = $audits["total-blocking-time"]["score"];
    $response["PC"]["speed-index"] = $audits["speed-index"]["score"];//(https://web.dev/speed-index/
    


}


$category = '&category=performance&category=seo&category=best-practices';
$strategy = '&strategy=mobile';
$api_key  = '&key=AIzaSyC6ocJXkmRhvPbJ8P-ei7uXffTYTTYDW1s';

$new_url = 'https://lightup.su' . $category . $strategy . $api_key;

$url     = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=' . $new_url;

$ch      = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$data = curl_exec($ch);
curl_close($ch);

$decoded_data = json_decode($data, true);


if (isset($decoded_data['lighthouseResult'])) {
    $result = $decoded_data['lighthouseResult'];


    $audits         = $result['audits'];

    $performance    = isset($result['categories']['performance']['score']) ? $result['categories']['performance']['score'] : 0;  //0.74
    $seo_audit_refs = isset($result['categories']['seo']['auditRefs']) ? $result['categories']['seo']['auditRefs'] : [];         //array

    $response["mobile"]['page_score'] = $performance * 100;

    $encoded_screenshot = $audits['final-screenshot']['details']['data'];
    $response["mobile"]['screenshot'] = str_replace(array('_', '-'), array('/', '+'), $encoded_screenshot);
    $response["mobile"]["cumulative-layout-shift"] = $audits["cumulative-layout-shift"]["displayValue"];
    $response["mobile"]["largest-contentful-paint"] = $audits["largest-contentful-paint"]["numericValue"] . ' | ' . $audits["largest-contentful-paint"]["score"];
    $response["mobile"]["total-blocking-time"] = $audits["total-blocking-time"]["score"];
    $response["mobile"]["speed-index"] = $audits["speed-index"]["score"]; //(https://web.dev/speed-index/



}



// var_dump($response);
echo '<pre>';
//  var_dump($result);
 var_dump($response);

echo '</pre>';
