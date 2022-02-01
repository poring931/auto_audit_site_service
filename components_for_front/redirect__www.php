<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once __DIR__ . '/phpQuery/phpQuery/phpQuery.php';
include_once __DIR__ . '/SimpleHtmlDom/simple_html_dom.php';


if ($_GET['url'] !=''){
    $url = $_GET['url'];
    if (substr_count($url,'https')){ // првоеряем что ввели: http\https
        $url = str_replace('https://','https://www.',$url);  //меняем гет урл на нттп и смотрим ответ сервера

        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

        /* Get the HTML or whatever is linked in $url. */
        $response = curl_exec($handle);

        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);
        //    echo $httpCode . $url;
        if ($httpCode== '301'){
            echo 'есть (код - ' .$httpCode . ' ' . $url . ')';
            echo ' <script>array_audit.redirectwww = "есть (код - ' . $httpCode . ' ' . $url . ')"</script> ';
            echo '<style>#'.$_GET['blockID'].'{background: #008000e0; color: white; } </style>';
        } else {
            echo 'редирект отсутствует';
            echo ' <script>array_audit.redirectwww = "редирект отсутствует"</script> ';
            echo '<style>#'.$_GET['blockID'].'{background: red; color: black; } </style>';
        }

    } else {
         $url = str_replace('http://','http://www.',$url);  //меняем гет урл на нттп и смотрим ответ сервера

        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

        /* Get the HTML or whatever is linked in $url. */
        $response = curl_exec($handle);

        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);
        //    echo $httpCode . $url;
        if ($httpCode== '301'){
            echo 'есть (код - ' .$httpCode . ' ' . $url . ')';
            echo ' <script>array_audit.redirectwww = "есть (код - ' . $httpCode . ' ' . $url . ')"</script> ';
            echo '<style>#'.$_GET['blockID'].'{background: #008000e0; color: white; } </style>';
        } else {
            echo 'редирект отсутствует';
            echo ' <script>array_audit.redirectwww = "редирект отсутствует"</script> ';
            echo '<style>#'.$_GET['blockID'].'{background: red; color: black; } </style>';
        }
    }
   
}