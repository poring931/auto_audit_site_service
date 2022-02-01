<?
// error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once __DIR__ . '/phpQuery/phpQuery/phpQuery.php';
// phpQuery::$debug = true;
include_once __DIR__ . '/get_header.php'; //фуннция получения заголовка ответа от сервера
include_once __DIR__ . '/get_server_code.php'; //функция получения кода сервера
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

// TODO: https://azmy.ru/services/obsluzhivanie/servisnoe-obsluzhivanie/  - проблема с этим файлом.выпадает Warning: file_get_contents(https://azmy.ru/services/obsluzhivanie/servisnoe-obsluzhivanie/): failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found in /home/s/seoins23/im-pulse33.ru/public_html/phpQuery__crawling/get__json.php on line 220. нужно проверять на это говно


    $get_url = 'https://lightup.su/'; // получаем урл через гет запрос
   $get_url = 'http://minivl4h.bget.ru/'; // получаем урл через гет запрос


if (isset($_POST['count__pages'])) {
    $get_count__pages = htmlspecialchars($_POST['count__pages']) + 1;
} else {
    $get_count__pages =30;
}


// $get_count__pages =100;
// echo '<br>';
// echo '<br>';
// echo '<br>';

// echo $get_url;

// echo '<br>';
// echo '<br>';
// echo '<br>';
// $get_url = 'https://eddp.ru/';
// $get_url = 'https://azmy.ru/';

function get_site_url($url)
{
    $handle = curl_init($url);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($handle);

    $server_info = curl_getinfo($handle);
    curl_close($handle);
    //     var_dump($server_info["url"]);
    //     var_dump($server_info["redirect_url"]);

    if ($server_info["http_code"] == '0') {
        echo 'ответ от сервера 0';
        die();
    }

    if (!$server_info["redirect_url"] && $server_info["http_code"] == '200') {
        return $server_info["url"];
    } else {
        return $server_info["redirect_url"];
    }
}


// echo $get_url = get_site_url($get_url);
$get_url = get_site_url($get_url);



// $get_url = 'https://xn--80aqcecq.xn--p1ai/'; // получаем урл через гет запрос
$get_url_404 = $get_url . 'sadasdsadasd/asdasdsad/'; //урл 404
$get_url_sitemapXML = $get_url . 'sitemap.xml'; //урл sitemap.xml
$get_url_robots = $get_url . 'robots.txt'; //урл robots.txt


$AUDIT_SITE = array(
    'url' => $get_url,
    'page_404' => $get_url . 'sadasdsadasd/asdasdsad/', //урл 404
    'page_sitemap' => $get_url . 'sitemap.xml', //урл 404
    'page_robots' => $get_url . 'robots.txt', //урл 404
    'crawl__links' => array(),
    'page_without_h1' => array(),
    'page_multiply_h1' => array(),
    'page_h1__title__is_iqaul' => array(), //h1 == title
    'page_copies_description' => array(),
    'page_without_description' => array(), //<130 символов
    'page_with_short__description' => array(),
    'page_with_long__description' => array(),
    'page_copies_title' => array(),
    'page_without_title' => array(),
    'page_title__length' => array(),
    'page__NoindexNofollow' => array(),
    'mobile_view_port' => '',
    'favicon' => '',
    'schema_org' => array(), //Анализ сайта на внедрение разметки Схема.орг
    'yandex__metric' => '',
    'google__metric' => '',
    'words_on_main_page' => '', //на главной странице
    'array_external__links' => array(), //на главной странице
    'array_without_canonical' => array(), //на главной странице
    'array_broken_links' => array(), 



);

$count_inter = 0;
$doc__inner_first_10__links = array();
$doc__inner_first_10__links__description = array();
$doc__inner_first_10__links__title = array();
// ссылки для проверки сайта
$url_crawlArray = [];

// грузим главную страницу
$doc = phpQuery::newDocument(file_get_contents($get_url)); //получаем главную страницу
// foreach ($doc->find('link[rel="canonical"]') as $element){
//   vardump(pq($element)->attr('href'));
// }
// vardump($doc);

