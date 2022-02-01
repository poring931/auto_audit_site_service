<?
// error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once __DIR__ . '/phpQuery/phpQuery/phpQuery.php';

include_once __DIR__ . '/get_header.php';//фуннция получения заголовка ответа от сервера
include_once __DIR__ . '/get_server_code.php';//функция получения кода сервера

$get_url = 'http://minivl4h.bget.ru/'; // получаем урл через гет запрос
// $get_url = 'https://xn--80aqcecq.xn--p1ai/'; // получаем урл через гет запрос
$get_url_404 = $get_url.'sadasdsadasd/asdasdsad/'; //урл 404
$get_url_sitemapXML = $get_url.'sitemap.xml'; //урл sitemap.xml
$get_url_robots = $get_url.'robots.txt'; //урл robots.txt


$AUDIT_SITE = array(
       'url'=> $get_url,
       'page_404'=>$get_url.'sadasdsadasd/asdasdsad/', //урл 404
       'page_sitemap'=>$get_url.'sitemap.xml', //урл 404
       'page_robots'=>$get_url.'robots.txt', //урл 404
       'crawl__links'=>array(),
       'page_without_h1'=>array(),
       'page_multiply_h1'=>array(),
       'page_h1__title__is_iqaul'=>array(),//h1 == title
       'page_copies_description'=>array(),
       'page_without_description'=>array(), //<130 символов
       'page_with_short__description'=>array(),
       'page_copies_title'=>array(),
       'page_without_title'=>array(),
       'page_title__length'=>array(),
       'page__NoindexNofollow'=>array(),
       'mobile_view_port'=>'',
       'favicon'=>'',
       'schema_org'=>'',//Анализ сайта на внедрение разметки Схема.орг
       'yandex__metric'=>'',
       'google__metric'=>'',
       'words_on_main_page'=>'',//на главной странице
       'array_external__links'=>array(),//на главной странице
      
      
);


// ссылки для проверки сайта
$url_crawlArray = [];

// грузим главную страницу
$doc = phpQuery::newDocument(file_get_contents($get_url));//получаем главную страницу








 // --------------------- поиск скриптов схемы орг, метркики  -----------------------------------------------------------------
foreach ($doc->find('script') as $script) {
       if (stripos(pq($script)->text(),'yandex.ru/metrika')!==false ){$AUDIT_SITE['yandex__metric'] = 'true';}
       if (stripos(pq($script)->text(),'google-analytics.com')!==false || stripos(pq($script)->text(),'gtag')!==false){$AUDIT_SITE['google__metric'] = 'true';}
       if (stripos(pq($script)->text(),'/schema.org')!==false ){$AUDIT_SITE['schema_org'] = 'true';}
  }
if ($AUDIT_SITE['schema_org'] != 'true'){ //доп проверка, если нет в скриптах JSONld , то чекаем все обьекты страницы
       foreach($doc->find('*') as $element){ //берем все ссылки из шаки, которые в себе держат урл домена. Чтоб потом по ним пробежаться
              if (stripos(pq($element)->attr("itemtype"),'/schema.org')!==false ){$AUDIT_SITE['schema_org'] = 'true';}
       }
}
 // --------------------- поиск скриптов схемы орг, метркики  -----------------------------------------------------------------


// --------------------- количество слов на главной странице -----------------------------------------------------------------
 $AUDIT_SITE['words_on_main_page'] = str_word_count(pq($doc->find('html'))->text());

 // --------------------- количество слов на главной странице -----------------------------------------------------------------




 // ---------------------поиск viewport for mobile -----------------------------------------------------------------
 $entry = $doc->find('head meta[name="viewport"]');
 $data['viewport'] = pq($entry)->attr('content');
 if (substr_count( $data['viewport'],'width=device-width') ){ $AUDIT_SITE['mobile_view_port'] = 'true'; } else { $AUDIT_SITE['mobile_view_port'] = 'false'; }
 // ---------------------поиск viewport for mobile -----------------------------------------------------------------



 // ---------------------поиск фавиконки -----------------------------------------------------------------
 foreach ($doc->find('link') as $link) {
      if (stripos( pq($link)->attr("href"),'favicon.ico')!== false or stripos( pq($link)->attr("href"),'favicon')!== false ){ $AUDIT_SITE['favicon'] = 'true'; break; } else { $AUDIT_SITE['favicon'] = 'false';}
 }
 // ---------------------поиск фавиконки -----------------------------------------------------------------





