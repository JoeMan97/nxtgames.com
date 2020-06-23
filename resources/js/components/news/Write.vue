<!-- Formulario para redactar una noticia -->
<template>

    <form>
        <div class="form-group">
            <label for="input-title">Título</label>
            <input class="form-control" type="text" id="title-input" v-model="neww.title">
        </div>
        <div class="form-group">
            <label cfor="body-textarea">Contenido</label>
            <textarea class="form-control" id="body-textarea" rows="14" v-model="neww.body"></textarea>            
        </div>
        <button class="btn btn-primary" v-on:click="submitNew()">Publicar</button>
    </form>

</template>
<script>
import { apiNewsURLS } from '../../constants.js'

export default {
    data() {
        return {
            // variable hardcodeada para definir el id del usuario que redacta la noticia
            userId: 1,
            // Objeto para definir los atributos de la noticia
            neww: {
                title: null,
                body: null
            },
        }
    },
    methods: {
        // Envia la noticia
        submitNew() {
            axios.post(apiNewsURLS['POST_NEW'], {
                user_id: this.userId,
                title: this.neww.title,
                body: this.neww.body
            })
            .then(function(response){
                // Redirije a la vista donde estan todas las noticias y envia el estatus de "publicada"
                window.location.href = "/noticias/" + "publicada";
            })
            .catch(function(errors) {
                console.log(errors);
            });
        }
    }
}
</script>