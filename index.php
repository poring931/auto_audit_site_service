<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>тест аудита</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="/phpQuery__crawling/styles.css">
</head>

<body>
    <h1>Автоматический аудит</h1>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <section class="audit">
        <div class="container">
            <div class="row">
                <div class="audit__wrapper">
                    <div class="audit__list">
                        <div class="audit__item" id="redirect__https">
                            <div class="audit__item__title">
                                Перенаправление с http
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

            const url = 'https://xn--80aqcecq.xn--p1ai/'; // получим его потом ручками


            // функция постепенного появления дивов 


            // //скрипт получения инфы о домене
            // Поле paid указывает дату до которой оплачен домен. Сайт и почта на этом домене станут недоступны после этой даты, если он не будет оплачен.

            // Поле free указывает дату освобождения домена. Если она не указана регистратором, то она вычисляется как 31 день от даты оплаты (paid). Это не всегда верно для международных доменов, у них дата освобождения может варьироваться от 31 до 48 дней.

            // Поле upd указывает дату актуальности информации. Используйте параметро &reload для сброса кеща и запроса у регистратора. Максимальное время кеширования информации - 10 суток. Такой запрос может выполняться до 60 секунд.

            let list__audit__crawl__links = "";
            $.ajax({
                url: '/phpQuery__crawling/get__json_base.php',
                type: 'GET',
                dataType: 'json',
                data: {},
                success: function(data) {

                    array_audit = data

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
                    show___regular__func('page_with_short__description', 'Страницы с коротким Description < 130 символов')
                    show___regular__func('page_without_title', 'Страницы без Title')
                    show___regular__func('page_copies_title', 'Повторяющиеся Title')
                    show___regular__func('array_external__links', 'Наличие внешних ссылок') //возможно нужно переписать будет
                    page_title__length('page_title__length', 'Длины Title проверяемых страниц')
                    page__NoindexNofollow('page__NoindexNofollow', 'Страницы,закрытые от индексации')




                    show_state_func('mobile_view_port', 'Мобильная версия')
                    show_state_func('favicon', 'Наличие favicon')
                    show_state_func('schema_org', 'Наличие Schema.org')
                    show_state_func('yandex__metric', 'Наличие Яндекс метрики')
                    show___regular__func('array_external__links', 'Внешние ссылки')

                    //неправильно выводит + настроить вывод последних
                    words_on_main_page('words_on_main_page', 'Количество слов на главной')


                    $(".audit__list .external_script").eq(0).remove() //удаляем шаблонный элемент
                    $(".audit__list .audit__item").each(function(i) { //анимация появления всех блоков
                        $(this).fadeOut().fadeIn(500 * (i + 1));
                    });
                    // $(".audit__list .audit__item:eq(0)").show(300, function() {
                    //     $(this).next().show(900, arguments.callee);
                    // });
                },
                error: function(e) {
                    alert(e.message);
                }

            });



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

                $('#clone_me').clone().addClass(`${name}`).appendTo('.audit__list')
                // $("ul").appendTo('.page_without_h1 audit__item__notice')

                $(`.${name}`).find('.audit__item__title').text(text__title)

                if (array_audit[name].length) {
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
            $.each($('.audit__item:not(.external_script)'), function(indexInArray, valueOfElement) {
                const blockId = '#' + $(this).attr('id');
                const blockId_forPHP = $(this).attr('id');
                console.log(blockId)

                $(this).find('.audit__item__description').load("/phpQuery__crawling/components_for_front/" + $(this).attr('id') + ".php?url=" + url + "&blockID=" + blockId_forPHP + "", function(response, status, xhr) {
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




        });
    </script>



</body>

</html>