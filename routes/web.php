<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogReplyController;
use App\Http\Controllers\ImageFolderController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CategoryController;





Route::get('/', function () {
    return view('welcome');
});

Route::get('/logoutuser', [UserController::class, 'logout']);
//resources
Route::middleware(['auth:sanctum', 'verified'])->prefix('/app')->group(function () {
    Route::resource('/user', UserController::class);
    Route::resource('/blog',  BlogController::class);
    Route::resource('/blogreply',  BlogReplyController::class);
    Route::resource('/folder', ImageFolderController::class);
    Route::resource('/image',  ImageController::class);
    Route::resource('/category',  CategoryController::class);
   
    Route::post('/changepassword', [UserController::class, 'changePass']);
    Route::get('/profile', [UserController::class, 'profile']);
});




// Auth::routes();

Route::middleware(['auth:sanctum', 'verified'])->get('/home', [HomeController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->get('/{slug}', [HomeController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->get('/{slug}/{child}', [HomeController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->get('/{slug}/{child}/{id}', [HomeController::class, 'index']);