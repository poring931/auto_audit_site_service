<?
// $url = 'https://xn--80aqcecq.xn--p1ai/asdasdasdas/';
// print_r(get_headers($url, 1));

if(!function_exists('get_headers'))
{
    function get_headers($url,$format=0)
    {
        $url=parse_url($url);
        $end = "\r\n\r\n";
        $fp = fsockopen($url['host'], (empty($url['port'])?80:$url['port']), $errno, $errstr, 30);
        if ($fp)
        {
            $out  = "GET / HTTP/1.1\r\n";
            $out .= "Host: ".$url['host']."\r\n";
            $out .= "Connection: Close\r\n\r\n";
            $var  = '';
            fwrite($fp, $out);
            while (!feof($fp))
            {
                $var.=fgets($fp, 1280);
                if(strpos($var,$end))
                    break;
            }
            fclose($fp);

            $var=preg_replace("/\r\n\r\n.*\$/",'',$var);
            $var=explode("\r\n",$var);
            if($format)
            {
                foreach($var as $i)
                {
                    if(preg_match('/^([a-zA-Z -]+): +(.*)$/',$i,$parts))
                        $v[$parts[1]]=$parts[2];
                }
                return $v;
            }
            else
                return $var;
        }
    }
}