// --------------------- поиск скриптов схемы орг, метркики  -----------------------------------------------------------------
foreach ($doc->find('script') as $script) {
    if (stripos(pq($script)->text(), 'yandex.ru/metrika') !== false) {
        $AUDIT_SITE['yandex__metric'] = 'true';
    }
    if (stripos(pq($script)->text(), 'google-analytics.com') !== false || stripos(pq($script)->text(), 'gtag') !== false) {
        $AUDIT_SITE['google__metric'] = 'true';
    }


    if (stripos($script->nodeValue, '@context') !== false) {//находим jsonld Разметку
        // vardump($script->nodeValue, true);
        if (stripos($script->nodeValue, '/schema.org') !== false) { //находим jsonld Разметку
            $AUDIT_SITE['schema_org']["is_set"] = 'true';
        }
        if (stripos($script->nodeValue, 'Organization') !== false) { //находим jsonld Разметку
            $AUDIT_SITE['schema_org']["Organization"] = 'true';
        }
        if (stripos($script->nodeValue, 'logo') !== false) { //находим jsonld Разметку
            $AUDIT_SITE['schema_org']["logo"] = 'true';
        }
        if (stripos($script->nodeValue, 'contactPoint') !== false) { //находим jsonld Разметку
            $AUDIT_SITE['schema_org']["contactPoint"] = 'true';
        }
        if (stripos($script->nodeValue, 'BreadcrumbList') !== false) { //находим jsonld Разметку
            $AUDIT_SITE['schema_org']["BreadcrumbList"] = 'true';
        }
        if (stripos($script->nodeValue, 'sameAs') !== false) { //соц сети
            $AUDIT_SITE['schema_org']["sameAs"] = 'true';
        }
        if (stripos($script->nodeValue, 'LocalBusiness') !== false) { //соц сети
            $AUDIT_SITE['schema_org']["LocalBusiness"] = 'true';
        }
        if (stripos($script->nodeValue, 'WebSite') !== false) { //соц сети
            $AUDIT_SITE['schema_org']["WebSite"] = 'true';
        }
    }
    
}


// var_dump($doc->find('*'));
// var_dump(pq($doc->find('html')));
// var_dump($doc->find('script'));
if ($AUDIT_SITE['schema_org'] != 'true') { //доп проверка, если нет в скриптах JSONld , то чекаем все обьекты страницы
    foreach ($doc->find('*') as $element) { //берем все ссылки из шаки, которые в себе держат урл домена. Чтоб потом по ним пробежаться
        if (stripos(pq($element)->attr("itemtype"), '/schema.org') !== false) {
            $AUDIT_SITE['schema_org']['is_set'] = 'true';
        }
        if (stripos(pq($element)->attr("itemtype"), '/schema.org/BreadcrumbList') !== false) {
            $AUDIT_SITE['schema_org']["BreadcrumbList"] = 'true';
        }
        if (stripos(pq($element)->attr("itemtype"), '/schema.org/WPFooter') !== false) {
            $AUDIT_SITE['schema_org']["WPFooter"] = 'true';
        }
        if (stripos(pq($element)->attr("itemtype"), '/schema.org/WPHeader') !== false) {
            $AUDIT_SITE['schema_org']["WPHeader"] = 'true';
        }
    }
}
// --------------------- поиск скриптов схемы орг, метркики  -----------------------------------------------------------------


// --------------------- количество слов на главной странице -----------------------------------------------------------------
$AUDIT_SITE['words_on_main_page'] = str_word_count(pq($doc->find('html'))->text());

// --------------------- количество слов на главной странице -----------------------------------------------------------------




// ---------------------поиск viewport for mobile -----------------------------------------------------------------
$entry = $doc->find('head meta[name="viewport"]');
$data['viewport'] = pq($entry)->attr('content');
if (substr_count($data['viewport'], 'width=device-width')) {
    $AUDIT_SITE['mobile_view_port'] = 'true';
} else {
    $AUDIT_SITE['mobile_view_port'] = 'false';
}
// ---------------------поиск viewport for mobile -----------------------------------------------------------------



// ---------------------поиск фавиконки -----------------------------------------------------------------
foreach ($doc->find('link') as $link) {
    if (stripos(pq($link)->attr("href"), 'favicon.ico') !== false or stripos(pq($link)->attr("href"), 'favicon') !== false) {
        $AUDIT_SITE['favicon'] = 'true';
        break;
    } else {
        $AUDIT_SITE['favicon'] = 'false';
    }
}
// ---------------------поиск фавиконки -----------------------------------------------------------------





