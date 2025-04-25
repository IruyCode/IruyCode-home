<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IruyCodeController;
use App\Http\Controllers\AppHealthMealController;
use App\Http\Controllers\BankManagerController;
use App\Http\Controllers\PomoTimerController;

// Página inicial geral
Route::get('/', [IruyCodeController::class, 'welcome'])->name('iruycode.welcome');

// Grupo Health Meal
Route::prefix('health-meal')->name('health-meal.')->group(function () {
    Route::get('/', [AppHealthMealController::class, 'index'])->name('index');

    // Exemplo de rota extra:
    Route::get('/create', [AppHealthMealController::class, 'create'])->name('create');
});

// Grupo Bank Manager
Route::prefix('bank-manager')->name('bank-manager.')->group(function () {
    Route::get('/', [BankManagerController::class, 'index'])->name('index');

    // Exemplo de rota extra:
    Route::get('/new', [BankManagerController::class, 'new'])->name('new');
});

// Grupo Pomodoro Timer
Route::prefix('pomodoro-timer')->name('pomodoro-timer.')->group(function () {
    Route::get('/', [PomoTimerController::class, 'index'])->name('index');

    // Exemplo de rota extra:
    Route::get('/start', [PomoTimerController::class, 'start'])->name('start');
});

