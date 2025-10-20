<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas de Veículos
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');
Route::get('/my-vehicles', [VehicleController::class, 'myVehicles'])->name('my-vehicles')->middleware('auth');
Route::get('/my-credits', function () {
    return view('my-credits');
})->name('my-credits')->middleware('auth');

// Rotas de Perfil (Breeze padrão)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rota profile.show alternativa
Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');

require __DIR__.'/auth.php';