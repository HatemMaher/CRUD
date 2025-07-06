<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;


Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::post('/logout', [UserController::class, 'logout']);


// Blog post related routs
Route::middleware('auth')->group(function (){
    Route::get('/',[PostController::class, 'index'])->middleware('auth');
    Route::post('/posts',[PostController::class, 'store']);
    Route::get('/posts/{post}/edit', [PostController::class, 'edit']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});


Route::post('/theme-toggle', function (Request $request) {
    $user = auth()->user();
    $user->theme = $request->theme;
    $user->save();
    return response()->json(['status' => 'success']);
})->middleware('auth');

