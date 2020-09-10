# Настройка окружения
1) Настройка базы данных:
    - создать `docker-compose.override.yml` в `app/`
    - Содержимое файла:
        ```
        services:
            db:
                environment:
                    POSTGRES_USER: %user_name%
                    POSTGRES_PASSWORD: %user_pass%
                    POSTGRES_DB: %database_name%
        ```
    - В `app/.env`:
        ``` 
            DB_CONNECTION=pgsql
            DB_HOST=db
            DB_DATABASE=%database_name%
            DB_USERNAME=%user_name%
            DB_PASSWORD=%user_pass%
        ```
2) `docker-compose up -d --build` - собираем образ и создаём окружение
3) `./bin/artisan key:generate` - генерируем ключ приложения
4) Настройка отправки почты:
    - В файле `app/.env`:
        ```
        MAIL_FROM_ADDRESS=%Адрес отправителя%
        NOTIFICATOR_MAX=%Максимальное кол-во сообщений для одного пользователя, если 0, то бесконечно%
        NOTIFICATOR_ATTEMPTS=%Максимальное количество попыток в промежуток указанный ниже%
        NOTIFICATOR_DELAY=%Задержка перед повторной отправкой%
        ```
    - В файле `app/confing/notificator.php`:
        ```
        // Список получателей
        'recipients' => [
            'goranton98@gmail.com',
        ]
        ```