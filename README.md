# Fuel Station Management System

A Laravel 12 fuel station platform for Gasabo District operations. It manages customer purchases, fuel inventory, stock movements, sales, invoices, dashboards, reports, and Sanctum-protected REST APIs.

## Stack

- Laravel 12, PHP 8.3+
- Blade, Tailwind CSS, Alpine.js, Chart.js
- Laravel Breeze authentication
- Laravel Sanctum API authentication
- SQLite or MySQL
- DomPDF PDF exports
- CSV exports that open in Excel

## Install

```bash
composer install
npm install
cp .env.sqlite.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

The app opens at `http://localhost:8000`.

## SQLite Setup

```bash
cp .env.sqlite.example .env
New-Item -ItemType File -Force database/database.sqlite
php artisan key:generate
php artisan migrate --seed
```

SQLite is the default local option. `DB_DATABASE=database/database.sqlite` is included in `.env.sqlite.example`.

## MySQL Setup

Create the database first:

```sql
CREATE DATABASE fuel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then configure:

```bash
cp .env.mysql.example .env
php artisan key:generate
php artisan migrate --seed
```

Edit `.env` if your MySQL username/password differ.

## Demo Accounts

Running `php artisan migrate --seed` creates demo data automatically.

- Administrator: `admin@fuel.test` / `password`
- Customer: `aline@example.com` / `password`
- Customer: `eric@example.com` / `password`
- Customer: `grace@example.com` / `password`

## Running Tests

```bash
php artisan test
```

Current coverage includes authentication, profile updates, role protection, fuel CRUD, API auth, stock-safe sales, and oversell prevention.

## Administrator Account

Public registration creates customer accounts only. The seeded administrator can manage fuel types, prices, stock, sales, customers, transactions, and reports. The legacy `manager` role is still accepted by middleware for compatibility, but new seeded privileged users use `admin`.

## Main Features

- Customer dashboard, fuel prices, purchase flow, purchase history, invoice PDF download
- Administrator dashboard with revenue cards, chart, recent transactions, low-stock list
- Fuel type CRUD and price updates
- Stock movement tracking with IN/OUT audit entries
- Transaction-safe sales that reduce stock automatically
- Validation that prevents selling more fuel than available
- Customer directory with purchase totals
- Reports with date filters, PDF export, and Excel-compatible CSV export
- Sanctum API routes for auth, fuels, sales, and reports

## API Quick Reference

Base URL: `/api`

- `POST /register`
- `POST /login`
- `POST /logout` with bearer token
- `GET /fuels`
- `POST /fuels` administrator only
- `GET /fuels/{fuelType}`
- `PUT/PATCH /fuels/{fuelType}` administrator only
- `DELETE /fuels/{fuelType}` administrator only
- `GET /sales`
- `POST /sales` administrator only
- `GET /sales/{fuelSale}`
- `GET /reports` administrator only

Use `Authorization: Bearer <token>` for protected endpoints.

## Deployment

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Configure the web server document root to `public/`. Use HTTPS, set `APP_ENV=production`, `APP_DEBUG=false`, and configure a real mailer for password reset delivery.

## Database Schema

- `users`: authentication, role (`admin` or `customer`), contact profile
- `fuel_types`: fuel name, price per liter, available quantity
- `fuel_stocks`: stock snapshot and reorder level per fuel type
- `fuel_sales`: sale header, customer, payment method, status, sale date, total amount
- `fuel_sale_details`: line items, liters, sale price, subtotal
- `stock_movements`: IN/OUT quantity movement audit per fuel
- `transactions`: payment/revenue audit records connected to sales
- `reports`: administrator-generated report audit records

All relationship columns have foreign key constraints and useful indexes.
