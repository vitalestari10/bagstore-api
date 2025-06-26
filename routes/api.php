<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\TransaksiController;

// 🔓 Route bebas akses
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔐 Route yang memerlukan token
Route::middleware('auth:sanctum')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Tes API
    Route::get('/tes-api', function () {
        return response()->json(['pesan' => 'API OK']);
    });

    // Produk CRUD
    Route::apiResource('produk', ProdukController::class);

    // Transaksi
    Route::post('/transaksi', [TransaksiController::class, 'store']);
});