// Собираем уникальные ссылки с сайта. Чтоб потом по ним бегать и собирать инфу.
$count__hrefs = 0;
foreach ($doc->find('header a') as $element) { //берем все ссылки из шаки, которые в себе держат урл домена. Чтоб потом по ним пробежаться
    // echo pq($element)->attr("href") . ' -  ';
    if (substr_count(pq($element)->attr("href"), $get_url)) {
        // echo pq($element)->attr("href") . '<br>';
        $url_crawlArray[] = pq($element)->attr("href");
        $count__hrefs++;
    } else {
        if (!stripos(pq($element)->attr("href"), '/') && !substr_count(pq($element)->attr("href"), '@') && !is_numeric(preg_replace('/[^0-9]/', '', pq($element)->attr("href")))) {
            $url_crawlArray[] = $get_url . substr(pq($element)->attr("href"), 1);
            $count__hrefs++;
        }
    }

    if ($count__hrefs > $get_count__pages) {
        break;
    }
}
foreach ($doc->find('body a') as $element) { //берем все ссылки из шаки, которые в себе держат урл домена. Чтоб потом по ним пробежаться
    // echo pq($element)->attr("href") . ' -  ';
    if (substr_count(pq($element)->attr("href"), $get_url)) {
        // echo pq($element)->attr("href") . '<br>';
        $url_crawlArray[] = pq($element)->attr("href");
        $count__hrefs++;
    } else {
        if (!stripos(pq($element)->attr("href"), '/') && !substr_count(pq($element)->attr("href"), '@') && !is_numeric(preg_replace('/[^0-9]/', '', pq($element)->attr("href")))) {
            $url_crawlArray[] = $get_url . substr(pq($element)->attr("href"), 1);
            $count__hrefs++;
        }
    }

    if ($count__hrefs > $get_count__pages) {
        break;
    }
}
// foreach($doc->find('footer a') as $element){ //берем все ссылки из шаки, которые в себе держат урл домена. Чтоб потом по ним пробежаться
//        $url_crawlArray[]= pq($element)->attr("href");
//        if (substr_count (pq($element)->attr("href"),$get_url)){

//              $url_crawlArray[]= pq($element)->attr("href");

//        }
// }

// echo '<pre>';
//                var_dump($url_crawlArray);
//        echo '</pre>';
if (is_array($url_crawlArray)) {
    $url_crawlArra = array_unique($url_crawlArray);
}
// echo '<pre>';
//               var_dump($url_crawlArra);
//        echo '</pre>';

$count_inter = 0;
phpQuery::unloadDocuments();
// try
//     {
foreach ($url_crawlArra as $key => $value) { //загружает каждую страницу, вошедшую в этот массив
    $count_inter++;
    $AUDIT_SITE['crawl__links'][] = $value;

    $handle = curl_init($value);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE );
    $response = curl_exec($handle);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    curl_close($handle);
    if ($httpCode == '404' || $httpCode ==  'no response'){
        $AUDIT_SITE['array_broken_links'][] = $value;
    }
    // vardump($httpCode);
    // -------------------------поиск H1 на первых 10 ссылках  НАЧАЛО-------------------------------------------------------------------
    // поиск H1 на первых 10 ссылках  НАЧАЛО
    $doc__inner_first_10__links['{$count_inter}'] = phpQuery::newDocument(@file_get_contents($value));

    


    $entry = $doc__inner_first_10__links['{$count_inter}']->find('h1');

    $data['h1'] = pq($entry)->html();

    // наполяем массив с H1
    if ($doc__inner_first_10__links['{$count_inter}']->find('h1')->length < 1) {
        $AUDIT_SITE['page_without_h1'][] .= $value;
    }
    if ($doc__inner_first_10__links['{$count_inter}']->find('h1')->length > 1) {
        $AUDIT_SITE['page_multiply_h1'][] .= $value;
    }
    // поиск H1 на первых 10 ссылках  КОНЕЦ


    // -------------------------Поиск внешних ссылок на первых 10 ссылках  НАЧАЛО-------------------------------------------------------------------
    foreach ($doc__inner_first_10__links['{$count_inter}']->find('a') as $links) {
        if (stripos(pq($links)->attr("href"), $get_url) === false  && stripos(pq($links)->attr("href"), preg_replace("#/$#", "", $get_url)) === false && substr_count(pq($links)->attr("href"), 'http') > 0) {

            if (!in_array(pq($links)->attr("href"), $AUDIT_SITE['array_external__links']) && !pq($links)->attr('rel')) {
                $AUDIT_SITE['array_external__links'][] = pq($links)->attr("href");
            }
        }
    }
    // -------------------------Поиск внешних ссылок на первых 10 ссылках  НАЧАЛО-------------------------------------------------------------------


    // -------------------------поиск CANONICAL НАЧАЛО-------------------------------------------------------------------

    if (count($doc__inner_first_10__links['{$count_inter}']->find('link[rel="canonical"]'))== 0){
        $AUDIT_SITE['array_without_canonical'][] .= $value;
    }

    // vardump($entry->find('head')->html());
    // vardump($doc__inner_first_10__links['{$count_inter}']->find('link[rel="canonical"]'));
    
    // $data['description'] = pq($entry)->attr('content');

    // $doc__inner_first_10__links__description[] = $data['description'];

    // if (mb_strlen($data['description']) < 70) {
    //     $AUDIT_SITE['array_without_canonical'][] .= mb_strlen($data['description']) . ',' . $value;
    // }
    // if (mb_strlen($data['description']) < 155) {
    //     $AUDIT_SITE['page_with_long__description'][] .= mb_strlen($data['description']) . ',' . $value;
    // }


    // // поиск DESCRIPTION на первых 10 ссылках  НАЧАЛО
    // if ($doc__inner_first_10__links['{$count_inter}']->find('head meta[name="description"]')->length < 1) {
    //     $AUDIT_SITE['page_without_description'][] .= $value;
    // }


    // -------------------------поиск CANONICAL КОНЕЦ-------------------------------------------------------------------





    // -------------------------поиск DESCRIPTION на первых 10 ссылках  НАЧАЛО-------------------------------------------------------------------

    $entry = $doc__inner_first_10__links['{$count_inter}']->find('head meta[name="description"]');
    $data['description'] = pq($entry)->attr('content');

    $doc__inner_first_10__links__description[$value] = $data['description'];

    if (mb_strlen($data['description']) < 70) {
        $AUDIT_SITE['page_with_short__description'][] .= mb_strlen($data['description']) . ',' . $value;
    }
    if (mb_strlen($data['description']) < 155) {
        $AUDIT_SITE['page_with_long__description'][] .= mb_strlen($data['description']) . ',' . $value;
    }


    // поиск DESCRIPTION на первых 10 ссылках  НАЧАЛО
    if ($doc__inner_first_10__links['{$count_inter}']->find('head meta[name="description"]')->length < 1) {
        $AUDIT_SITE['page_without_description'][] .= $value;
    }
    //часть кода находится см в поиске "продолженние для DESCRIption"
    // поиск DESCRIPTION на первых 10 ссылках  КОНЕЦ


    // ---------------------поиск TITLE на первых 10 ссылках  НАЧАЛО-----------------------------------------------------------------
    $entry = $doc__inner_first_10__links['{$count_inter}']->find('title');
    $data['title'] = pq($entry)->text();


    if ($data['title'] == $data['h1']) {
        $AUDIT_SITE['page_h1__title__is_iqaul'][] .= $value;
    }
    $AUDIT_SITE['page_title__length'][] .= mb_strlen($data['title']) . ',' . $value;
    $doc__inner_first_10__links__title[$value] = $data['title'];
    if ($doc__inner_first_10__links['{$count_inter}']->find('title')->length < 1) {
        $AUDIT_SITE['page_without_title'][] .= $value;
    }
    // поиск TITLE на первых 10 ссылках  КОНЕЦ



    // ---------------------поиск NOINDEX на первых 10 ссылках  НАЧАЛО-----------------------------------------------------------------

    $entry = $doc__inner_first_10__links['{$count_inter}']->find('head meta[name="robots"]');
    $data['robots'] = pq($entry)->attr('content');


    if (substr_count($data['robots'], 'noindex') && substr_count($data['robots'], 'nofollow')) {
        $AUDIT_SITE['page__NoindexNofollow'][] .= $value;
    }
    phpQuery::unloadDocuments();
    if ($count_inter > $get_count__pages) break; //проверяем 10 ссылок. Чтоб не перегружать
}
//    }
// catch (SomeException $e)
//     {
//    handle_exception();
//     }


