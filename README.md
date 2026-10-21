# Atlas API

A Laravel REST API for exploring Hungarian counties and cities.

## Run locally (Windows PowerShell)

Requirements: PHP 8.3 or newer, Composer, and a database supported by Laravel.

From the project folder:

```powershell
composer install
if (!(Test-Path .env)) { Copy-Item .env.example .env }
```

If you created `.env` from `.env.example`, generate its application key:

```powershell
php artisan key:generate
```

Configure the database connection in `.env`. This project is currently configured for MySQL (`DB_CONNECTION=mysql`, database `laravel_rest_api`), so make sure MySQL is running and that database exists. For a new, empty database, create the tables and sample county/city data:

```powershell
php artisan migrate --seed
```

Only seed a fresh database; running the seeders again adds duplicate sample rows.

Start the web server:

```powershell
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) for the API overview, or try [http://127.0.0.1:8000/api/counties](http://127.0.0.1:8000/api/counties) for a JSON response.

The overview page's stylesheet is served directly from `public/css`, so Node.js and Vite are not required just to run the application.

## API endpoints

All endpoints are prefixed with `/api`. Responses are JSON.

| Method | Endpoint | Access |
| --- | --- | --- |
| `POST` | `/api/login` | Public |
| `GET` | `/api/users` | Public |
| `GET` | `/api/counties` | Public |
| `GET` | `/api/counties/{id}` | Public |
| `POST` | `/api/counties` | Sanctum token |
| `PUT` | `/api/counties/{id}` | Sanctum token |
| `DELETE` | `/api/counties/{id}` | Sanctum token |
| `GET` | `/api/cities` | Public |
| `GET` | `/api/cities/{id}` | Public |
| `GET` | `/api/counties/{id}/cities` | Public |
| `POST` | `/api/cities` | Sanctum token |
| `PUT` | `/api/cities/{id}` | Sanctum token |
| `DELETE` | `/api/cities/{id}` | Sanctum token |

County and city lists support a `search` query parameter. The cities list also supports `countyid`. Authenticate with `POST /api/login`, then send the returned token as a bearer token for protected write endpoints.