<?php
Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {
    Route::get('/legacy', function () {
        return view('shop::static.legacy');
    })->name('shop.static.legacy');
});