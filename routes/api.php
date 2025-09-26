<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


use App\Http\Controllers\api\v2\GenreController;
use App\Http\Controllers\api\v2\BrandController;
use App\Http\Controllers\api\v2\SongController;
use App\Http\Controllers\api\v2\AuthController;
use App\Http\Controllers\api\v2\PlaylistController;

Route::get('/genres', [GenreController::class,'index']);


Route::get('/brands', [BrandController::class,'index']);

Route::get('/songs', [SongController::class,'index']);

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::middleware(['auth:sanctum'])->group(function () {
  
    Route::get('/user',[AuthController::class, 'getUser']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::put('/user/update-profile', [AuthController::class, 'update_profile']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('playlist/add', [PlaylistController::class, 'addToPlaylist']);
    
    Route::delete('playlist/remove', [PlaylistController::class, 'removeFromPlaylist']);
    
    Route::get('playlist', [PlaylistController::class, 'getPlaylist']);
    
});
