# Deployment Guide

1. Provision PHP 8.3+, Composer, Node.js, and MySQL or SQLite.
2. Set the server document root to the Laravel `public` directory.
3. Copy `.env.mysql.example` or `.env.sqlite.example` to `.env`.
4. Set `APP_ENV=production`, `APP_DEBUG=false`, and a secure `APP_KEY`.
5. Run:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

6. Configure HTTPS and a real mail provider for password resets.
7. Create the first manager account through Tinker or a controlled admin command.

