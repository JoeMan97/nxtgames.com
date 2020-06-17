require('./bootstrap');

window.Vue = require('vue');

// Vue.component('', require('./components/.vue').default);

// Compononentes de la vista configuration

// Compononentes de la vista games
Vue.component('select-game', require('./components/games/SelectGame.vue').default);
Vue.component('connect-4', require('./components/games/Connect4.vue').default);
Vue.component('snake', require('./components/games/Snake.vue').default);
Vue.component('tetris', require('./components/games/Tetris.vue').default);
Vue.component('the-game-of-life', require('./components/games/TheGameOfLife.vue').default);

// Compononentes de la vista news

// Compononentes de la vista scores

const app = new Vue({
    el: '#app',
});
