<?php 
use App\Core\Http\Route;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\LogoutController;
use App\Controllers\HomeController;

     // homae page route
     Route::get('', [HomeController::class, 'home']);

     // register page route
     Route::get('register', [RegisterController::class, 'index']);
     Route::post('register', [RegisterController::class, 'store']);

     // login page route
     Route::get('login', [LoginController::class, 'index']);
     Route::post('login', [LoginController::class, 'store']);

     // logout page route
     Route::get('logout', [LogoutController::class, 'index']);


     