// перебор ссылок из шапки. Чтоб проверить несколько страниц на некоторые вещи
foreach($doc->find('header a') as $element){ //берем все ссылки из шаки, которые в себе держат урл домена. Чтоб потом по ним пробежаться
       if (substr_count (pq($element)->attr("href"),$get_url)){
              // echo pq($element)->attr("href") . '<br>';
             $url_crawlArray[]= pq($element)->attr("href");
             
       }
}
$url_crawlArra = array_unique($url_crawlArray);

// var_dump($url_crawlArra);

// $sitemapXML = phpQuery::newDocument(file_get_contents($get_url.'/sitemap.xml'));
// echo '<pre>';
// var_dump($sitemapXML);
// echo '</pre>';



echo '<br>';
$count_inter = 0;
$doc__inner_first_10__links = array();
$doc__inner_first_10__links__description;
$doc__inner_first_10__links__title;
foreach ($url_crawlArra as $key => $value) { //загружает каждую страницу, вошедшую в этот массив
       $count_inter++;
       $AUDIT_SITE['crawl__links'][]= $value;
       // echo "{$key} => {$value} ";

       // $doc_{$key} = phpQuery::newDocument(file_get_contents($value));

       // $entry_{$key} = $doc_{$key}->find('h1');
       // $data_{$key}['h1'] = pq($entry_{$key})->html();
       // echo  'H1: ' .$data_{$key}['h1'] . '<br>';

       // var_dump(pq($entry_{$key})->html());









       // -------------------------поиск H1 на первых 10 ссылках  НАЧАЛО-------------------------------------------------------------------
       // поиск H1 на первых 10 ссылках  НАЧАЛО
       $doc__inner_first_10__links['{$count_inter}'] = phpQuery::newDocument(file_get_contents($value));

       $entry = $doc__inner_first_10__links['{$count_inter}']->find('h1');
       
       $data['h1'] = pq($entry)->html();
         
       echo  'H1: ' .$data['h1'];

       echo '  ' .$doc__inner_first_10__links['{$count_inter}']->find('h1')->length  . '<br>';
       
       echo '<br>';

        // наполяем массив с H1
        if ($doc__inner_first_10__links['{$count_inter}']->find('h1')->length < 1){
              $AUDIT_SITE['page_without_h1'][] .=$value;
       } 
       if ($doc__inner_first_10__links['{$count_inter}']->find('h1')->length > 1){
              $AUDIT_SITE['page_multiply_h1'][] .= $value;
       }
       // поиск H1 на первых 10 ссылках  КОНЕЦ

// -------------------------Поиск внешних ссылок на первых 10 ссылках  НАЧАЛО-------------------------------------------------------------------
       foreach ($doc__inner_first_10__links['{$count_inter}']->find('a') as $links) {
              if (stripos(pq($links)->attr("href"),$get_url) === false  && stripos(pq($links)->attr("href"),preg_replace("#/$#", "", $get_url)) === false && substr_count(pq($links)->attr("href"),'http')>0){
                     echo pq($links)->attr("href").'<br/>';
                  
                     echo '<pre>';
                     var_dump(pq($links)->attr('rel'));
                     echo '</pre>';
                     if (!in_array(pq($links)->attr("href"),$AUDIT_SITE['array_external__links']) && !pq($links)->attr('rel')){
                            $AUDIT_SITE['array_external__links'][]= pq($links)->attr("href");
                     }
              }
       }
// -------------------------Поиск внешних ссылок на первых 10 ссылках  НАЧАЛО-------------------------------------------------------------------






       // -------------------------поиск DESCRIPTION на первых 10 ссылках  НАЧАЛО-------------------------------------------------------------------

       $entry = $doc__inner_first_10__links['{$count_inter}']->find('head meta[name="description"]');
       $data['description'] = pq($entry)->attr('content');
       echo $data['description'] . '<br>';
       $doc__inner_first_10__links__description[] = $data['description'];

       if (mb_strlen($data['description']) < 130){$AUDIT_SITE['page_with_short__description'][] .= $value;}

        // поиск DESCRIPTION на первых 10 ссылках  НАЧАЛО
       if ($doc__inner_first_10__links['{$count_inter}']->find('head meta[name="description"]')->length < 1){
              $AUDIT_SITE['page_without_description'][] .= $value;
       } 
       //часть кода находится см в поиске "продолженние для DESCRIption"
       // поиск DESCRIPTION на первых 10 ссылках  КОНЕЦ


       // ---------------------поиск TITLE на первых 10 ссылках  НАЧАЛО-----------------------------------------------------------------
       $entry = $doc__inner_first_10__links['{$count_inter}']->find('title');
       $data['title'] = pq($entry)->text();
       echo $data['title'] . '<br>';

       if ($data['title'] == $data['h1']){
              $AUDIT_SITE['page_h1__title__is_iqaul'][] .= $value;
       }
       $AUDIT_SITE['page_title__length'][] .= mb_strlen ($data['title']).','.$value;
       $doc__inner_first_10__links__title[] = $data['title'];
       if ($doc__inner_first_10__links['{$count_inter}']->find('title')->length < 1){
              $AUDIT_SITE['page_without_title'][] .= $value;
       } 
       // поиск TITLE на первых 10 ссылках  КОНЕЦ



       // ---------------------поиск NOINDEX на первых 10 ссылках  НАЧАЛО-----------------------------------------------------------------
 
       $entry = $doc__inner_first_10__links['{$count_inter}']->find('head meta[name="robots"]');
       $data['robots'] = pq($entry)->attr('content');
       echo $data['robots'] . '<br>';
       
       if (substr_count($data['robots'],'noindex') && substr_count($data['robots'],'nofollow')){
              $AUDIT_SITE['page__NoindexNofollow'][] .= $value;
       }


       // $doc__inner_first_10__links__title[] = $data['title'];
       // if ($doc__inner_first_10__links['{$count_inter}']->find('title')->length < 1){
       //        $AUDIT_SITE['page_without_title'][] .= $value;
       // } 
       // поиск NOINDEX на первых 10 ссылках  КОНЕЦ

      





    
       // if($doc_{$key}->find('h1')->length) {
       //        echo $doc_{$key}->find('h1')->get(0)->tagName;
       // }
       // if($doc_{$key}->find('h1')->length) {
       //        echo $doc_{$key}->find('h1')->get(0)->tagName;
       // }


       if ($count_inter > 9) break; //проверяем 10 ссылок. Чтоб не перегружать
}



