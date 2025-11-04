# Contract Hub API

API для управления контрагентами с поддержкой мультиязычности (ru / en).

## Быстрый старт

### 1. Запуск Docker-контейнеров
```bash
docker-compose up -d --build
```

### 2. Установка зависимостей
```bash
docker exec -it contract_hub_app cp .env.example .env
docker exec -it contract_hub_app composer install
docker exec -it contract_hub_app php artisan key:generate
```

### 3. Настройка окружения

Настройки БД в `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=contract_hub_db
DB_USERNAME=contract_hub_user
DB_PASSWORD=8rip88lizL
```

### 4. Миграции
```bash
docker exec -it contract_hub_app php artisan migrate
```

### 5. Swagger UI (опционально)
```bash
docker exec -it contract_hub_app mkdir -p public/vendor/swagger-api/swagger-ui/dist
docker exec -it contract_hub_app cp -r vendor/swagger-api/swagger-ui/dist/* public/vendor/swagger-api/swagger-ui/dist/
docker exec -it contract_hub_app php artisan l5-swagger:generate
```

## Документация API

### Swagger UI
Интерактивная документация доступна по адресу:
```
http://localhost:8000/api/documentation
```

## API Endpoints

**Base URL:** `http://localhost:8000/api/v1`

### Аутентификация

#### Регистрация пользователя
```http
POST /registration
Content-Type: application/json

{
  "email": "1@1.ru",
  "password": "12345678",
  "password_confirmation": "12345678",
  "lastname": "Иванов",
  "name": "Иван",
  "patronymic": "Иванович"
}
```

#### Авторизация пользователя
```http
POST /login
Content-Type: application/json

{
  "email": "1@1.ru",
  "password": "12345678"
}
```

### Контрагенты

> ⚠️ **Все эндпоинты контрагентов требуют авторизации** (Bearer Token)

#### Получить список контрагентов
```http
GET /counterparties?perPage=10&page=1
Authorization: Bearer {your-token}
Content-Type: application/json
```

**Параметры запроса:**
- `perPage` (optional) - количество записей на странице
- `page` (optional) - номер страницы

#### Добавить контрагента
```http
POST /counterparty
Authorization: Bearer {your-token}
Content-Type: application/json

{
  "inn": "7736207543"
}
```
