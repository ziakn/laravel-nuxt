<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;





require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});




// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::get('/logoutuser', [UserController::class, 'logout']);
//resources
Route::middleware(['auth'])->prefix('/app')->group(function () {
    Route::resource('/dashboard',  DashboardController::class);
    Route::resource('/category', CategoryController::class);
  

    Route::post('/changepassword', [UserController::class, 'changePass']);
    Route::post('/avatar', [UserController::class, 'avatar']);
    Route::get('/profile', [UserController::class, 'profile']);
});




// Auth::routes();

Route::middleware(['auth'])->get('/home', [HomeController::class, 'index']);
Route::middleware(['auth'])->get('/{slug}', [HomeController::class, 'index']);
Route::middleware(['auth'])->get('/{slug}/{child}', [HomeController::class, 'index']);
Route::middleware(['auth'])->get('/{slug}/{child}/{id}', [HomeController::class, 'index']);
