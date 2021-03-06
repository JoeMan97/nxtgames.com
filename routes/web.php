<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Ruta configuracion
    Route::view('/configuracion', 'configuration')->name('configuration')->middleware('auth');

// Rutas del modulo de juegos
    Route::view('/juegos', 'games/games')->name('select-game');
    Route::view('/juegos/conecta-4', 'games/selected-game', ['game' => 'connect-4'])->name('connect-4');
    Route::view('/juegos/el-juego-de-la-vida', 'games/selected-game', ['game' => 'the-game-of-life'])->name('the-game-of-life')->middleware('auth');
    Route::view('/juegos/snake', 'games/selected-game', ['game' => 'snake'])->name('snake');
    Route::view('/juegos/tetris', 'games/selected-game', ['game' => 'tetris'])->name('tetris')->middleware('auth');

// Rutas del modulo de noticias
    Route::get('/noticias/{status?}', function($status = null) {
        if($status == 'redactar') {
            return view('./news/create');
        }
        return view('./news/index', ['status' => $status]);
    })->name('news')->middleware('auth');

    Route::get('/noticias/id/{id}', function ($id) {
        return view('./news/show', ['id' => $id]);
    })->middleware('auth');

    Route::get('/noticias/editar/{id}', function ($id) {
        return view('./news/update', ['id' => $id]);
    })->middleware('auth');

// Rutas del modulo de puntuaciones
    Route::view('/puntuaciones-globales', 'scores',['type' => 'global'])->name('global-scores')->middleware('auth');
    Route::view('/puntuaciones-usuario', 'scores',['type' => 'user'])->name('user-scores')->middleware('auth');
