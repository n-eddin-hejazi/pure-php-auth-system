<?php 
use App\Core\Http\Route;
use App\Controllers\Auth\RegisterController;
     
     Route::get('register', [RegisterController::class, 'index']);
     Route::post('register', [RegisterController::class, 'store']);
     
