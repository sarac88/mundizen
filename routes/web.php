<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('search', 'search')->name('search');
Route::view('listing', 'listing')->name('listing');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('my-ads', 'my-ads')->name('my-ads');
    Route::view('favorites', 'favorites')->name('favorites');
    Route::view('messages', 'messages')->name('messages');
    Route::view('edit-profile', 'edit-profile')->name('edit-profile');
    Route::view('post-ad', 'post-ad')->name('post-ad');
});

require __DIR__.'/settings.php';
