<template>
    <div>
        <div class="row">

            <div class="col-md-6 mb-4">
                <div class="card" style="">
                    <img src="images/games/connect_4.png" class="card-img-top" alt="connect_4.png">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ this.games[0].name }}
                        </h5>
                        <p class="card-text">
                            {{ cutDescription(this.games[0].description) }}
                        </p>
                        <a :href="this.gameRoutes.connect4" class="btn btn-primary">Jugar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card" style="">
                    <img src="images/games/the_game_of_life.png" class="card-img-top" alt="game_of_life.png">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ this.games[1].name }}
                        </h5>
                        <p class="card-text">
                            {{ cutDescription(this.games[1].description) }}
                        </p>
                        <a :href="this.gameRoutes.theGameOfLife" class="btn btn-primary">Jugar</a>
                    </div>
                </div>                    
            </div>

        </div>
        <div class="row">

            <div class="col-md-6 mb-4">
                <div class="card" style="">
                    <img src="images/games/snake.png" class="card-img-top" alt="snake.png">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ this.games[2].name }}
                        </h5>
                        <p class="card-text">
                            {{ cutDescription(this.games[2].description) }}
                        </p>
                        <a :href="this.gameRoutes.snake" class="btn btn-primary">Jugar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card" style="">
                    <img src="images/games/tetris.jpg" class="card-img-top" alt="tetris.jpg">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ this.games[3].name }}
                        </h5>
                        <p class="card-text">
                            {{ cutDescription(this.games[3].description) }}
                        </p>
                        <a :href="this.gameRoutes.tetris" class="btn btn-primary">Jugar</a>
                    </div>
                </div>                    
            </div>
            
        </div>
    </div>


</template>
<script>
import { apiGamesURLS } from '../../constants.js'
import { cutText } from '../../functions.js'

export default {
    props: {
        gameRoutes: {
            required: true,Array
        }
    },
    data() {
        return {
            games: {
                type: Array,
                name: null,
                description: null
            }    
        }
    },
    created() {
        // Obtiene los datos de cada juego
        axios.get(apiGamesURLS['GET_GAMES'])
        .then(response => (
            this.games = response.data
        )).catch(function(errors) {
            console.log(errors);
        });
    },
    methods: {
        // Retorna una parte de la descripcion del juego
        cutDescription(text) {
            return cutText(text, 200);
        }
    }
}
</script>