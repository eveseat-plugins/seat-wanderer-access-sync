<?php

namespace RecursiveTree\Seat\WandererAccessSync;

use Illuminate\Support\Facades\Artisan;
use RecursiveTree\Seat\WandererAccessSync\Jobs\UpdateWandererInstance;
use RecursiveTree\Seat\WandererAccessSync\Models\WandererAccessListInstance;
use RecursiveTree\Seat\WandererAccessSync\Models\WandererAccessListRole;
use RecursiveTree\Seat\WandererAccessSync\Seeders\ScheduleSeeder;
use Seat\Services\AbstractSeatPlugin;


class WandererAccessSyncServiceProvider extends AbstractSeatPlugin
{
    public function boot(){
        if (! $this->app->routesAreCached()) {
            include __DIR__ . '/Http/routes.php';
        }

        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'wanderer-access-sync');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang/', 'wanderer-access-sync');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');

        $this->registerDatabaseSeeders([
            ScheduleSeeder::class
        ]);

        Artisan::command('wanderer:sync', function (){
            $access_lists = WandererAccessListInstance::all();
            foreach ($access_lists as $access_list){
                UpdateWandererInstance::dispatch($access_list);
            }
        });
    }

    public function register(){
        $this->registerPermissions(__DIR__ . '/Config/permissions.php', 'wanderer-access-sync');
        $this->mergeConfigFrom(__DIR__ . '/Config/sidebar.php','package.sidebar');
    }

    public function getName(): string
    {
        return 'SeAT Wanderer Access Sync';
    }

    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/eveseat-plugins/seat-wanderer-access-sync';
    }

    public function getPackagistPackageName(): string
    {
        return 'seat-wanderer-access-sync';
    }

    public function getPackagistVendorName(): string
    {
        return 'recursivetree';
    }
}