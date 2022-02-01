<?
 error_reporting(-1);
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$ch = curl_init();
$site = "https://habr.com/";
$url = "https://www.google.com/search?q=site:azmy.ru";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0');
$content = curl_exec($ch);
var_dump($content);
if(!$content){
    echo 'Ошибка curl: ' . curl_error($ch);
  die;
}

curl_close($ch);

if(preg_match("/Результатов:\s*(примерно)?\s*([^(]+)/",$content,$matches))
  echo "Количество: ".$matches[2];
else
  echo "Не найдено";


  function get_proxy($url) 
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    # добавляем заголовков к нашему запросу. Чтоб смахивало на настоящих
    $headers = array
    (
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
    ); 
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers); 
 
    curl_setopt($ch, CURLOPT_HEADER, 0); // Отключаю в выводе header-ы false
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//возврат результата в качестве строки если true
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:34.0) Gecko/20100101 Firefox/34.0');
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.dat');//сохранить куки полсе закрытия
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.dat');
    
    //не проверять ssl - сертификат
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
    //не проверять хост ssl - сертификата
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        
    //разрешаем редирект
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    //  останавливаться после 10-ого редиректа
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        
    $ss=curl_exec($ch);//делаем запрос
   
    
    if($ss === false)
    {
        echo 'Ошибка curl: ' . curl_error($ch)."<br>";
    }
    else
    {
        echo 'Операция завершена без каких-либо ошибок';
    }
    curl_close($ch);//закрываем
    
    return $ss;
}
 
// echo get_proxy("https://www.google.com/search?q=site:azmy.ru");
// echo get_proxy("https://yandex.ru/search/?text=site:eddp.ru&lr=192");
echo get_proxy("https://a.pr-cy.ru/eddp.ru");