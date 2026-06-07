<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('search', [AdController::class, 'search'])->name('search');
Route::get('listing/{ad}', [AdController::class, 'show'])->name('listing');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('my-ads', [AdController::class, 'index'])->name('my-ads');
    Route::get('my-ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
    Route::put('my-ads/{ad}', [AdController::class, 'update'])->name('ads.update');
    Route::delete('my-ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');
    Route::get('favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::post('favorites/{ad}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::view('messages', 'messages')->name('messages');
    Route::view('edit-profile', 'edit-profile')->name('edit-profile');
    Route::view('post-ad', 'post-ad')->name('post-ad');
    Route::post('post-ad', [AdController::class, 'store'])->name('ads.store');
});

require __DIR__.'/settings.php';
