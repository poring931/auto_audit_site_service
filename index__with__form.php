<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
<?


// seoins23_resaudi
// 7bw%u0nD
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>тест аудита</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="/phpQuery__crawling/styles__withForm.css">
</head>

<body>

    <h1>Автоматический аудит</h1>
    <div class="other_audits">

        Прошлые успешные проверки:
        <?php
        header('Content-Type: text/html; charset=utf-8');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        require_once 'db_config.php';


        function whatsRow($key, $value)
        {

            switch ($key) {
                case "url":
                    return "Урл: " . $value;
                    break;
                case "date":
                    return "Дата проверки: " . date('H:i:s Y-m-d', $value);
                    break;
                case "w3org":
                    return "Количество ошибок HTML: " . $value;
                    break;
                case "firstbyte":
                    return "Время первого байта: " . $value;
                    break;
                case "page_h1__title__is_iqaul":
                    return "Страницы с дублирующими Н1 и тайтл " . $value;
                    break;
                case "gtmetrix":
                    return "Оценка скорости по gtmetrix: " . $value;
                    break;
                case "googlepc":
                    return "Оценка скорости ПК по googlepagespeed: " . $value;
                    break;
                case "googlemobile":
                    return "Оценка скорости Мобильки по googlepagespeed: " . $value;
                    break;
                case "imagemb":
                    return "<img src=$value>";
                    break;
                case "imagepc":
                    return "<img src=$value>";
                    break;
            }
        }
        try {
            $pdo = new PDO($dsn, $user, $pass, $opt);
            $stmt = $pdo->query('SELECT url, date, w3org, firstbyte, page_h1__title__is_iqaul, gtmetrix, googlepc, googlemobile, imagemb, imagepc FROM audit');
            // $pdo->exec($stmt);
            // var_dump(count($row = $pdo->fetch()));
            // var_dump($stmt->rowCount());
            echo $stmt->rowCount();
            $successAudits = [];
            while ($row = $stmt->fetch()) {
                echo "<details>
                    <summary> {$row['url']}</summary>";
                echo "<ul>";
                foreach ($row as $key => $value) {
                    if (!empty($value)) {
                        $successAudits[$row['url']][] = htmlspecialchars($value);
                        // echo "<li> {$value} </li>";
                        echo "<li>" . whatsRow($key, $value) . "</li>";
                    }
                    // var_dump($key);
                }
                echo "</ul> 
                    </details>";
                // 
            }
        } catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
        ?>
    </div>
    <div class="form__audit__wrapper">
        <div class="tool__tip">

        </div>
        <form action="/phpQuery__crawling/get__json.php" class="form__audit" method="POST">
            <div class="p-floating-container">
                <input id="url__input" name="url" placeholder="Введите ваш сайт\домен" />
                <label>Ваш сайт</label>
            </div>

            <div class="radio-container">
                <div class="form-item radio-btn">
                    <input type="radio" name="count__pages" id="radio1" checked value="20">
                    <label for="radio1">20</label>
                </div>
                <div class="form-item radio-btn">
                    <input type="radio" name="count__pages" id="radio2" value="40">
                    <label for="radio2">40</label>
                </div>
                <div class="form-item radio-btn">
                    <input type="radio" name="count__pages" id="radio3" value="60">
                    <label for="radio3">60</label>
                </div>
                <div class="form-item radio-btn">
                    <input type="radio" name="count__pages" id="radio4" value="80">
                    <label for="radio4">80</label>
                </div>
                <div class="form-item radio-btn">
                    <input type="radio" name="count__pages" id="radio5" value="100">
                    <label for="radio5">100</label>
                </div>
            </div>

            <button class="form__audit__submit" type="submit">
                Получить аудит
            </button>

        </form>
    </div>

    <section class="audit">
        <div class="container">
            <div class="row">

                <div class="audit__wrapper" style="display:none">
                    <div class="audit__list">

                        <div class="audit__item" id="redirect__https">
                            <div class="audit__item__title">
                                Перенаправление с http
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>

                        <div class="audit__item" id="yandex_IKS">
                            <div class="audit__item__title">
                                индекс качества сайта (ИКС)
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>
                        <div class="audit__item" id="redirect__indexPHP">
                            <div class="audit__item__title">
                                Перенаправление с index.php
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>

                        <div class="audit__item" id="redirect__www">
                            <div class="audit__item__title">
                                Перенаправление с www
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>
                        <div class="audit__item" id="isset__robots">
                            <div class="audit__item__title">
                                Наличие файла robots.txt
                            </div>
                            <div class="audit__item__description">
                            </div>
                        </div>
                        <div class="audit__item" id="isset__sitemapXML">
                            <div class="audit__item__title">
                                Наличие файла sitemap.xml
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>
                        <div class="audit__item" id="server_firstbyte">
                            <div class="audit__item__title">
                                Время отклика сервера
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>
                        <div class="audit__item" id="domain__age">
                            <div class="audit__item__title">
                                Дата окончания оплаты домена
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>
                        <div class="audit__item" id="page_404">
                            <div class="audit__item__title">
                                Код несуществующей страницы (работоспособность 404)
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>
                        <div class="audit__item" id="domain__age__years">
                            <div class="audit__item__title">
                                Возраст домена
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>
                        <div class="audit__item" id="ssl_check">
                            <div class="audit__item__title">
                                SSL
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>

                        <div class="audit__item external_script" id="clone_me">
                            <div class="audit__item__title">

                            </div>
                            <div class="audit__item__description"> </div>
                            <div class="audit__item__notice">

                            </div>
                        </div>
                        <div class="audit__item wait_it" id="gtmetrix_api">
                            <div class="audit__item__title">
                                gtMetrix
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>
                        <div class="audit__item" id="w3_org_validator">
                            <div class="audit__item__title">
                                Проверка ошибок HTML
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>
                        <div class="audit__item wait_it" id="lighthouse_google_api_mobile">
                            <div class="audit__item__title">
                                Быстродействие мобильной версии
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>
                        <div class="audit__item wait_it" id="lighthouse_google_api_pc">
                            <div class="audit__item__title">
                                Быстродействие ПК
                            </div>
                            <div class="audit__item__description"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
    <script>
        let array_audit; //получаем результирующий массив аудита
        $(document).ready(function() {
            //    $('#is_404 .audit__item__description').load( "/phpQuery__crawling/get_server_code.php",function( response, status, xhr ) {
            //        console.log(response)
            //         if ( status == "error" ) {
            //         var msg = "Sorry but there was an error: ";
            //         $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
            //         }
            //     });

            // ажакс запрос. Передаем ID мастера. Получаем отзывы 4-5 баллов

            // const url = 'https://xn--80aqcecq.xn--p1ai/'; // получим его потом ручками


            // функция постепенного появления дивов


            // //скрипт получения инфы о домене
            // Поле paid указывает дату до которой оплачен домен. Сайт и почта на этом домене станут недоступны после этой даты, если он не будет оплачен.

            // Поле free указывает дату освобождения домена. Если она не указана регистратором, то она вычисляется как 31 день от даты оплаты (paid). Это не всегда верно для международных доменов, у них дата освобождения может варьироваться от 31 до 48 дней.

            // Поле upd указывает дату актуальности информации. Используйте параметро &reload для сброса кеща и запроса у регистратора. Максимальное время кеширования информации - 10 суток. Такой запрос может выполняться до 60 секунд.

            let list__audit__crawl__links = "";

            // function isURL(str) {
            //     var pattern = new RegExp('^((ft|htt)ps?:\\/\\/)?' + // protocol
            //         '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name and extension
            //         '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
            //         '(\\:\\d+)?' + // port
            //         '(\\/[-a-z\\d%@_.~+&:]*)*' + // path
            //         '(\\?[;&a-z\\d%@_.,~+&:=-]*)?' + // query string
            //         '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
            //     return pattern.test(str);
            // }
            function isURL(str) {
                var pattern = new RegExp('^((ft|htt)ps?:\\/\\/)?' + // protocol
                    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name and extension
                    '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
                    '(\\:\\d+)?' + // port
                    '(\\/[-a-z\\d%@_.~+&:]*)*' + // path
                    '(\\?[;&a-z\\d%@_.,~+&:=-]*)?' + // query string
                    '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
                return pattern.test(str);
            }

            function checkURL(url) {
                var regURLrf = /^(?:(?:https?|ftp|telnet):\/\/(?:[а-я0-9_-]{1,32}(?::[а-я0-9_-]{1,32})?@)?)?(?:(?:[а-я0-9-]{1,128}\.)+(?:рф)|(?! 0)(?:(?! 0[^.]|255)[ 0-9]{1,3}\.){3}(?! 0|255)[ 0-9]{1,3})(?:\/[a-zа-я0-9.,_@%&?+=\~\/-]*)?(?:#[^ \'\"&<>]*)?$/i;
                var regUUU = /(?:(?:https?|ftp):\/\/|\b(?:[a-z\d]+\.))(?:(?:[^\s()<>]+|\((?:[^\s()<>]+|(?:\([^\s()<>]+\)))?\))+(?:\((?:[^\s()<>]+|(?:\(?:[^\s()<>]+\)))?\)|[^\s`!()\[\]{};:'".,<>?«»“”‘’]))?/ig;
                var regURL = /^(?:(?:https?|ftp|telnet):\/\/(?:[a-z0-9_-]{1,32}(?::[a-z0-9_-]{1,32})?@)?)?(?:(?:[a-z0-9-]{1,128}\.)+(?:com|net|org|mil|edu|arpa|ru|gov|biz|info|aero|inc|name|[a-z]{2})|(?! 0)(?:(?! 0[^.]|255)[ 0-9]{1,3}\.){3}(?! 0|255)[ 0-9]{1,3})(?:\/[a-zа-я0-9.,_@%&?+=\~\/-]*)?(?:#[^ \'\"&<>]*)?$/i;
                return regURLrf.test(url) || regURL.test(url) || regUUU.test(url);
            }

            $('.form__audit').on('submit', function(e) {
                e.preventDefault();


                if (checkURL($('#url__input').val()) && $('#url__input').val() != '') {
                    $('#url__input').val($('#url__input').val().replace(/(^\w+:|^)\/\//, ''));
                    $('.form__audit__wrapper').fadeOut()
                    $('.audit__wrapper').fadeIn()


                    var m_method = $(this).attr('method');
                    var m_action = $(this).attr('action');
                    var m_data = $(this).serialize();

                    $.ajax({
                        type: m_method,
                        url: m_action,
                        data: m_data,
                        dataType: 'JSON',
                        resetForm: 'true',
                        success: function(data) {

                            array_audit = data
                            console.log(array_audit)
                            $.each(array_audit.crawl__links, function(key, value) {
                                list__audit__crawl__links += "<li>" + value + "</li>";
                            });
                            list__audit__crawl__links = '<span>Проверенные ссылки</span><br><ol>' + list__audit__crawl__links + '</ol>'; // формируем массив проверенных урлов, для вывода в некоторых блоках
                            // page_without_h1()
                            show___regular__func('page_multiply_h1', 'Страницы с дублирующими H1')
                            show___regular__func('page_without_h1', 'Страницы без Н1')
                            show___regular__func('page_h1__title__is_iqaul', 'Страницы с одинаковым Title и Н1')
                            show___regular__func('page_without_description', 'Страницы без meta description')
                            show___regular__func('page_copies_description', 'Повторяющиеся Description')
                            show___regular__func('page_with_short__description', 'Страницы с коротким Description < 70 символов')
                            show___regular__func('page_with_long__description', 'Страницы с коротким Description > 150 символов')
                            show___regular__func('page_without_title', 'Страницы без Title')
                            show___regular__func('page_copies_title', 'Повторяющиеся Title')
                            show___regular__func('array_broken_links', 'Битые ссылки на главной')
                            show___regular__func('array_external__links', 'Наличие внешних ссылок') //возможно нужно переписать будет
                            page_title__length('page_title__length', 'Длины Title проверяемых страниц')
                            page__NoindexNofollow('page__NoindexNofollow', 'Страницы,закрытые от индексации')


                            show_state_func('mobile_view_port', 'Мобильная версия')
                            show_state_func('favicon', 'Наличие favicon')
                            show_schema_func('schema_org', 'Наличие Schema.org')
                            show_canonical_func('array_without_canonical', 'Отсутствует каноникал НА: ')
                            show_state_func('yandex__metric', 'Наличие Яндекс метрики')
                            show_state_func('google__metric', 'Наличие Гугл метрики')


                            //неправильно выводит + настроить вывод последних
                            words_on_main_page('words_on_main_page', 'Количество слов на главной')


                            $(".audit__list .external_script").eq(0).remove() //удаляем шаблонный элемент
                            // $(".audit__list .audit__item").each(function(i) { //анимация появления всех блоков
                            //     $(this).fadeOut().fadeIn(500 * (i + 1));
                            // });
                            // $(".audit__list .audit__item").each(function(i) { //анимация появления всех блоков
                            //     $(this).fadeOut().fadeIn(500 * (i + 1));
                            // });
                            $(".audit__list .audit__item:eq(0)").show(300, function() {
                                $(this).next().show(300, arguments.callee);
                            });

                            $('.audit__wrapper').css({
                                'width': 'auto',
                                'background': 'unset',
                                'position': 'static',
                                'transform': 'none'
                            })



                            let count_success_audit__item = 0;
                            console.log(count_success_audit__item + ' =? ' + $('.audit__item:not(.external_script)').length);
                            $.each($('.audit__item:not(.external_script)'), function(indexInArray, valueOfElement) {
                                const blockId = '#' + $(this).attr('id');
                                const blockId_forPHP = $(this).attr('id');
                                console.log(blockId)

                                $(this).find('.audit__item__description').load("/phpQuery__crawling/components_for_front/" + $(this).attr('id') + ".php?url=" + array_audit.url + "&blockID=" + blockId_forPHP + "", function(response, status, xhr) {


                                    //запись в БД после последнего успешного скрипта.
                                    count_success_audit__item = 1 + count_success_audit__item;
                                    console.log(count_success_audit__item + ' =? ' + $('.audit__item:not(.external_script)').length); //не учитываю 3 аудита, которые самые долгие - гт метрих и гугл пейдж спид. Нужно сделать так,чтоб значение получалось после апдейтом
                                    console.log($('.audit__item:not(.external_script)').length == count_success_audit__item);
                                    if ($('.audit__item:not(.external_script)').length == count_success_audit__item) { //запускаем запись в бд текущих результатов (без внешних апишных проверок)
                                        $.ajax({
                                            url: '/phpQuery__crawling/json_to_bd.php',
                                            type: 'POST',
                                            data: array_audit,
                                            dataType: 'json',
                                            async: true,
                                            success: function(data) {

                                                console.log(data);
                                            },
                                            complete: function(jqXHR) {
                                                if (jqXHR.readyState === 4) {
                                                    console.log(jqXHR);
                                                    array_audit.indexitem = jqXHR.responseJSON //получаем ID последней записи
                                                }
                                            }
                                        });
                                    }






                                    if (status == "success") {
                                        $(blockId).children('.audit__item__description').css('background', 'unset')
                                        console.log(status)
                                    }
                                    if (status == "error") {
                                        var msg = "Sorry but there was an error: ";
                                        $(this).find('.audit__item__description').html(msg + xhr.status + " " + xhr.statusText);
                                    }
                                });
                            });



                            //часть для внешних адитов через апи. Они очень долгие
                            // $.each($('.audit__item.wait_it'), function(indexInArray, valueOfElement) {
                            //     const blockId = '#' + $(this).attr('id');
                            //     const blockId_forPHP = $(this).attr('id');
                            //     $(this).find('.audit__item__description').load("/phpQuery__crawling/components_for_front/" + $(this).attr('id') + ".php?url=" + array_audit.url + "&blockID=" + blockId_forPHP + "", function(response, status, xhr) {

                            //             $.ajax({
                            //                 url: '/phpQuery__crawling/json_to_bd_ext_scripts.php',
                            //                 type: 'POST',
                            //                 data: array_audit,
                            //                 dataType: 'json',
                            //                 async: true,
                            //                 success: function(data) {
                            //                     console.log(data);
                            //                 },
                            //                 complete: function(jqXHR) {
                            //                     if(jqXHR.readyState === 4) {
                            //                         console.log(jqXHR);
                            //                         array_audit.indexitem = jqXHR.responseJSON //получаем ID последней записи
                            //                     }   
                            //                 }        
                            //             });

                            //     });
                            // });


                        },
                        error: function(data) {
                            alert('Возникла ошибка' + data.responseText);
                            // alert(data);
                            console.log(data)
                            console.log(data.responseText)
                            console.log(e)
                        }

                    });
                } else { //невалидный урл
                    console.log('неправильный урл')
                    alert('Неправильный URL')
                }


            })





            // START Фунции отображения каждого блока, полученного из скрипта большого общего
            function page_without_h1() { //проверка на Н1 - отсутствие

                $('#clone_me').clone().addClass(`${arguments.callee.name}`).appendTo('.audit__list')
                // $("ul").appendTo('.page_without_h1 audit__item__notice')

                $(`.${arguments.callee.name}`).find('.audit__item__title').text(array_audit.page_without_h1)
                $(`.${arguments.callee.name}`).find('.audit__item__title').text('Страницы без Н1 ТЕСТОВАЯ ФУНЦИЯ')

                if (array_audit.page_without_h1.length) {

                    paint_me(`${arguments.callee.name}`, 1)

                    $(`.${arguments.callee.name}`).find('.audit__item__description').text('Есть')
                    //перебираем массив. Выводим страницы в нотис
                    var list = "";

                    $.each(array_audit.page_without_h1, function(key, value) {
                        list += "<li>" + value + "</li>";
                    });
                    $(`.${arguments.callee.name}`).find('.audit__item__notice').append('<ol>' + list + '</ol>');
                } else {
                    //выводим, что все ок, проверенные ссылки
                    $(`.${arguments.callee.name}`).find('.audit__item__description').text('Нет');
                    $(`.${arguments.callee.name}`).find('.audit__item__notice').append(list__audit__crawl__links);
                }
            }

            function show___regular__func(name, text__title) { //функция вывода похожих скриптов
                console.log(name)
                $('#clone_me').clone().addClass(`${name}`).appendTo('.audit__list')
                // $("ul").appendTo('.page_without_h1 audit__item__notice')

                $(`.${name}`).find('.audit__item__title').text(text__title)
                console.log(array_audit[name])
                // if (array_audit[name].length && array_audit.page_copies_description != "" && array_audit[name] != '') {
                if (array_audit[name].length || array_audit[name] instanceof Object) {
                    $(`.${name}`).find('.audit__item__description').text('Есть')
                    paint_me(`${name}`, 0)

                    //перебираем массив. Выводим страницы в нотис
                    var list = "";

                    $.each(array_audit[name], function(key, value) {
                        list += "<li>" + value + "</li>";
                    });
                    $(`.${name}`).find('.audit__item__notice').append('<ol>' + list + '</ol>');
                } else {
                    paint_me(`${name}`, 1)
                    //выводим, что все ок, проверенные ссылки
                    $(`.${name}`).find('.audit__item__description').text('Нет');
                    $(`.${name}`).find('.audit__item__notice').append(list__audit__crawl__links);
                }
            }

            function page_title__length(name, text__title) {

                $('#clone_me').clone().addClass(`${name}`).appendTo('.audit__list')
                // $("ul").appendTo('.page_without_h1 audit__item__notice')

                $(`.${name}`).find('.audit__item__title').text(text__title)

                if (array_audit[name].length) {

                    paint_me(`${name}`, 1)


                    //перебираем массив. Выводим страницы в нотис
                    var list = "";


                    $.each(array_audit[name], function(key, value) {
                        new_value = value.split(',');
                        if (new_value[0] < 35) {

                            paint_me(`${name}`, 0)

                            $(`.${name}`).find('.audit__item__description').text('Есть короткие')
                            list += "<li style='color:white!important; font-weight:bold'>" + "Количество символов " + new_value[0] + " - на странице " + new_value[1] + "</li>";
                        } else {
                            list += "<li>" + "Количество символов " + new_value[0] + " - на странице " + new_value[1] + "</li>";
                        }

                    });
                    $(`.${name}`).find('.audit__item__notice').append('<ol>' + list + '</ol>');
                } else {
                    paint_me(`${name}`, 1)
                    //выводим, что все ок, проверенные ссылки
                    $(`.${name}`).find('.audit__item__description').text('Нет');
                    $(`.${name}`).find('.audit__item__notice').append(list__audit__crawl__links);
                }
            }

            function page__NoindexNofollow(name, text__title) {

                $('#clone_me').clone().addClass(`${name}`).appendTo('.audit__list')
                // $("ul").appendTo('.page_without_h1 audit__item__notice')

                $(`.${name}`).find('.audit__item__title').text(text__title)

                if (array_audit[name].length) {

                    paint_me(`${name}`, 0)

                    if (array_audit[name].length == 10) {
                        $(`.${name}`).find('.audit__item__description').text(array_audit[name].length + ' из 10. Возможно проблемы с индексацией')
                    } else {
                        $(`.${name}`).find('.audit__item__description').text(array_audit[name].length + ' из 10')
                    }

                    //перебираем массив. Выводим страницы в нотис
                    var list = "";

                    $.each(array_audit[name], function(key, value) {
                        list += "<li>" + value + "</li>";
                    });
                    $(`.${name}`).find('.audit__item__notice').append('<ol>' + list + '</ol>');
                } else {
                    paint_me(`${name}`, 1)
                    //выводим, что все ок, проверенные ссылки
                    $(`.${name}`).find('.audit__item__description').text('Нет');
                    $(`.${name}`).find('.audit__item__notice').append(list__audit__crawl__links);
                }
            }

            function show_state_func(name, text__title) { //функция вывода ДА НЕТ
                $('#clone_me').clone().remove('.audit__item__notice').addClass(`${name}`).addClass('without_hover').appendTo('.audit__list')
                // $("ul").appendTo('.page_without_h1 audit__item__notice')
                $(`.${name}`).find('.audit__item__title').text(text__title)
                if (array_audit[name] == 'false') {
                    $(`.${name}`).find('.audit__item__description').text('Нет')
                    paint_me(`${name}`, 0)
                    //перебираем массив. Выводим страницы в нотис
                } else {
                    paint_me(`${name}`, 1)
                    //выводим, что все ок, проверенные ссылки
                    $(`.${name}`).find('.audit__item__description').text('Есть');
                    // $(`.${name}`).find('.audit__item__notice').append(list__audit__crawl__links);
                }
            }

            function show_schema_func(name, text__title) { //функция вывода ДА НЕТ
                $('#clone_me').clone().addClass(`${name}`).appendTo('.audit__list')
                // $("ul").appendTo('.page_without_h1 audit__item__notice')
                $(`.${name}`).find('.audit__item__title').text(text__title)
                paint_me(`${name}`, 1)
                //выводим, что все ок, проверенные ссылки
                $(`.${name}`).find('.audit__item__description').text('Есть');

                $(`.${arguments.callee.name}`).find('.audit__item__description').text('Есть')
                //перебираем массив. Выводим страницы в нотис
                var list = "";

                $.each(array_audit.schema_org, function(key, value) {
                    list += "<li>" + key + ' : ' + value + "</li>";
                });
                $(`.${name}`).find('.audit__item__notice').append('<ol>' + list + '</ol>');

            }

            function show_canonical_func(name, text__title) { //функция вывода ДА НЕТ
                $('#clone_me').clone().addClass(`${name}`).appendTo('.audit__list')
                // $("ul").appendTo('.page_without_h1 audit__item__notice')
                $(`.${name}`).find('.audit__item__title').text(text__title)
                paint_me(`${name}`, 1)
                //выводим, что все ок, проверенные ссылки
                $(`.${name}`).find('.audit__item__description').text('Есть');

                $(`.${arguments.callee.name}`).find('.audit__item__description').text('Есть')
                //перебираем массив. Выводим страницы в нотис
                var list = "";

                $.each(array_audit.array_without_canonical, function(key, value) {
                    list += "<li>" + key + ' : ' + value + "</li>";
                });
                $(`.${name}`).find('.audit__item__notice').append('<ol>' + list + '</ol>');

            }

            function words_on_main_page(name, text__title) { //функция вывода ДА НЕТ
                $('#clone_me').clone().remove('.audit__item__notice').addClass(`${name}`).addClass('without_hover').appendTo('.audit__list')
                // $("ul").appendTo('.page_without_h1 audit__item__notice')
                $(`.${name}`).find('.audit__item__title').text(text__title)

                $(`.${name}`).find('.audit__item__description').text(array_audit[name])
                paint_me(`${name}`, 1)
                //перебираем массив. Выводим страницы в нотис

            }


            function paint_me(name, state) { //функция перекрашивания текста и блока
                $(`.${name}`).css('background', state ? "#008000e0" : "red")
                $(`.${name} *`).css('color', state ? "white" : "black")
            }

            // функция уменьшения нотиса
            $('body').on('mouseenter', '.external_script', function() {
                    $(this).find('.audit__item__notice').css('height', $(this).find('.audit__item__notice ol').height() + 20)
                })
                .on('mouseleave', '.external_script', function() {
                    $(this).find('.audit__item__notice').css('height', 0)
                })
            // END Фунции отображения каждого блока:


            //Фунции отрисовки локальных скриптов
            // $.each($('.audit__item:not(.external_script)'), function(indexInArray, valueOfElement) {
            //     const blockId = '#' + $(this).attr('id');
            //     const blockId_forPHP = $(this).attr('id');
            //     console.log(blockId)

            //     $(this).find('.audit__item__description').load("/phpQuery__crawling/components_for_front/" + $(this).attr('id') + ".php?url=" + url + "&blockID=" + blockId_forPHP + "", function(response, status, xhr) {
            //         if (status == "success") {
            //             $(blockId).children('.audit__item__description').css('background', 'unset')
            //             console.log(status)
            //         }
            //         if (status == "error") {
            //             var msg = "Sorry but there was an error: ";
            //             $(this).find('.audit__item__description').html(msg + xhr.status + " " + xhr.statusText);
            //         }
            //     });
            // });




        });
    </script>



</body>

</html>