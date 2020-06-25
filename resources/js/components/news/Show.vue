<!-- Contendor para mostrar una noticia completa -->
<template>

    <!-- Spinner que se muestra mientras carga el listado de noticias -->
    <spinner v-if="loading"></spinner>
    
    <div v-else class="my-4">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <h4 class="card-title">
                    {{ neww.title }}
                </h4>
                <div class="card-text">
                    {{ neww.body }}
                </div>
                <div class="mt-3">
                    <a :href="'/noticias/editar/' + neww.id" class="btn btn-primary mr-2">Editar</a>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#delete-modal">Eliminar</button>
                    <delete-new v-on:deleteButtonPress="deleteNew()"></delete-new>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import { apiNewsURLS } from '../../constants.js'

export default {
    data () {
        return {
            // variable para mostrar y ocultar el spinner
            loading: true,
            // Objeto para obtener los atributos de la noticia
            neww: {
                title: null,
                body: null
            }
        }
    },
    props: {
        newId: {
            required: true
        }
    },
    created() {
        // Obtiene la noticia
        axios.get(apiNewsURLS['GET_NEW'] + this.newId)
        .then(response => (
            this.neww = response.data,

            // Al obtenerla se oculta el spinner
            this.loading = false
        )).catch(function(errors) {
            console.log(errors);
        });
    },
    methods: {
        // Elimina la noticia
        deleteNew() {
            axios
            .delete(apiNewsURLS['DELETE_NEW'] + this.newId)
            .then(function(response) {
                // Redirije a la vista donde estan todas las noticias y envia el estatus de "elminada"
                window.location.href = "/noticias/" + "eliminada";
            })
            .catch(function(errors) {
                console.log(errors);
            });
        }
    }
}
</script>