# Translation Management System

A high-performance, scalable API-driven Translation Management System built using **Laravel (API)** and **Vue.js (Frontend)** with **Tailwind CSS**, designed to support dynamic multilingual apps.

---

## Features

- Manage translations across multiple locales (`en`, `fr`, `es`, etc.)
- Support for contextual tags like `mobile`, `web`, `desktop`
- Full CRUD API for translations
- Search functionality by `key`, `tag`, or `content`
- Export translations as JSON for frontend usage
- Fast responses (<200ms)
- Efficient JSON export endpoint for 100k+ translations (<500ms)
- JWT-based authentication (no Sanctum)
- Swagger/OpenAPI documentation
- Unit & Feature tests included
- Artisan command to generate dummy translations

---

## Project Structure

```
api/         # Laravel backend API
├── app/Console/Commands/GenerateTranslations.php
├── app/Http/Controllers/Api/TranslationController.php
├── app/Models/Translation.php
├── database/factories/TranslationFactory.php
├── database/seeders/UserSeeder.php
├── routes/api.php
├── tests/Feature/TranslationApiTest.php
│
└── public/docs/        # Swagger UI output

frontend/    # Vue 3 + Tailwind CSS frontend
├── src/components/TranslationList.vue
├── tailwind.config.js
├── postcss.config.js
└── vite.config.js
```

---

## Setup Instructions

### 🔧 Backend (Laravel API)

```bash
cd api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan translations:generate # Generates 100,000+ translations for testing
php artisan serve
```

> 🔐 JWT Auth is used. Sanctum is removed.

### 🧪 Run Tests
```bash
php artisan test
```

### 📚 Generate Swagger Docs
```bash
php artisan l5-swagger:generate
```
Visit: `http://localhost:8000/docs`

---

### 💻 Frontend (Vue + Tailwind)

```bash
cd frontend
npm install
npm run dev
```

Make sure Tailwind CSS is working. If needed:
```bash
npx tailwindcss init -p
```

---

## 🔐 Authentication
- Login: `POST /api/login`
- Requires JWT token for authenticated endpoints.
- Middleware: `auth:api`

---

## 📦 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST   | /api/login | Login with email & password |
| GET    | /api/me    | Get current authenticated user |
| POST   | /api/logout | Logout the user |
| GET    | /api/translations | List translations (searchable by key, tag, locale) |
| POST   | /api/translations | Create or update a translation |
| PUT    | /api/translations/{id} | Update translation value/tag |
| GET    | /api/translations/export/{locale} | Export JSON translations |

---

## 🧠 Design Choices

- **JWT Authentication**: Chosen for stateless, scalable API auth.
- **Factory & Seeder**: Used for performance testing (100k+ records).
- **JSON export**: Designed to return clean key-value pairs for frontend consumption.
- **Paginated API**: Ensures fast and scalable list responses.
- **Swagger**: Makes API easy to test and document.
- **Tailwind CSS**: Enables fast frontend styling with utility-first approach.

---

## ✍️ Artisan Command: translations:generate

Custom Artisan command that uses a factory to bulk-generate over 100,000 translations for performance testing.

```bash
php artisan translations:generate
```

---
