<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AuthController;


Route::get('/', [PagesController::class, 'home'])->name('home');


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


Route::get('/login',[AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/reservas', [PagesController::class, 'reservas'])->name('reservas');
Route::get('/reservas/formulario/{tipo}', [PagesController::class, 'showReservaForm'])->name('reservas.formulario');
 