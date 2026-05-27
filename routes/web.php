<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// User routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('/test')->name('test.')->group(function () {
        Route::get('/', [TestController::class, 'index'])->name('index');
        Route::get('/create', [TestController::class, 'create'])->name('create');
        Route::post('/start', [TestController::class, 'start'])->name('start');
        Route::get('/show/{index}', [TestController::class, 'show'])->name('show');
        Route::post('/answer/{index}', [TestController::class, 'submitAnswer'])->name('answer');
        Route::get('/finish', [TestController::class, 'finish'])->name('finish');
        Route::get('/history', [TestController::class, 'history'])->name('history');
    });
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('/admin')->name('admin.')->group(function () {
    Route::resource('questions', QuestionController::class);
    Route::post('/questions/{question}/toggle-active', [QuestionController::class, 'toggleActive'])->name('toggle-active');
});
