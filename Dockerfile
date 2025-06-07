FROM php:8.3-apache

# 必要な拡張をインストール
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install zip pdo pdo_mysql pdo_pgsql intl bcmath opcache

# OPcacheなどCloud Run向けphp.ini
RUN set -ex; \
  { \
    echo "; Cloud Run enforces memory & timeouts"; \
    echo "memory_limit = -1"; \
    echo "max_execution_time = 0"; \
    echo "upload_max_filesize = 32M"; \
    echo "post_max_size = 32M"; \
    echo "; Configure Opcache for Containers"; \
    echo "opcache.enable = On"; \
    echo "opcache.validate_timestamps = Off"; \
    echo "opcache.memory_consumption = 32"; \
  } > "$PHP_INI_DIR/conf.d/cloud-run.ini"

# Composer インストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Laravel アプリのコピー
COPY . /var/www/html

# Storage ディレクトリとキャッシュディレクトリの作成と権限設定
RUN mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/logs \
    && chown -R www-data:www-data /var/www/html/storage

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist \
    && php artisan route:cache \
    && php artisan view:cache

# Apache の設定（Laravel 用）
RUN chown -R www-data:www-data /var/www/html \
&& a2enmod rewrite

# Apache のドキュメントルートを Laravel の public に変更
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
