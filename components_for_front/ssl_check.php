<?php


if ($_GET['url'] !=''){
if($fp = tmpfile())
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$_GET['url']);
    curl_setopt($ch, CURLOPT_STDERR, $fp);
    curl_setopt($ch, CURLOPT_CERTINFO, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    // curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
 $result = curl_exec($ch);
    curl_errno($ch)==0 or die("Error:".curl_errno($ch)." ".curl_error($ch));
    fseek($fp, 0);//rewind
    $str='';
    while(strlen($str.=fread($fp,8192))==8192);
    // echo $str;
    // echo '<pre>';
    //  var_dump($str);
    // echo '</pre>';
   
    fclose($fp);
 
    if ( substr_count($str,'successfully set certificate verify locations')){
        echo 'SSl-сертификат установлен <br>';
        echo 'Дата окончания: '.str_replace('*  expire date:','',substr($str,strpos($str,'*  expire date:'),strpos(substr($str,strpos($str,'*  expire date:'),45),'GMT'))) ;

        echo ' <script>array_audit.ssl = "SSl-сертификат есть. Дата окончания: ' . str_replace('*  expire date:', '', substr($str, strpos($str, '*  expire date:'), strpos(substr($str, strpos($str, '*  expire date:'), 45), 'GMT'))).'"</script> ';
        echo '<style>#'.$_GET['blockID'].'{background: #008000e0; color: white; } </style>';
    } else {
        echo 'SSl-сертификат не установлен';
            echo ' <script>array_audit.ssl = "SSl-сертификат не установлен"</script> ';
        echo '<style>#'.$_GET['blockID'].'{background: red; color: black; } </style>';
    }
}


}

?>