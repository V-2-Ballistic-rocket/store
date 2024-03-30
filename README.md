--------------------------------------------------- ОГЛАВЛЕНИЕ ---------------------------------------------------------

    1. Установка
    2. Использование
        2.1. CRUD методы над сущностью user
        2.2. CRUD методы над сущностью product
    3. Используемые технологии
    4. Послесловие

------------------------------------------------ 1. УСТАНОВКА ----------------------------------------------------------

        Для удобства установки в проекте используется Docker.
    Для проверки работы проекта используйте Postman или консоль.
    Так же для проверки результата работы внутри бд вам может понадобиться PgAdmin или dbeaver
        база данных  postgres
        хост        'localhost'
        имя бд      'app'
        USER        'postgres'
        PASSWORD    'postgres'

        Чтобы запустить контейнер и подтянуть библиотеки composer,
    можно воспользоваться Makefile.

    Для установки и запуска введите
        make install-n-start

    Если нужна только установка:
        make install

    Если нужен только запуск контейнеров через makefile:
        make start
    Если нужен только запуск контейнеров без makefile
        docker-compose up -d

    Для остановки контейнера через makefile:
        make stop
    Для остановки контейнера без makefile:
        docker-compose stop

------------------------------------------------ 2. ИСПОЛЬЗОВАНИЕ ------------------------------------------------------

    Для использования убедитесь что docker-контейнеры запущены.

    Если у вас в процессе использования вылезит ошибка типа:
        Warning: fopen(../var/log/Logs.csv): Failed to open stream: Permission denied in /app/src/Core/Logger.php on line 15
    то выдайте права на чтение и изменение для папки /var/log/,
    или выключите логгер исправив константу LOGGER_ON на false в файле conf/settings.php

    2.1. CRUD методы над сущностью user:

        Немного о валидности данных пользователя:
            Всего 3 поля:
                inn - длина до 12 сиволов (только цифры)
                kpp - длина до 9 (только цифры)
                login - длина до 30 символов

        Для добавления пользователя в бд введите в терминале:
            curl --location 'http://localhost/user' \
            --header 'Content-Type: application/json' \
            --data '{
                "login":"some_login",
                "inn":123456789,
                "kpp":213456678
            }'
        Или в postman:
            POST http://localhost/user
            Body->raw:
                {
                    "login":"some_login",
                    "inn":123456789,
                    "kpp":213456678
                }

        В качестве ответа проект вернёт id нового пользователя.


        Для вывода данных о пользователе по id в терминале:
            curl --location 'http://localhost/user/1'
        В postman:
            GET http://localhost/user/1
        Проет вернет данные о пользователе с id = 1


        Для изменения данных о пользователе по id в терминале:
            curl --location --request PUT 'http://localhost/user/4' \
            --header 'Content-Type: application/json' \
            --data '{
                "login":"4_login",
                "inn":123456789,
                "kpp":213456678
            }'
        Или в postman:
            PUT http://localhost/user/4
            Body->raw:
               {
                   "login":"4_login",
                   "inn":123456789,
                   "kpp":213456678
               }
        Пользователь с id = 4 будет изменён.
        Важно: чтобы изменить пользователя с id = 4 нужно сначала создать этого пользователя


        Для удаления пользователя в терминале:
            curl --location --request DELETE 'http://localhost/user/4'
        В postman:
            DELETE http://localhost/user/4
        Пользователь с id = 4 сотрется из бд


        Пользователи с id = 1 и id = 3 нужны для тестирования
        и создаюся каждый раз при любой операции проекта


    2.2. CRUD методы над сущностью product:

            Немного о валидности данных продукта:
            Всего 4 поля:
                product_code - формат: от 1 до 3 цифр, затем "-", затем минимум 1 цифра.
                Всего в строке должно быть до 10 символов включая "-"

                price - формат: от 1 до 15 цифр, затем ",", затем 2 цифры

                product_name - длина от 5 до 64 символов

                description  - длина до 300 символов


            Для добавления Товара в бд введите в терминале:
                curl --location 'http://localhost/product' \
                --header 'Content-Type: application/json' \
                --data '{
                    "product_code":"12-345",
                    "price":"999,99",
                    "product_name":"product_name",
                    "description":"description"
                }'
            Или в postman:
                POST http://localhost/product
                Body->raw:
                    {
                        "product_code":"12-345",
                        "price":"999,99",
                        "product_name":"product_name",
                        "description":"description"
                    }

            В качестве ответа проект вернёт id нового Товара.


            Для вывода данных о Товаре по id в терминале:
                curl --location 'http://localhost/product/1'
            В postman:
                GET http://localhost/product/1
            Проет вернет данные о Товаре с id = 1


            Для изменения данных о Товаре по id в терминале:
                curl --location --request PUT 'http://localhost/product/4' \
                --header 'Content-Type: application/json' \
                --data '{
                    "product_code":"12-345",
                    "price":"999,99",
                    "product_name":"product_name_4",
                    "description":"description_4"
                }'
            Или в postman:
                PUT http://localhost/product/4
                Body->raw:
                   {
                       "product_code":"12-345",
                       "price":"999,99",
                       "product_name":"product_name_4",
                       "description":"description_4"
                   }
            Товар с id = 4 будет изменён.
            Важно: чтобы изменить Товар с id = 4 нужно сначала создать этот Товар


            Для удаления Товара в терминале:
                curl --location --request DELETE 'http://localhost/product/4'
            В postman:
                DELETE http://localhost/product/4
            Товар с id = 4 сотрется из бд


            Товары с id = 1 и id = 3 нужны для тестирования
            и создаюся каждый раз при любой операции проекта

------------------------------------------------ 3. СТЕК ТЕХНОЛОГИЙ ----------------------------------------------------

    Docker
    Nginx
    Postgres 13
    PHP 8.1
    codeception 5.0

------------------------------------------------ 4. ПОСЛЕСЛОВИЕ --------------------------------------------------------

    Не все тесты работают,
    и очень сомнительно что у меня руки дойдут это сделать,
    поэтому на тесты можете не смотреть.
    Но если очень хочется, то внутри контейнера запустите
        php vendor/bin/codecept run Unit

    Спасибо за внимание!
