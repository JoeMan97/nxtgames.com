require('./bootstrap');

window.Vue = require('vue');

// Vue.component('', require('./components/.vue').default);

// Compononentes de la vista configuration

// Compononentes de la vista games
Vue.component('games', require('./components/games/Games.vue').default);
Vue.component('selected-game', require('./components/games/SelectedGame.vue').default);
Vue.component('connect-4', require('./components/games/Connect4.vue').default);
Vue.component('snake', require('./components/games/Snake.vue').default);
Vue.component('tetris', require('./components/games/Tetris.vue').default);
Vue.component('the-game-of-life', require('./components/games/TheGameOfLife.vue').default);

// Compononentes de la vista news
Vue.component('news-list', require('./components/news/List.vue').default);
Vue.component('show-new', require('./components/news/Show.vue').default);
Vue.component('edit-new', require('./components/news/Edit.vue').default);
Vue.component('write-new', require('./components/news/Write.vue').default);
Vue.component('delete-new', require('./components/news/Delete.vue').default);

// Compononentes de la vista scores

// Componentes auxiliares
Vue.component('spinner', require('./components/Spinner.vue').default);

const app = new Vue({
    el: '#app',
});