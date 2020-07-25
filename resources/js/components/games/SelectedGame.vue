<template>

    <div>
        <h1>
            {{ game.name }}
        </h1>

        <component :is="game" :user-id="userId"></component>

        <h3 class="mt-3">Acerca del juego</h3>
        <!-- Para interpretar saltos de linea \r\n -->
        <p class="text-justify">
            <span class="text-justify" style="white-space: pre-line">{{ game.description }}</span>
        </p>    
    </div>
    
</template>

<script>
import connect4 from './Connect4.vue';
import snake from './Snake.vue';
import tetris from './Tetris.vue';
import theGameOfLife from './TheGameOfLife.vue';

export default {
    props: {
        // prop que envia la vista selected-game.blade para mostrar el componente correspondiente
        game: {
            required: true
        },
        userId: {
            required: true
        }
    },
    // componentes que utiliza el elemento component
    components: {
        'connect-4': connect4,
        'snake': snake,
        'tetris': tetris,
        'the-game-of-life': theGameOfLife,
    },
}
</script>