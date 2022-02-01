<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once __DIR__ . '/phpQuery/phpQuery/phpQuery.php';
include_once __DIR__ . '/SimpleHtmlDom/simple_html_dom.php';


    $url = 'http://minivl4h.bget.ru/robots.txt';

        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

        /* Get the HTML or whatever is linked in $url. */
        $response = curl_exec($handle);

        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        
        curl_close($handle);

        var_dump($response);

$cleanArrayRobots;
$isClosedFromRobots = false;

echo '<br>';
echo '<br>';
echo '<br>';
$listSearch = array('Disallow:', 'Disallow:  *', 'Disallow: *', 'Disallow: /', 'Disallow:  /', 'Disallow:   /', 'Disallow:   *');
foreach (explode(PHP_EOL ,$response) as  $value) {
    if (in_array(trim($value), $listSearch)){
        echo 'найдено: ' .$value;

        $isClosedFromRobots == true;
        break;   
    }

    $cleanArrayRobots[] =trim($value);
}

if ($isClosedFromRobots){
    echo 'сайт закрыт от инедксации';
}