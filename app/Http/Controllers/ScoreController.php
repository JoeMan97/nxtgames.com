<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Score;

class ScoreController extends Controller
{
    /**
     * Almacena un nuevo puntaje.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $score = Score::create($request->all());

        return response()->json($score, 201); // 201: Created
    }

    /**
     * Retorna los mejores 10 puntajes del usuario y juego especificado.
     *
     * @param  int  $game_id
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function showBest($game_id, $user_id)
    {
        $match = [ 'game_id' => $game_id, 'user_id' => $user_id];

        $scores = Score::where($match)
            ->orderBy('score', 'DESC')
            ->limit(10)
            ->get();

        return response()->json($scores, 200);
    }

    /**
     * Retorna los mejores 10 puntajes del juego especificado.
     *
     * @param  int  $game_id
     * @return \Illuminate\Http\Response
     */
    public function showBestGlobal($game_id)
    {
        $scores = Score::where('game_id', $game_id)
            ->orderBy('score', 'DESC')
            ->limit(10)
            ->get();

        return response()->json($scores, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
