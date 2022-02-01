<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once __DIR__ . '/phpQuery/phpQuery/phpQuery.php';
include_once __DIR__ . '/SimpleHtmlDom/simple_html_dom.php';


if ($_GET['url'] != '') {
    $url = $_GET['url'] . 'asdasdasd/';


    $handle = curl_init($url);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

    /* Get the HTML or whatever is linked in $url. */
    $response = curl_exec($handle);

    /* Check for 404 (file not found). */
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    curl_close($handle);
    //    echo $httpCode . $url;
    if ($httpCode == 404) {
        echo 'есть (код - ' . $httpCode . ' ' . $url . ')';
    echo ' <script>array_audit.notfoundpage = "есть (код - ' . $httpCode . ' ' . $url . ')"</script> ';
        echo '<style>#' . $_GET['blockID'] . '{background: #008000e0; color: white; } </style>';
    } else {
        echo 'Код ответа страницы :'. $url .' : ' . $httpCode;

        echo ' <script>array_audit.notfoundpage = "Код ответа страницы :' . $url . ' : ' . $httpCode.'"</script> ';
        echo '<style>#' . $_GET['blockID'] . '{background: red; color: black; } </style>';
    }
}
