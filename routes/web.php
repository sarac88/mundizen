<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('search', [AdController::class, 'search'])->name('search');
Route::get('listing/{ad}', [AdController::class, 'show'])->name('listing');
Route::post('listing/{ad}/message', [MessageController::class, 'store'])->name('messages.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('my-ads', [AdController::class, 'index'])->name('my-ads');
    Route::get('my-ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
    Route::put('my-ads/{ad}', [AdController::class, 'update'])->name('ads.update');
    Route::patch('my-ads/{ad}/status', [AdController::class, 'toggleStatus'])->name('ads.status');
    Route::delete('my-ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');
    Route::get('favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::post('favorites/{ad}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('messages/{conversation?}', [MessageController::class, 'index'])->name('messages');
    Route::post('messages/{conversation}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::post('notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('edit-profile', [ProfileController::class, 'edit'])->name('edit-profile');
    Route::put('edit-profile', [ProfileController::class, 'update'])->name('edit-profile.update');
    Route::view('post-ad', 'post-ad')->name('post-ad');
    Route::post('post-ad', [AdController::class, 'store'])->name('ads.store');
});

require __DIR__.'/settings.php';
