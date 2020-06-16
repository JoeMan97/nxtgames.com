<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Rutas principales

Route::view('/configuracion', 'configuration')->name('configuration');

Route::view('/juegos/conecta-4', 'games',['game' => ''])->name('connect-4');
Route::view('/juegos/el-juego-de-la-vida', 'games',['game' => ''])->name('the-game-of-life');
Route::view('/juegos/snake', 'games',['game' => 'snake'])->name('snake');
Route::view('/juegos/tetris', 'games',['game' => 'tetris'])->name('tetris');

Route::view('/noticias', 'news')->name('news');

Route::view('/puntuaciones-globales', 'scores',['type' => 'global'])->name('global-scores');
Route::view('/puntuaciones-usuario', 'scores',['type' => 'user'])->name('user-scores');
