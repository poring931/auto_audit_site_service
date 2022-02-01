<?
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once __DIR__ . '/phpQuery/phpQuery/phpQuery.php';
include_once __DIR__ . '/SimpleHtmlDom/simple_html_dom.php';


if ($_GET['url'] !=''){
    $url = $_GET['url'];

        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

        /* Get the HTML or whatever is linked in $url. */
        $response = curl_exec($handle);

        /* Check for 404 (file not found). */
        $time__server = curl_getinfo($handle, CURLINFO_STARTTRANSFER_TIME  );
        curl_close($handle);
        //    echo $time__server . $url;

        if ($time__server <'0.200'){
            echo $time__server .' c';
        echo ' <script>array_audit.firstbyte = "' . $time__server . ' c"</script> ';
            echo '<style>#'.$_GET['blockID'].'{background: #008000e0; color: white; } </style>';
        } else {
              echo $time__server .' c';
        echo ' <script>array_audit.firstbyte = "' .$time__server . ' c"</script> ';
            echo '<style>#'.$_GET['blockID'].'{background: red; color: black; } </style>';
        }

 
   
   
}