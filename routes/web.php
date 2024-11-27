<?php   

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;


use Illuminate\Support\Facades\Route;

// Group for guest (unauthenticated) users
Route::middleware('guest')->group(function () {
// Show login form
Route::get('login', [UserController::class, 'showLoginForm'])->name('login');

// Handle login form submission
Route::post('loginMatch', [UserController::class, 'login'])->name('loginMatch');
});

// Group for authenticated users
Route::middleware('auth')->group(function () {
// Show dashboard page
Route::get('dashboard', [UserController::class, 'dashboardPage'])->name('dashboard');
    
Route::resource('categories', CategoryController::class);

Route::resource('products', ProductController::class);

 

});
