<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendrierController;
use App\Http\Controllers\ReunionsController;
use App\Http\Controllers\ListeController;
use App\Http\Controllers\TacheController;

Route::get('/', fn() => view('welcome'));

Route::get('/header',  fn() => view('header'))->name('header');
Route::get('/welcome', fn() => view('welcome'))->name('welcome');
Route::get('/footer',  fn() => view('footer'))->name('footer');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/connexion',   [AuthController::class, 'showLogin'])->name('connexion');
    Route::post('/connexion',  [AuthController::class, 'login'])->name('login');
    Route::get('/inscription',  [AuthController::class, 'showRegister'])->name('inscription');
    Route::post('/inscription', [AuthController::class, 'register'])->name('register');
});
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');

// Tâches et Listes (authentification requise)
Route::middleware('auth')->group(function () {
    Route::get('/taches',            [TacheController::class, 'index'])->name('taches');
    Route::post('/taches',           [TacheController::class, 'store'])->name('taches.store');
    Route::patch('/taches/{tache}',  [TacheController::class, 'toggle'])->name('taches.toggle');
    Route::delete('/taches/{tache}', [TacheController::class, 'destroy'])->name('taches.destroy');

    Route::post('/listes',           [ListeController::class, 'store'])->name('listes.store');
    Route::delete('/listes/{liste}', [ListeController::class, 'destroy'])->name('listes.destroy');
});

// Réunions
Route::get('/reunion',  [ReunionsController::class, 'all_reunions'])->name('reunion');
Route::post('/reunion', [ReunionsController::class, 'storeReunion'])->name('reunions.store');

// Calendrier
Route::middleware('auth')->group(function () {
    Route::get('/calendrier',  [CalendrierController::class, 'index'])->name('calendrier');
    Route::post('/calendrier', [CalendrierController::class, 'store'])->name('calendrier.store');
    Route::delete('/calendrier/{id}', [CalendrierController::class, 'destroy'])->name('calendrier.destroy');
});
