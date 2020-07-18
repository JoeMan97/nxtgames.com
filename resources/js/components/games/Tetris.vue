<!-- componente con los elementos visibles de la pagina /juegos/tetris  -->
<template>

    <div>
        <h1>
            {{ game.name }}
        </h1>

        <tetris-game :user-id="userId"></tetris-game>

        <h3 class="mt-3">Acerca del juego</h3>
        <!-- Para interpretar saltos de linea \r\n -->
        <p class="text-justify">
            <span class="text-justify" style="white-space: pre-line">{{ game.description }}</span>
        </p>
    </div>

</template>
<script>
import { apiGamesURLS, apiScoresURLS, gameIds } from '../../constants.js'

// Componente importado de manera local
import TetrisGame from './TetrisGame.vue';

export default {
    components: {
        'tetris-game': TetrisGame,
    },
    props: {
        userId: {
            required: true,
        },
    },
    data() {
        return {
            // variable con el id del juego tetris
            gameId: gameIds['TETRIS'],
            // variable que contendra los datos del juego
            game: {
                name: null,
                description: null
            },
        }
    },
    created() {
        // Obtiene los datos del juego
        axios.get(apiGamesURLS['GET_GAME'] + this.gameId)
        .then(response => (
            this.game = response.data
        )).catch(function(errors) {
            console.log(errors);
        });
    },
}
</script>