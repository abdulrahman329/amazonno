<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;


require __DIR__.'/auth.php';

Route::redirect('/', '/products');

Route::redirect('/dashboard', '/products')->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    route::resource('products', ProductController::class)->except(['index', 'show']);

    
    Route::middleware(['role:admin'])->group(function () {

        Route::resource('categories', CategoryController::class)->except('show');

    });

});

Route::resource('products', ProductController::class)->only(['index', 'show']);
