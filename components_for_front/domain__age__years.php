<?php

include './src/Phois/Whois/Whois.php';

if ($_GET['url'] != '') {
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

    //echo strpos($whois_answer,'paid-till');

    // echo substr($whois_answer,strpos($whois_answer,'paid-till'),strpos(substr($whois_answer,strpos($whois_answer,'paid-till'),45),'T'));
    // echo substr($whois_answer,strpos(substr($whois_answer,strpos($whois_answer,'paid-till'),45),'T'),45);
    // echo date("d.m.Y", strtotime(str_replace('created: ', '', substr($whois_answer, strpos($whois_answer, 'created'), strpos(substr($whois_answer, strpos($whois_answer, 'created'), 45), 'T')))));
    $date__registr =
    date("d.m.Y", strtotime(str_replace('created: ', '', substr($whois_answer, strpos($whois_answer, 'created'), strpos(substr($whois_answer, strpos($whois_answer, 'created'), 45), 'T')))));
    // echo '<br>';
    // var_dump($whois_answer);
    $curday = date('d.m.Y');
    // echo $curday;


    $d1 = strtotime($date__registr);
    $d2 = strtotime($curday);
    $left = $d2 - $d1;
    $left = round($left / (3600 * 24));
   echo $years = round($left / 365,1). ' Года';
    echo ' <script>array_audit.agedomain = "Возраст домена:' . $years = round($left / 365, 1) . ' Года"</script> ';
//     echo '<br>';
//     $month = fmod($years, 1);
//    echo round($month * 365 / 30,1);
 
}
