@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="container mb-3">
                <h1>Selecciona un juego</h1>    
            </div>
            
            <div class="row">

                <div class="col-md-6 mb-4">
                    <div class="card" style="">
                        <img src="images/games/connect_4.png" class="card-img-top" alt="connect_4.png">
                        <div class="card-body">
                            <h5 class="card-title">Conecta 4</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="{{ route('connect-4') }}" class="btn btn-primary">Jugar</a>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-6 mb-4">
                    <div class="card" style="">
                        <img src="images/games/the_game_of_life.png" class="card-img-top" alt="game_of_life.png">
                        <div class="card-body">
                            <h5 class="card-title">El juego de la vida</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="{{ route('the-game-of-life') }}" class="btn btn-primary">Jugar</a>
                        </div>
                    </div>                    
                </div>
    
            </div>
            
            <div class="row">
    
                <div class="col-md-6 mb-4">
                    <div class="card" style="">
                        <img src="images/games/snake.png" class="card-img-top" alt="snake.png">
                        <div class="card-body">
                            <h5 class="card-title">Snake</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="{{ route('snake') }}" class="btn btn-primary">Jugar</a>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-6 mb-4">
                    <div class="card" style="">
                        <img src="images/games/tetris.jpg" class="card-img-top" alt="tetris.jpg">
                        <div class="card-body">
                            <h5 class="card-title">Tetris</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="{{ route('tetris') }}" class="btn btn-primary">Jugar</a>
                        </div>
                    </div>                    
                </div>
                
            </div>
    </div>
</div>
@endsection