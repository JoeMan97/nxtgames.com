<!-- Formulario para editar una noticia -->
<template>

    <!-- Spinner que se muestra mientras carga el listado de noticias -->
    <spinner v-if="loading"></spinner>

    <form v-else>
        <div class="form-group">
            <label for="input-title">Título</label>
            <!-- No es necesario colocar v-bind cuando hay un v-model -->
            <input class="form-control" type="text" id="title-input" v-model="neww.title">
        </div>
        <div class="form-group">
            <label cfor="body-textarea">Contenido</label>
            <textarea class="form-control" id="body-textarea" rows="14" v-model="neww.body"></textarea>            
        </div>
        <button class="btn btn-primary" v-on:click="editNew()">Aceptar</button>
    </form>    
    
</template>
<script>
import { apiNewsURLS } from '../../constants.js'

export default {
    props: {
        // Id de la noticia a editar
        newId: {
            required: false
        }
    },
    data() {
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
    created() {
        // Obtiene la noticia
        axios.get(apiNewsURLS['GET_NEW'] + this.newId)
        .then(response => (
            this.neww = response.data,

            // Al obtenerla se oculta el spinner
            this.loading = false
        ));
    },
    methods: {
        // Envia la noticia actualizada
        editNew() {
            axios.put(apiNewsURLS["PUT_NEW"] + this.newId, {
                title: this.neww.title,
                body: this.neww.body
            })
            .then(function(response) {
                // Redirije a la vista donde estan todas las noticias y envia el estatus de "elminada"
                window.location.href = "/noticias/" + "editada";
            })
            .catch(function(errors) {
                console.log(errors);
            });
        }
    }
}
</script>