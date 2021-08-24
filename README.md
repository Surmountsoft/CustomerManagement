# This is for customer management package

## This is to create custom package for customer management.

Install via composer
composer require csoftech/customer

Then publish it 
php artisan vendor:publish

Then run migration and seeder
php artisan migrate
php artisan db:seed --class=PermissionsTableSeeder