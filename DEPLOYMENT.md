# Deployment Guide for Parpora Website

This guide helps you configure the website for your hosting environment (cPanel, VPS, etc.).

## 1. Environment Configuration (.env)

On your hosting server, ensure your `.env` file has the following settings for production:

```ini
APP_NAME="Dinas Parpora"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://disparpora.sijunjung.go.id

# Fix for asset loading (if needed)
ASSET_URL=https://disparpora.sijunjung.go.id

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

## 2. HTTPS / SSL

The application is configured to force HTTPS when `APP_ENV=production`.
**Ensure your hosting has a valid SSL certificate installed.**

If you see `ERR_CERT_COMMON_NAME_INVALID`, it means the SSL certificate does not match the domain `parpora.sijunjung.go.id`. You must fix this in your hosting changes (e.g., cPanel > SSL/TLS Status -> AutoSSL).

## 3. Storage Link

Ensure the storage symbolic link exists so images can be served:

```bash
php artisan storage:link
```

## 4. Optimization

After deploying new code or changing the `.env` file, run:

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 5. File Permissions

Ensure the `storage` and `bootstrap/cache` directories are writable:

```bash
chmod -R 775 storage bootstrap/cache
```
