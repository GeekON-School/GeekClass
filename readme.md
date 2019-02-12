# GeekClass
Платформа для организации онлайн-курсов

## Как запустить

```bash
#переименовать .env.example в .env
composer install # у вас должен быть установлен composer
php artisan key:generate # у вас должен установлен php
docker-compose up
docker inspect database-geekclass
# находим свойство IPAddress и вставляем его значение (без кавычек) в .env
docker-compose exec php bash
apt update
apt install libpq-dev
docker-php-ext-install pdo_pgsql
php artisan migrate
```
## Доступ к сайту
Сайт будет доступен по адресу `localhost:8050`
Adminer будет доступен по адресу `localhost:8080`

### Регистрация учителя
Создайте новое поле в таблице `providers` с помощью `Adminer` и введите в поле `invite` любое значение, затем используйте его на регистрации
