<?php


// packages/ACME/Reels/src/Routes/admin-routes.php

use Illuminate\Support\Facades\Route;
use ACME\Reels\Http\Controllers\Admin\ReelController;
use ACME\Reels\Http\Controllers\Admin\EventBannerController;

Route::group(['middleware' => ['web', 'admin']], function () {
    Route::prefix(config('app.admin_url'))->group(function () {
        
        // This is your existing route for Reels, which is fine.
        Route::resource('reels', ReelController::class)->names('admin.reels');

        // This is the CORRECT way to register your Event Banner routes
        // We use a unique name 'event-banners' to avoid conflicts.
        Route::resource('event-banners', EventBannerController::class)->names('admin.event_banners');
        
    });
});