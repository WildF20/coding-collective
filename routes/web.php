<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/transaction', function () {
        return Inertia::render('Transaction');
    })->name('transaction');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    
});

Route::namespace('App\Http\Controllers')->group(function() {
    Route::namespace('Transaction')->group(function() {
        Route::apiResources([
            'transaction' => 'TransactionController',
        ]);
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
