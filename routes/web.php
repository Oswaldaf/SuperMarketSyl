<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StatisticController;

// Route::get('/dashboard', function () {
//     return view('dashboard');
// });


Route::get('/', [MainController::class, 'home'])->middleware(['auth', 'verified'])->name('home');



 Route::get('/dashboard', function () {
   return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/categories', CategoryController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/sales', SaleController::class);
    Route::resource('/statistic', StatisticController::class);
    Route::post('/sales/report', [StatisticController::class, 'salesReport'])->name('sales.report');
    
});

require __DIR__ . '/auth.php';
