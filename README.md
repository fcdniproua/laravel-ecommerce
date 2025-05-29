## Быстрый старт с Docker

1. Клонируйте репозиторий:
```bash
git clone https://github.com/your-username/laravel-ecommerce.git
cd laravel-ecommerce
```

2. Скопируйте файл конфигурации:
```bash
cp .env.example .env
```

3. Настройте переменные окружения в `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel_ecommerce
DB_USERNAME=laravel_user
DB_PASSWORD=password
```

4. Запустите контейнеры:
```bash
docker-compose up -d
```

5. Установите зависимости и выполните настройку:
```bash
# Установка зависимостей PHP
docker-compose exec app composer install
# Генерация ключа приложения
docker-compose exec app php artisan key:generate
# Создание символической ссылки для хранилища
docker-compose exec app php artisan storage:link
# Выполнение миграций и заполнение БД
docker-compose exec app php artisan migrate --seed
```

6. Установите и соберите frontend:
```bash
docker-compose exec app npm install
docker-compose exec app npm run build
```

Готово! Приложение доступно по адресам:
- Сайт: http://localhost:8000
- PhpMyAdmin: http://localhost:8080 (логин: laravel_user, пароль: password)

## Тестовые данные

После выполнения сидов в системе будет создан тестовый администратор:
- Email: admin@example.com
- Пароль: password
