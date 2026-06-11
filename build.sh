#!/bin/bash

set -e

echo "Deploy started..."

git reset --hard
git clean -fd

git fetch origin cicd
git checkout cicd
git reset --hard origin/cicd

echo "Installing PHP dependencies..."
export COMPOSER_ALLOW_SUPERUSER=1 
composer install --no-dev --optimize-autoloader

echo "Installing Node dependencies..."
npm ci

echo "Building frontend..."
npm run build

echo "Migrating DB..."
php artisan migrate --force

echo "Caching..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deploy complete"
