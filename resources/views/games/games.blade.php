@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="container mb-3">
                <h1>Selecciona un juego</h1>    
            </div>
            
            <games 
                :game-routes="{{ json_encode(array(
                    "connect4" => route('connect-4'),
                    "theGameOfLife" => route('the-game-of-life'),
                    "snake" => route('snake'),
                    "tetris" => route('tetris')
                )) }}"
            ></games>
    </div>
</div>
@endsection