<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace'  => 'RecursiveTree\Seat\WandererAccessSync\Http\Controllers',
    'middleware' => ['web', 'auth', 'locale'],
    'prefix' => 'wanderer-sync',
], function () {
    Route::get('/settings', [
        'as'   => 'wanderer-access-sync::settings',
        'uses' => 'SettingsController@list',
        'middleware' => 'can:wanderer-access-sync.edit'
    ]);

    Route::post('/settings/mapping', [
        'as'   => 'wanderer-access-sync::createMapping',
        'uses' => 'SettingsController@createMapping',
        'middleware' => 'can:wanderer-access-sync.edit'
    ]);
});