//"продолженние для DESCRIption" НАЧАЛО
if (is_array($doc__inner_first_10__links__description)) {
    $duplicates = (array_diff_assoc($doc__inner_first_10__links__description, array_unique($doc__inner_first_10__links__description)));
}
// var_dump($duplicates);
if (!empty($duplicates)) {
    foreach ($duplicates as  $key=>$duble) {
        $AUDIT_SITE['page_copies_description'][$key] = $duble . ' - страница '. $key;
    }
} else {
    $AUDIT_SITE['page_copies_description'][] = '0';
}
// var_dump($AUDIT_SITE['page_copies_description']);
//"продолженние для DESCRIption" КОНЕЦ


//"продолженние для title" НАЧАЛО
if (is_array($doc__inner_first_10__links__title)) {
    $duplicates = (array_diff_assoc($doc__inner_first_10__links__title, array_unique($doc__inner_first_10__links__title)));
}
// var_dump($duplicates);
if (!empty($duplicates)) {

    foreach ($duplicates as  $key => $duble) {
        $AUDIT_SITE['page_copies_title'][$key] = $duble . ' - ' . $key;
    }
} else {
    $AUDIT_SITE['page_copies_title'][] = '';
}
//"продолженние для title" КОНЕЦ





// echo '<br>';
// echo ' общий массив сайта с метатегами. Потом его парсить надо на фронте';
// echo '<br>';

if (isset($_POST['url'])) {
    echo  json_encode($AUDIT_SITE);
} else {
    echo '<pre>';
    var_dump($AUDIT_SITE);
    echo '</pre>';
}
// echo '<pre>';
// var_dump($AUDIT_SITE);
// echo  json_encode($AUDIT_SITE);
// echo '</pre>';
