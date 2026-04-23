<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendrierController;

Route::get('/', function () {
    return view('welcome');
});

// Routes existantes
Route::get('/header',   fn() => view('header'))->name('header');
Route::get('/taches',   fn() => view('taches'))->name('taches');
Route::get('/welcome',  fn() => view('welcome'))->name('welcome');
Route::get('/footer',   fn() => view('footer'))->name('footer');
Route::get('/reunion',  fn() => view('reunion'))->name('reunion');

// ✅ Nouvelles routes du calendrier
Route::get('/calendrier', [CalendrierController::class, 'index'])->name('calendrier');
Route::post('/reunions',  [CalendrierController::class, 'storeReunion'])->name('reunions.store');
Route::post('/taches-store', [CalendrierController::class, 'storeTache'])->name('taches.store');