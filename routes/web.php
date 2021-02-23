<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageFolderController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogReplyController;





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
    Route::resource('/folder', ImageFolderController::class);
    Route::resource('/image',  ImageController::class);
    Route::resource('/blog',  BlogController::class);
    Route::resource('/blogreply',  BlogReplyController::class);
  

    Route::post('/changepassword', [UserController::class, 'changePass']);
    Route::post('/avatar', [UserController::class, 'avatar']);
    Route::get('/profile', [UserController::class, 'profile']);
});




// Auth::routes();

Route::middleware(['auth'])->get('/home', [HomeController::class, 'index']);
Route::middleware(['auth'])->get('/{slug}', [HomeController::class, 'index']);
Route::middleware(['auth'])->get('/{slug}/{child}', [HomeController::class, 'index']);
Route::middleware(['auth'])->get('/{slug}/{child}/{id}', [HomeController::class, 'index']);
