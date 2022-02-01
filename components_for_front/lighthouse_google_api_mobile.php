<?


if ($_GET['url'] != '') {


    $check_url = $_GET['url'];

$category = '&category=performance';
$api_key  = '&key=AIzaSyC6ocJXkmRhvPbJ8P-ei7uXffTYTTYDW1s';
$strategy = '&strategy=mobile';


$new_url = $check_url  . $category . $strategy . $api_key;

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



    echo '<br>';
    echo '<img src="' . $response["mobile"]["screenshot"] . '" />';
    echo '<br>';
    echo 'Скорость ПК : ' . $response["mobile"]["page_score"];
    echo ' <script>array_audit.googlemobile = "' . $response["mobile"]["page_score"] . '"</script> ';
    echo ' <script>array_audit.imagemb = "' . $response["mobile"]["screenshot"] . '"</script> ';
echo '<br>';
echo 'Совокупное смещение макета (CLS) баллы: ' . $response["mobile"]["cumulative-layout-shift"];
echo '<br>';
echo 'Совокупное смещение макета (LCP) : ' . $response["mobile"]["largest-contentful-paint"];
echo '<br>';
echo 'FID (задержка после первого ввода)  (FID) : ' . $result["audits"]["max-potential-fid"]["numericValue"] . 'мс|' . $result["audits"]["max-potential-fid"];



}