<?
function get_server_code($url) {
    $handle = curl_init($url);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

    /* Get the HTML or whatever is linked in $url. */
    $response = curl_exec($handle);

    /* Check for 404 (file not found). */
    $httpCode = curl_getinfo($handle);
    curl_close($handle);
        var_dump($httpCode);
    /* If the document has loaded successfully without any redirection or error */
   
}

get_server_code('broilclub.ru/');