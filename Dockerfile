FROM php:8.3-apache

# 必要な拡張をインストール
RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip zip curl \
    libzip-dev libxml2-dev libpq-dev \
    libcurl4-openssl-dev libicu-dev \
    && docker-php-ext-install -j$(nproc) \
        zip pdo_pgsql bcmath opcache \
        curl xml intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# PHP設定ファイルをコピー
COPY docker/php/laravel.ini "$PHP_INI_DIR/conf.d/00-laravel.ini"
COPY docker/php/production.ini "$PHP_INI_DIR/conf.d/production.ini"

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html/
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Storage ディレクトリとキャッシュディレクトリの作成と権限設定
RUN mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/logs \
    && chown -R www-data:www-data /var/www/html /var/www/html/storage \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate \
    && a2enmod rewrite

# Apache のドキュメントルートを Laravel の public に変更
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
