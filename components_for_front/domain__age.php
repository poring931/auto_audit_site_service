<?php

include './src/Phois/Whois/Whois.php';

if ($_GET['url'] !=''){
    $url = $_GET['url'];

// $url='xn--80aqcecq.xn--p1ai';
    // Force URL to begin with "http://" or "https://" so 'parse_url' works
    $url = preg_replace('/^(?!https?:\/\/)(.*:\/\/)/i', 'http://', $url);
    $parts = parse_url($url);
    // var_dump($parts); // To see the parsed URL parts, uncomment this line
    $parts['host'];


    $sld = $parts['host'];
    // $sld = $url;

    $domain = new Phois\Whois\Whois($sld);

    $whois_answer = $domain->htmlInfo();
    // echo stristr($whois_answer,'paid-till');

    // echo strpos($whois_answer,'paid-till');
    // echo substr($whois_answer,strpos($whois_answer,'paid-till'),strpos(substr($whois_answer,strpos($whois_answer,'paid-till'),45),'T'));
    // echo substr($whois_answer,strpos(substr($whois_answer,strpos($whois_answer,'paid-till'),45),'T'),45);
    //echo str_replace('paid-till: ','',substr($whois_answer,strpos($whois_answer,'paid-till'),strpos(substr($whois_answer,strpos($whois_answer,'paid-till'),45),'T')));


   $age =  date("d.m.Y", strtotime(str_replace('paid-till: ','',substr($whois_answer,strpos($whois_answer,'paid-till'),strpos(substr($whois_answer,strpos($whois_answer,'paid-till'),45),'T')))));
   echo $age;
    echo ' <script>array_audit.domainendspay = "'. $age.'"</script> ';
 }