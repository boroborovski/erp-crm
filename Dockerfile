# syntax=docker/dockerfile:1

###########################################
# Stage 1: Composer dependencies
###########################################
FROM composer:2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --ignore-platform-reqs

###########################################
# Stage 2: Production image
# Frontend assets are pre-built and committed
# to the repository (public/build/) so no
# Node.js / npm step is needed here.
###########################################
FROM serversideup/php:8.4-fpm-nginx AS production

LABEL org.opencontainers.image.title="ERP CRM"
LABEL org.opencontainers.image.description="Self-hosted ERP / CRM platform"
LABEL org.opencontainers.image.source="https://github.com/boroborovski/erp-crm"

# Switch to root to install dependencies
USER root

# Install required PHP extensions
RUN install-php-extensions intl exif gd imagick bcmath

# Install PostgreSQL client for health checks
RUN apt-get update \
    && apt-get install -y --no-install-recommends postgresql-client \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Switch back to www-data
USER www-data

WORKDIR /var/www/html

# Copy application source (includes pre-built public/build/)
COPY --chown=www-data:www-data . .

# Copy vendor from composer stage
COPY --chown=www-data:www-data --from=composer /app/vendor ./vendor

# Generate optimized autoloader
RUN composer dump-autoload --optimize --no-dev

# Copy custom entrypoint script (runs after migrations on boot)
USER root
COPY docker/entrypoint.d/99-app-setup.sh /etc/entrypoint.d/99-app-setup.sh
RUN chmod +x /etc/entrypoint.d/99-app-setup.sh
USER www-data

# Create storage directories
RUN mkdir -p \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Default environment for serversideup/php Laravel automations
ENV AUTORUN_ENABLED=true
ENV AUTORUN_LARAVEL_STORAGE_LINK=true
ENV AUTORUN_LARAVEL_MIGRATION=true
ENV AUTORUN_LARAVEL_MIGRATION_ISOLATION=true
ENV AUTORUN_LARAVEL_CONFIG_CACHE=true
ENV AUTORUN_LARAVEL_ROUTE_CACHE=true
ENV AUTORUN_LARAVEL_VIEW_CACHE=true
ENV AUTORUN_LARAVEL_EVENT_CACHE=true
ENV AUTORUN_LARAVEL_OPTIMIZE=false
ENV PHP_OPCACHE_ENABLE=1
ENV SSL_MODE=off

EXPOSE 8080
