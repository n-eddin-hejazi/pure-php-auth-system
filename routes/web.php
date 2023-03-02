<?php 
use App\Core\Http\Route;
use App\Controllers\Auth\RegisterController;
use App\Controllers\Auth\LoginController;
use App\Controllers\HomeController;
use App\Controllers\Admin\HomeController as AdminHomeController;

     Route::get('', [HomeController::class, 'home']);
     Route::get('register', [RegisterController::class, 'index']);
     Route::post('register', [RegisterController::class, 'store']);
     Route::get('login', [LoginController::class, 'index']);
     Route::post('login', [LoginController::class, 'store']);

     Route::get('admin', [AdminHomeController::class, 'index']);
     
