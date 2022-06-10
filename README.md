Имеется обычный http access_log файл. Требуется написать PHP скрипт, обрабатывающий этот лог и выдающий информацию о нём в json виде. Требуемые данные: количество хитов/просмотров, количество уникальных url, объем трафика, количество строк всего, количество запросов от поисковиков, коды ответов. <br>
Запуск: php processing_logs.php --file=./access.log <br>
Результат: {"hits":16,"urls":5,"traffic":212816,"all_line":16,"search_requests":{"Google":2,"Mail":0,"Rambler":0,"Yandex":0},"answer_codes":{"200":14,"301":2}}