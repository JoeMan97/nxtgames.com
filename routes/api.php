<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// GamesController
    Route::get('/games', 'GameController@index');

    Route::get('/games/game_id/{id}', 'GameController@show');

    Route::post('/games', 'GameController@store');

// ScoresController
    Route::post('/scores', 'ScoreController@store');

    Route::get('/scores/game_id/{game_id}/user_id/{user_id}', 'ScoreController@showBest');

    Route::get('/scores/game_id/{game_id}', 'ScoreController@showBestGlobal');

// NewController
    Route::get('/news', 'NewController@index');

    Route::get('/news/new_id/{id}', 'NewController@show');

    Route::post('/news', 'NewController@store');

    Route::put('/news/new_id/{id}', 'NewController@update');

    Route::delete('/news/new_id/{id}', 'NewController@destroy');