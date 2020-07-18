<!-- Modal para cuando se pause un juego -->
<!-- Notar que este componente no esta registrado globalmente, solo en el componente padre -->
<template>

    <!-- data-backdrop="static" es lo que hace que no se quite el modal sin presionar el boton de cerrar -->
    <div class="modal" id="paused-game-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Pausa
                    </h5>
                    <button type="button" class="close" v-on:click="continueGame()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Presiona el botón Continuar, la tecla Esc o la tecla Enter.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" v-on:click="continueGame()">Continuar</button>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    methods: {
        // emite el evento continueButtonPress en el componente padre
        continueGame() {
            this.$emit('continueButtonPress');
        }
    }
}
</script>