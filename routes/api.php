<?php

use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\RatingController;
use App\Http\Controllers\API\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rotas públicas
Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/vehicles/featured', [VehicleController::class, 'featured']);
Route::get('/vehicles/{id}', [VehicleController::class, 'show']);

Route::get('/plans', [PaymentController::class, 'plans']);
Route::get('/sellers/{sellerId}/ratings', [RatingController::class, 'getSellerRatings']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Veículos
    Route::post('/vehicles', [VehicleController::class, 'store']);
    Route::put('/vehicles/{id}', [VehicleController::class, 'update']);
    Route::delete('/vehicles/{id}', [VehicleController::class, 'destroy']);
    Route::get('/my-vehicles', [VehicleController::class, 'myVehicles']);

    // Pagamentos e créditos
    Route::post('/purchase-credits', [PaymentController::class, 'purchaseCredits']);
    Route::post('/vehicles/{id}/feature', [PaymentController::class, 'featureVehicle']);
    Route::post('/vehicles/{id}/highlight', [PaymentController::class, 'highlightVehicle']);
    Route::get('/transactions', [PaymentController::class, 'transactionHistory']);

    // Avaliações
    Route::post('/ratings', [RatingController::class, 'store']);

    // Profile (usando Breeze)
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });
    
    Route::put('/profile', function (Request $request) {
        $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'string'],
            'bio' => ['sometimes', 'string', 'max:500'],
        ]);

        $request->user()->update($request->only('name', 'phone', 'bio'));

        return $request->user();
    });
});