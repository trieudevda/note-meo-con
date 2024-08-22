<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\middleware\AuthApi;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function(){
    Route::prefix('user')->group(function(){
        Route::post('login', [UsersController::class,'login']);
        Route::post('register', [UsersController::class,'register']);
        Route::post('forgotPassword', [UsersController::class,'forgotPassword']);
        Route::middleware(['auth:api','auth.apiCheck'])->group(function(){
        // Route::middleware([App\Http\Middleware\AuthApi::class])->group(function(){
            Route::post('login-token', [UsersController::class,'loginToken']);
            Route::post('logout', [UsersController::class,'logout']);
            Route::post('profile', [UsersController::class,'profile']);
            Route::post('changePassword', [UsersController::class,'changePassword']);
            Route::post('updateProfile', [UsersController::class,'updateProfile']);
        });        
    });
    Route::prefix('category')->group(function(){
        Route::get('list', [CategoryController::class,'list']);
        // Route::get('search', [CategoryController::class,'search']);
        Route::get('detail/{id}', [CategoryController::class,'detail']);
        Route::post('create', [CategoryController::class,'create']); 
        Route::post('update/{id}', [CategoryController::class,'update']);
        Route::get('delete/{id}', [CategoryController::class,'delete']);
    });
    Route::prefix('note')->group(function(){
        Route::get('list', [NoteController::class,'list']);
        Route::get('search/{id}', [NoteController::class,'search']);
        Route::get('detail/{id}', [NoteController::class,'detail']);
        Route::post('create', [NoteController::class,'create']);
        Route::post('update/{id}', [NoteController::class,'update']);
        Route::get('delete/{id}', [NoteController::class,'delete']); 
    });
});