<!-- Formulario para editar una noticia -->
<template>

    <!-- Spinner que se muestra mientras carga el listado de noticias -->
    <spinner v-if="loading"></spinner>

    <form v-else @submit.prevent="editNew">
        <div class="form-group">
            <label for="input-title">Título</label>
            <!-- No es necesario colocar v-bind cuando hay un v-model -->
            <input class="form-control" :class="compClassesTitle" type="text" id="title-input" v-model="neww.title">
            <span v-if="errors.title" class="invalid-feedback" role="alert">{{ errors.title[0] }}</span>
        </div>
        <div class="form-group">
            <label cfor="body-textarea">Contenido</label>
            <textarea class="form-control" :class="compClassesBody" id="body-textarea" rows="14" v-model="neww.body"></textarea>      
            <span v-if="errors.body" class="invalid-feedback" role="alert">{{ errors.body[0] }}</span>      
        </div>
        <input type="submit" class="btn btn-primary" value="Aceptar">
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
            },
            // Arreglo para obtener posibles errores al enviar la noticia
            errors: [],

            submitAttemp: false
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
            axios.put(apiNewsURLS['PUT_NEW'] + this.newId, {
                title: this.neww.title,
                body: this.neww.body
            })
            .then(function(response) {
                // Redirije a la vista donde estan todas las noticias y envia el estatus de "elminada"
                window.location.href = "/noticias/" + "editada";
            })
            // Obtiene los posibles errores al enviar la noticia
            .catch(errors => {
                if (errors.response.status == 422) {
                    this.errors = errors.response.data.errors;
                    this.submitAttemp = true;
                }
            });
        }
    },
    computed: {
        // Cambian el estilo de los inputs segun si hay errores
        compClassesTitle: function(){
            return{
                "is-invalid": this.errors.title,
                "is-valid": (!this.errors.title && this.submitAttemp)
            }
        },
        compClassesBody: function(){
            return{
                "is-invalid": this.errors.body,
                "is-valid": (!this.errors.body && this.submitAttemp)
            }
        }
    }

}
</script>