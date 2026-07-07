<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// 単語
Route::middleware('auth')->group(function () {
    Route::get('/words', [App\Http\Controllers\WordController::class, 'index'])->name('words.index');
    Route::get('/words/{word}', [App\Http\Controllers\WordController::class, 'show'])->name('words.show');
});

// 管理画面
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('index');
    Route::get('/words/create', [App\Http\Controllers\AdminController::class, 'create'])->name('words.create');
    Route::post('/words', [App\Http\Controllers\AdminController::class, 'store'])->name('words.store');
    Route::get('/words/{word}/edit', [App\Http\Controllers\AdminController::class, 'edit'])->name('words.edit');
    Route::put('/words/{word}', [App\Http\Controllers\AdminController::class, 'update'])->name('words.update');
    Route::delete('/words/{word}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('words.destroy');
});

// お気に入り
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{word}/toggle', [App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');
});