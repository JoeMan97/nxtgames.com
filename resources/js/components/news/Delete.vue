<!-- Modal para aceptar eliminar una noticia -->
<template>

    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Eliminar Notica
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres eliminar esta noticia?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" v-on:click="deleteNew()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import { apiNewsURLS } from '../../constants.js'

export default {
    methods: {
        deleteNew() {
            this.$emit('deleteButtonPress');
        }
    }
}
</script>