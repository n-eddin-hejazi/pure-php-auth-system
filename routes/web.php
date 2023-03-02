<?php 
use App\Core\Http\Route;
use App\Controllers\Auth\RegisterController;
use App\Controllers\HomeController;

     Route::get('', [HomeController::class, 'home']);
     Route::get('register', [RegisterController::class, 'index']);
     Route::post('register', [RegisterController::class, 'store']);
     
