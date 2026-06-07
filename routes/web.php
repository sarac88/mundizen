<?php

use App\Http\Controllers\AdController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('search', [AdController::class, 'search'])->name('search');
Route::get('listing/{ad}', [AdController::class, 'show'])->name('listing');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('my-ads', [AdController::class, 'index'])->name('my-ads');
    Route::view('favorites', 'favorites')->name('favorites');
    Route::view('messages', 'messages')->name('messages');
    Route::view('edit-profile', 'edit-profile')->name('edit-profile');
    Route::view('post-ad', 'post-ad')->name('post-ad');
    Route::post('post-ad', [AdController::class, 'store'])->name('ads.store');
});

require __DIR__.'/settings.php';
