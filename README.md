Загрузка Fixtures в базу данных:
------------
    symfony console doctrine:fixtures:load 

Запуск сервера
------------  
    symfony server:start --port 8080 -d  

Просмотр логов Messenger
-----------
    symfony console messenger:consume async -vv