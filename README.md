# Сервис автоматического аудита.

## Находится на стадии сбора информации. Так и не успел привести к красиовому виду. Точка входа - index__with__form.php
## Реализовывал в рабочее время в офисе. Из офиса уволился, проект будет доделывать другой человек

## Основные файлы сбора:
- get__json.php (сборка основного массива проверок через php query). Идет сбор первых 100 найденных ссылок на странице и прогон по ним.
- /components_for_front/* - далее идет сбор через эти компоненты
- после успешных проверок - идет запись в бд json_to_bd.php

![Image alt](https://github.com/poring931/auto_audit_site_service/raw/main/2022-02-01_17-33-31.png) 
![Image alt](https://github.com/poring931/auto_audit_site_service/raw/main/2022-02-01_17-34-06.png) 
![Image alt](https://github.com/poring931/auto_audit_site_service/raw/main/2022-02-01_17-33-58.png) 

## Данные обрабатываются в данный момент криво, так как в процессе было куча изменений. Но массив всех параметров собирается верно:
![Image alt](https://github.com/poring931/auto_audit_site_service/raw/main/2022-02-01_17-37-17.png) 
