<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IruyCodeController;
use App\Http\Controllers\AppHealthMealController;
use App\Http\Controllers\BankManagerController;
use App\Http\Controllers\PomoTimerController;

// Página inicial geral
Route::get('/', [IruyCodeController::class, 'welcome'])->name('iruycode.welcome');

Route::get('test',[IruyCodeController::class, 'test'])->name('iruycode.test');

// Grupo Health Meal
Route::prefix('health-meal')
    ->name('health-meal.')
    ->group(function () {
        Route::get('/', [AppHealthMealController::class, 'index'])->name('index');

        // Exemplo de rota extra:
        Route::get('/create', [AppHealthMealController::class, 'create'])->name('create');
    });

// Grupo Bank Manager
Route::prefix('bank-manager')
    ->name('bank-manager.')
    ->group(function () {
        Route::get('/', [BankManagerController::class, 'index'])->name('index');

        Route::post('/operation-types', [BankManagerController::class, 'storeOperationType'])->name('operation.store');
        // Atualiza para chamar o método storeOperationCategory
        Route::post('/operation-categories', [BankManagerController::class, 'storeOperationCategory'])->name('operation-categories.store');

        Route::post('/bank-manager/transactions', [BankManagerController::class, 'storeTransaction'])->name('transactions.store');

    });

// Grupo Pomodoro Timer
Route::prefix('pomodoro-timer')
    ->name('pomodoro-timer.')
    ->group(function () {
        Route::get('/', [PomoTimerController::class, 'index'])->name('index');

        // Exemplo de rota extra:
        Route::get('/start', [PomoTimerController::class, 'start'])->name('start');
    });
