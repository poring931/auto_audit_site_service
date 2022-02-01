<?

/**
* Получение численного значения параметра Яндекс ИКС с картинки
*
* URI: https://a-panov.ru/massovaya-proverka-iks-skript-na-php/
* Version: 1.0
* Author: Andi Panov <a@a-panov.ru>
* Author URI: http://a-panov.ru/
* License: GPLv2
*/

class YandexIks
{
    private static $reference = [
        '..xxxxxx....xxxxxxxxx.xxxxxxxxxxxxx.......xxxx.......xxxxx.....xxxxxxxxxxxxxx.xxxxxxxx..',
        '..xx........xxx.......xxx........xxxxxxxxxxxxxxxxxxxxxx',
        '.........xxxx......xxxxx......xxxxx.....xxxxxx...xxxx.xxxx.xxxx..xxxxxxxx...x.xxxx.....x',
        'x........xxxx.......xxxx...x...xxxx...x...xxxx..xxx..xxxxxxxxxxxxxxxxxxxxxxxx......xxxx.',
        '......xx.......xxxx......xxxxx....xxxx..x...xxxx...x...xxxxxxxxxxxxxxxxxxxxxx.......x...',
        '..........xxxxxxx...xxxxxxxx...xxx...xx...xxx...xx...xxx...xxxxxxxx...xxxxxxx.....xxxx..',
        '....xxxxx....xxxxxxxxx.xxxxxx.xxxxxxxxx...xxxxx.xx...xxxx..xx...xxx...xxxxxxxx....xxxxx.',
        'x..........x.........xx.......xxxx....xxxxxxx..xxxxxx..xxxxxxx....xxxxx......xxx........',
        '......xxxx.xxxxxxxxxxxxxxxxxxxxxxxx..xxx..xxxx..xxx..xxxxxxxxx..xxxxxxxxxxxxx.xxxx.xxxx.',
        '.xxxxx.....xxxxxxx...xxxx.xxx...xxx...xx..xxxx...xx.xxxxxx..xxxxx.xxxxxxxxx...xxxxxxx...',
    ];
    
    /**
    * Получение значения ИКС для указанного домена
    *
    * Данный метод не должен приводить к бану по IP при слишком частых запросов,
    * не выводится капча.
    */
    public static function getValueFromImage($domain) {
        $yaurl = 'https://www.yandex.ru/cycounter?' . $domain;
        $img = @imagecreatefrompng($yaurl);
        
        return $img ? self::parseImg($img) : '-';
    }
    
    private static function parseImg(&$src_img) {
        // где могут размещаться данные по ИКС
        $iks_x = 26;
        $iks_y = 10;
        $iks_w = 56;
        $iks_h = 11;
        
        // сюда вырезается нужная часть изображения
        $dst_img = imagecreatetruecolor($iks_w, $iks_h);
        
        // нужна часть изображения, на которой могут быть цифры
        imagecopy($dst_img, $src_img, 0, 0, $iks_x, $iks_y, $iks_w, $iks_h);
        
        $arr = [];
        for ($i = 0; $i < $iks_w; ++$i) {
            $arr[$i] = '';
            for ($j = 0; $j < $iks_h; ++$j) {
                $arr[$i] .= 8882055 == imagecolorat($dst_img, $i, $j) ? '.' : 'x';
            }
        }
        
        // подчистить пустые ряды
        for ($i = 0; $i < $iks_w; ++$i) {
            if ('...........' == $arr[$i])  unset($arr[$i]);
        }
        
        $iks = '';
        $current_symbol = '';
        $current_len = 0;
        
        foreach ($arr as $v) {
            $current_symbol .= $v;
            $current_len += 11;
            
            if (88 == $current_len) { // все символы имеют ширину 8
                foreach (self::$reference as $num => $symb) {
                    if (similar_text($symb, $current_symbol) > 80) {
                        $iks .= $num;
                        break;
                    }
                }
                $current_symbol = '';
                $current_len = 0;
            } elseif (55 == $current_len) { // кроме 1 — у него ширина 5
                if (similar_text(self::$reference[1], $current_symbol) > 50) {
                    $iks .= 1;
                    $current_symbol = '';
                    $current_len = 0;
                }
            }
        }
        return $iks;
    }
}

header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once __DIR__ . '/phpQuery/phpQuery/phpQuery.php';
include_once __DIR__ . '/SimpleHtmlDom/simple_html_dom.php';

function vardump($arr, $var_dump = false)
{
    echo "<pre style='background: #222;color: #54ff00;padding: 20px;'>";
    if ($var_dump) {
        var_dump($arr);
    } else {
        print_r($arr);
    }
    echo "</pre>";
}

if ($_GET['url'] != '') {
    $url = $_GET['url'];

echo YandexIks::getValueFromImage($url);
    if (!YandexIks::getValueFromImage($url)){
        $iks = 'не удалось получить';
    } else {
        $iks = YandexIks::getValueFromImage($url);
    }
    echo '
            <script>array_audit.yandexiks = ' . $iks . '</script>
            ';


}
// if ($_GET['url'] != '') {
    // $url = $_GET['url'] . 'asdasdasd/';
//     $url = 'https://webmaster.yandex.ru/siteinfo/?host=lightup.su';


//         $curl = curl_init();
//         curl_setopt($curl, CURLOPT_URL, $url);
//         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
//         curl_setopt($curl, CURLOPT_HEADER, false);
//         curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate");
//         $str = curl_exec($curl);
//         curl_close($curl);

// vardump($str);

// }
