<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservaController;



Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


Route::get('/login',[AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/reservas', [ReservaController::class, 'ShowReserva'])->name('reservas');
Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
Route::get('/reservas/habitaciones/{tipo}', [ReservaController::class, 'getHabitaciones']);

Route::get('/ver_reserva', [ReservaController::class, 'verReservas'])->name('ver_reservas');
Route::get('/reservas/pdf/{id}', [ReservaController::class, 'pdfReserva'])->name('reservas.pdf'); 
Route::get('/pdf-reservas', [ReservaController::class, 'pdfGeneral'])->name('reservas.pdfGeneral');
Route::get('/reservas/excel', [ReservaController::class, 'excelGeneral'])->name('reservas.excelGeneral'); 


Route::get('/reservas/{id}/editar', [ReservaController::class, 'edit'])->name('reservas.editar');
Route::put('/reservas/{id}', [ReservaController::class, 'update'])->name('reservas.update');
Route::put('/reservas/{id}/cancelar', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');
