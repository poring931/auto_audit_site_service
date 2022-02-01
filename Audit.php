<?php

class Audit {
    function get_site_url($url) 
    {
        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($handle);

        $server_info = curl_getinfo($handle);
        curl_close($handle);
    //     var_dump($server_info["url"]);
    //     var_dump($server_info["redirect_url"]);

        if ($server_info["http_code"] == '0'){
                echo 'ответ от сервера 0';
                die();
        }

        if (!$server_info["redirect_url"] && $server_info["http_code"] == '200'){
        return $server_info["url"];
        } else {
        return $server_info["redirect_url"];
        }
    }
}