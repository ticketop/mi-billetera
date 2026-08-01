<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientoController;

Route::get('/', [MovimientoController::class, 'dashboard']);

Route::get('/movimientos/nuevo', [MovimientoController::class, 'create']);

Route::post('/movimientos', [MovimientoController::class, 'store']);