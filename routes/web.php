<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ImageFolderController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\OurCustomerController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OurTeamController;
use App\Http\Controllers\SessionController;






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
    Route::resource('/user', UserController::class);
    Route::resource('/role',  RoleController::class);
    Route::resource('/page',  PageController::class);
    Route::resource('/folder', ImageFolderController::class);
    Route::resource('/image',  ImageController::class);
    Route::resource('/services',  ServicesController::class);
    Route::resource('/aboutus',  AboutUsController::class);
    Route::resource('/contactus',  ContactUsController::class);
    Route::resource('/social',  SocialController::class);
    Route::resource('/ourcustomer',  OurCustomerController::class);
    Route::resource('/banner',  BannerController::class);
    Route::resource('/project',  ProjectController::class);
    Route::resource('/blog',  BlogController::class);
    Route::resource('/ourteam',  OurTeamController::class);
    Route::resource('/session',  SessionController::class);
  

    Route::post('/changepassword', [UserController::class, 'changePass']);
    Route::post('/avatar', [UserController::class, 'avatar']);
    Route::get('/profile', [UserController::class, 'profile']);
    // Route::get('/session', [UserController::class, 'session']);
});




// Auth::routes();

Route::middleware(['auth'])->get('/home', [HomeController::class, 'index']);
Route::middleware(['auth' ])->get('/{slug}', [HomeController::class, 'index']);
Route::middleware(['auth'])->get('/{slug}/{child}', [HomeController::class, 'index']);
Route::middleware(['auth'])->get('/{slug}/{child}/{id}', [HomeController::class, 'index']);
