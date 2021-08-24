<?php

namespace CSoftech\Customer;

use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/lang', 'tran');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'view');
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        $this->publishes([
            __DIR__.'/public/js' => public_path('js'),
        ], 'js');
        $this->publishes([
            __DIR__.'/public/css' => public_path('css'),
        ], 'css');
        $this->publishes([
            __DIR__.'/public/assets' => public_path('assets'),
        ], 'assets');
        $this->publishes([
            __DIR__.'/config/permissionGroup.php' => config_path('permissionGroup.php'),
        ], 'pGroup');
        $this->publishes([
            __DIR__.'/seeders/PermissionsTableSeeder.php' => database_path('seeders/PermissionsTableSeeder.php'),
        ], 'seeder');
        $this->publishes([
            __DIR__.'/seeders/CountriesTableSeeder.php' => database_path('seeders/CountriesTableSeeder.php'),
        ], 'country-seeder');
        $this->publishes([
            __DIR__.'/seeders/StatesTableSeeder.php' => database_path('seeders//StatesTableSeeder.php'),
        ], 'state-seeder');
        $this->publishes([
            __DIR__.'/seeders/CitiesTableSeeder.php' => database_path('seeders/CitiesTableSeeder.php'),
        ], 'city-seeder');
    }
}
