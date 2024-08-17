# MoreWay
Система, которая позволяет планировать и создавать маршруты для путешествия по достопримечательностям Кузбасса с элементами геймификации.

## Backend и Frontend
Серверная часть: 

[![Server](https://skillicons.dev/icons?i=laravel,php,mysql,redis,rabbitmq,docker)](https://github.com/Yondu715/MoreWay_Backend)

Клиентская часть: 

[![Client](https://skillicons.dev/icons?i=flutter,dart)](https://github.com/whitefooox/moreway-app)

# Backend
## Стек
- PHP (v8.2) - Язык программирования
- Laravel (v10.10.0) - Backend фреймворк
- Voyager (v1.7) - Админ-панель
- Cboden/Ratchet (v0.4.4) - Websockets
- Bunny/Bunny (v0.5.5) - Lib for AMQP Broker (RatchetMQ)
- Predis (v2.2) - Lib for Redis
- Tymon/jwt-auth (v2.0) - Пакет для JWT
- Docker Engine (v25.0.3) - Контейнерная платформа
- MySql (v8.3) - СУБД

## Алиасы
В корне проекта есть файл Makefile, в котором содержатся алиасы для часто используемых команд
![изображение](https://github.com/Yondu715/pastebin/assets/116293533/9f506c3e-96c5-433b-9030-3993d1460469)

Для их вызова необходимо выполнить
```sh
make {название_команды}
```

## Установка

### Docker
```sh
docker-compose up --build -d
```

### Laravel
Необходимо зайти в контейнер app
```sh
docker-compose exec app bash
```

И установить зависимости
```sh
composer install
```

Далее создаем файл .env и описываем окружение по примеру .env.example

Главное указать следующие параметры:

База данных
```sh
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=123
```
Вебсокеты
```sh
WS_HOST=localhost
WS_PORT=8877
WS_ADDRESS=0.0.0.0
```
Redis и RabbitMq
```
REDIS_HOST=redis
REDIS_PASSWORD=123
REDIS_PORT=6379
REDIS_CLIENT=predis

RABBITMQ_HOST=rabbitmq
RABBITMQ_PORT=5672
RABBITMQ_USERNAME=web
RABBITMQ_PASSWORD=123
RABBITMQ_VHOST=rabbitmq
```

Генерируем ключ
```sh
php artisan key:generate
```

Поднимаем миграции
```sh
php artisan migrate
```

Инициализируем voyager
```sh
php artisan voyager:install
```
Создаем ключ для jwt
```sh
php artian jwt:secret
```

Запускаем сиды
```sh
php artisan db:seed
```