//"продолженние для DESCRIption" НАЧАЛО

$duplicates = array_unique( array_diff_assoc( $doc__inner_first_10__links__description, array_unique( $doc__inner_first_10__links__description ) ) );
var_dump($duplicates);
if (!empty($duplicates)){
        //$AUDIT_SITE['page_copies_description'] ='true'; //есть дубль дескрипшена
       foreach ($duplicates as $duble){
              $AUDIT_SITE['page_copies_description'][] = $duble;
       }
} else {
       $AUDIT_SITE['page_copies_description'] ='';
}
//"продолженние для DESCRIption" КОНЕЦ


//"продолженние для title" НАЧАЛО
echo '<br>';echo '<br>';echo '<br>sfdsfsdfgsdgsdsdgdsgsdgsd';
$duplicates = array_unique( array_diff_assoc( $doc__inner_first_10__links__title, array_unique( $doc__inner_first_10__links__title ) ) );
var_dump($duplicates);echo '<br>';echo '<br>';
var_dump($doc__inner_first_10__links__title);
if (!empty($duplicates)){
       foreach ($duplicates as $duble){
              $AUDIT_SITE['page_copies_title'][] = $duble;
       }
       
} else {
       $AUDIT_SITE['page_copies_title'] ='';
}
//"продолженние для title" КОНЕЦ





echo '<br>';
echo ' общий массив сайта с метатегами. Потом его парсить надо на фронте';
echo '<br>';
echo '<pre>';
var_dump($AUDIT_SITE);
echo '</pre>';





// get_server_code($get_url_404);
// get_headers($get_url_404, 1);


// var_dump(get_headers($get_url_404, 1));    


$entry = $doc->find('meta[name="viewport"]');
$data['title'] = pq($entry)->text();
echo $data['title'] . '<br>';

$entry = $doc->find('head meta[name="keywords"]');
$data['keywords'] = pq($entry)->attr('content');
echo $data['keywords'] . '<br>';
 
$entry = $doc->find('head meta[name="description"]');
$data['description'] = pq($entry)->attr('content');
echo $data['description'] . '<br>';

$entry = $doc->find('h1');
$data['h1'] = pq($entry)->text();
echo  'H1: ' .$data['h1'] . '<br>';