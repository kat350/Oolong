<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/header', function(){
    return view('header');
})->name('header');

Route::get('/reunion', function(){
    return view('reunion');
})->name('reunion');

Route::get('/taches', function(){
    return view('taches');
})->name('taches');