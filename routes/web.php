<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Biblioteca Routes (Public)
Route::prefix('biblioteca')->name('libroteca.')->group(function () {
    Route::get('/', function () {
        return view('biblioteca.dashboard');
    })->name('dashboard');
});

// Fototeca Routes (Public)
Route::prefix('fototeca')->name('fototeca.')->group(function () {
    Route::get('/', function () {
        return view('fototeca.dashboard');
    })->name('dashboard');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard Principal
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Biblioteca Admin
    Route::prefix('biblioteca')->name('biblioteca.')->group(function () {
        Route::get('/', function () {
            return view('admin.biblioteca.index');
        })->name('index');
    });

    // Fototeca Admin
    Route::prefix('fototeca')->name('fototeca.')->group(function () {
        Route::get('/', function () {
            return view('admin.fototeca.index');
        })->name('index');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
