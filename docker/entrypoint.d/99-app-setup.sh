#!/bin/bash
# Runs after migrations on every container start.
# The command itself is idempotent — safe to run repeatedly.
php /var/www/html/artisan relaticle:docker-setup
