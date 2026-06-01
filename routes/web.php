<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('my-ads', 'my-ads')->name('my-ads');
    Route::view('favorites', 'favorites')->name('favorites');
    Route::view('messages', 'messages')->name('messages');
});

require __DIR__.'/settings.php';
