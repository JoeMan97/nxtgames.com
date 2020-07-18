<!-- Modal para cuando se termine un juego -->
<template>
    
        <div class="modal" id="game-over-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Juego Terminado
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tu puntaje fue de {{ score }}</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Rango</th>
                                <th scope="col">Puntaje</th>
                                <th scope="col">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(score, rank) in scores" :key="rank">
                                <th scope="row">{{ rank + 1 }}</th>
                                <td>{{ score.score }}</td>
                                <td>{{ getDate(score.created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import { apiScoresURLS } from '../../constants.js';
import { gameIds } from '../../constants.js';

export default {
    props: {
        gameState: {
            required: true
        },
        score: {
            required: true
        },
        userId: {
            required: true
        }
    },
    data() {
        return {
            gameId: gameIds['TETRIS'],
            scores: new Array()
        }
    },
    updated: async function() {
        // Si el juego acabo...
        if (this.gameState === 'over') {
            // envia el puntaje
            await axios.post(apiScoresURLS['POST_SCORE'], {
                score: String(this.score),
                game_id: this.gameId,
                user_id: this.userId
            })
            .then(response => {})
            .catch(errors => {
                if (errors.response.status == 422) {
                    console.log(errors.response.data.errors);
                }
            });

            // al terminar, obtiene los mejores puntajes del jugador
            axios.get(apiScoresURLS['GET_BEST_USER'] + this.gameId + "/user_id/" + this.userId)
            .then(response => (
                this.scores = response.data
            )).catch(errors => {
                console.log(errors);
            });

            this.gameState = 'ready';
        }
    },
    methods: {
        // Convierte la fecha a un formato legible
        getDate(created_at) {
            var date = new Date(created_at);
            var sDate = date.getDate() + " / " + (date.getMonth() + 1) +" / " + date.getFullYear();
            return sDate;
        }
    }
}
</script>