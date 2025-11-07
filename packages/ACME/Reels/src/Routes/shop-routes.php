<?php

use Illuminate\Support\Facades\Route; // <-- CORRECTED
use ACME\Reels\Http\Controllers\Shop\EventPageController;

Route::group(['middleware' => ['web', 'theme']], function () {
    Route::get('events-exhibitions', [EventPageController::class, 'index'])->name('shop.events.index');
});