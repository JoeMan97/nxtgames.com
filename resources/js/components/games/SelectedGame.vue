<template>

    <component v-bind:is="game"></component>
    
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
            type: String,
            required: true
        }
    },
    // componentes que utiliza el elemento component
    components: {
        'connect-4': connect4,
        'snake': snake,
        'tetris': tetris,
        'the-game-of-life': theGameOfLife
    },
}
</script>