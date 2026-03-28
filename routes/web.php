<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'create'])->name('register');
    Route::post('/register', [UserController::class, 'register']);

    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'login']);
});

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('notes.index');
    Route::post('/notes', [PostController::class, 'store'])->name('notes.store');
    Route::get('/notes/{post}/edit', [PostController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{post}', [PostController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{post}', [PostController::class, 'destroy'])->name('notes.destroy');
});

Route::post('/theme-toggle', function (Request $request) {
    $user = $request->user();
    $user->theme = $request->theme;
    $user->save();

    return response()->json(['status' => 'success']);
})->middleware('auth');
