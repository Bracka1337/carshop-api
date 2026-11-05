# Carshop – wheel & rim web shop

An e-commerce shop for car wheels and rims, built with Laravel. Customers
browse the catalogue, filter by wheel specs (diameter, width, type, brand,
price), add rims to a cart and check out with pay-on-delivery or a (mocked)
card payment. Staff manage brands, products, images, orders, payments and
users in a Filament admin panel. A small token-authenticated JSON API exposes
the catalogue and a customer's orders.

This is a team project from the **Magebit bootcamp (2024)**. I was the
**team lead**. In 2026 it was upgraded from Laravel 10 to Laravel 12 and
Filament 4, with feature tests added for the shop, the admin panel and the API.

## Stack

| Layer      | Tech                                                         |
| ---------- | ------------------------------------------------------------ |
| Backend    | PHP 8.2+, Laravel 12, Eloquent, Blade                        |
| Admin      | Filament 4 (Livewire 3)                                      |
| API auth   | Laravel Sanctum personal access tokens                       |
| Frontend   | Vite 8, Tailwind CSS 3, Flowbite                             |
| Database   | MySQL (Docker) or SQLite (local)                             |
| Tests      | PHPUnit 11, Laravel HTTP & Livewire testing                  |
| Infra      | Docker Compose: PHP-FPM, nginx, MySQL                        |

## Features

- **Catalogue**: paginated listing, filters by diameter / width / type / brand /
  price range, sorting by price or brand
- **Cart**: session based; add, change quantity, remove
- **Checkout**: delivery details form, pay on delivery or card payment against a
  mock payment endpoint, order + payment records
- **Accounts**: registration, login, profile with order history and order details
- **Admin panel** (`/admin`, admin role only): CRUD for brands, products,
  images, orders, payments and users, plus dashboard stats (users, orders,
  fulfilled orders, revenue)
- **JSON API**: products (public), current user and own orders (token)

## Running locally (SQLite)

Requirements: PHP 8.2+ (with `pdo_sqlite`, `intl`, `zip`, `mbstring`),
Composer 2, Node.js 20.19+ or 22.12+.

```bash
composer install
npm ci
npm run build            # or `npm run dev` while working on the frontend

cp .env.example .env
php artisan key:generate
```

Switch the database to SQLite in `.env`:

```dotenv
DB_CONNECTION=sqlite
# comment out or remove DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
```

Then create the schema, demo data and the public storage link (product images
live in `storage/app/public/images`):

```bash
php artisan migrate --seed     # offers to create database/database.sqlite
php artisan storage:link
php artisan serve
```

Open http://127.0.0.1:8000.

## Running with Docker

`docker-compose.yml` starts three containers: `app` (PHP 8.3-FPM + Node 22),
`nginx` on port **8080** and `mysql-db` (MySQL 5.7). The project directory is
mounted into the containers, so dependencies are installed into your working
copy:

```bash
cp .env.example .env           # already points at DB_HOST=mysql-db
docker compose up -d --build

docker compose exec app composer install
docker compose exec app sh -c "npm ci && npm run build"
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
```

Open http://localhost:8080.

## Demo accounts

The seeder creates 200 products across 61 brands, random customers with
orders, and two fixed accounts. **These are for local development only.**

| Role  | Email                   | Password  |
| ----- | ----------------------- | --------- |
| Admin | `admin@eastsquad.com`   | `admin`   |
| User  | `default@eastsquad.com` | `default` |

Seeded random customers use the password `password`.

## Tests

```bash
php artisan test
```

Tests run against an in-memory SQLite database (see `phpunit.xml`) and cover
auth, catalogue filters, cart, checkout, profile/order access, every Filament
resource page, product CRUD in the admin, and all API endpoints.

## Routes overview

### Web shop (session auth)

| Method | Path                           | Description                                   |
| ------ | ------------------------------ | --------------------------------------------- |
| GET    | `/`                            | Catalogue with filters (`diameter`, `width`, `type`, `brand`, `price_from`, `price_to`, `order`) |
| GET    | `/aboutus`                     | About the team                                |
| GET    | `/products/{id}`               | Add a product to the cart                     |
| POST   | `/cart/update/{id}/{quantity}` | Change quantity (0 removes the item)          |
| POST   | `/cart/remove/{id}`            | Remove from cart (JSON response)              |
| GET    | `/register`, `/login`          | Auth pages (POST to submit)                   |
| GET    | `/logout`                      | Log out                                       |
| GET    | `/profile`                     | Order history *(auth)*                        |
| GET    | `/profile/orderdetails/{id}`   | One of your orders *(auth)*                   |
| GET    | `/checkout`                    | Delivery details form *(auth)*                |
| GET    | `/payment`                     | Create the order *(auth)*                     |
| GET    | `/payment-details`             | Card form for an unpaid order *(auth)*        |
| GET    | `/process-payment`             | Charge via the mock payment endpoint *(auth)* |
| GET    | `/admin`                       | Filament admin panel *(admin role)*           |

### JSON API (`/api`, Sanctum tokens)

All responses are JSON. Protected endpoints need an
`Authorization: Bearer <token>` header.

| Method | Path                  | Auth  | Description                                       |
| ------ | --------------------- | ----- | ------------------------------------------------- |
| POST   | `/api/login`          | –     | `email`, `password`, optional `device_name` → token (rate limited: 6/min) |
| POST   | `/api/logout`         | token | Revoke the token used for the request             |
| GET    | `/api/user`           | token | Current user                                      |
| GET    | `/api/products`       | –     | Paginated products; same filters as the shop      |
| GET    | `/api/products/{id}`  | –     | One product with brand, specs and image URLs      |
| GET    | `/api/orders`         | token | Your orders with items and totals                 |
| GET    | `/api/orders/{id}`    | token | One of your orders (others return 404)            |

Example:

```bash
TOKEN=$(curl -s -X POST http://127.0.0.1:8000/api/login \
  -d email=default@eastsquad.com -d password=default -d device_name=cli \
  | php -r 'echo json_decode(stream_get_contents(STDIN))->token;')

curl -s "http://127.0.0.1:8000/api/products?diameter=17&order=price_asc"
curl -s -H "Authorization: Bearer $TOKEN" http://127.0.0.1:8000/api/orders
```

`GET /api/products/1` (trimmed):

```json
{
  "data": {
    "id": 1,
    "title": "Ronal",
    "brand": { "id": 44, "title": "Ronal" },
    "type": "Alloy",
    "price": 980,
    "specs": { "diameter": 19, "width": 10.5, "et": 5, "cb": 56, "bolt": 5, "bolt_diameter": 108 },
    "images": ["http://127.0.0.1:8000/storage/images/Borbet.webp", "…"]
  }
}
```

## Project layout

```
app/Filament/            Admin panel resources, pages and widgets
app/Http/Controllers/Api Web shop controllers (Blade views, session auth)
app/Http/Controllers/JsonApi  JSON API controllers (Sanctum)
app/Http/Resources/      API resources (Product, Order, User)
app/Models/              Eloquent models (Product::filter, Order::costBreakdown)
resources/views/         Blade templates
tests/Feature/           Web, Admin and Api feature tests
```
