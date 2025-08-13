<?php

use App\Http\Controllers\Api\V1\PowerBiDataControlller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('powerbi_data', PowerBiDataControlller::class)->name('powerbi_data');
