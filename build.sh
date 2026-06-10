#!/bin/bash

echo "Building...deploy script" 1/5
git pull origin cicd

echo "Creating Database If Not Exists..." 2/5
touch ./database/database.sqlite

echo "Installing Packages..." 3/5
composer install

# echo "Publishing API Platform assets..." 4/5
# php artisan api-platform:install

echo "Migrating Database..." 4/5
php artisan migrate --force

npm ci
npm run build


echo "Optimizing and clearing cache..." 5/5
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deploy Complete"



