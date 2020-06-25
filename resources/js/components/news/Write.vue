<!-- Formulario para redactar una noticia -->
<template>

    <form @submit.prevent="submitNew">
        <div class="form-group">
            <label for="input-title">Título</label>
            <input v-error="errors.title" class="form-control" type="text" id="title-input" v-model="neww.title">
            <span v-if="errors.title" class="invalid-feedback" role="alert">{{ errors.title[0] }}</span>
        </div>
        <div class="form-group">
            <label cfor="body-textarea">Contenido</label>
            <textarea v-error="errors.body" class="form-control" id="body-textarea" rows="14" v-model="neww.body"></textarea>            
            <span v-if="errors.body" class="invalid-feedback" role="alert">{{ errors.body[0] }}</span>
        </div>
        <input type="submit" class="btn btn-primary" value="Publicar">
    </form>

</template>
<script>
import { apiNewsURLS } from '../../constants.js'

export default {
    props: {
        // Id del usuario quien redacta la noticia
        userId: {
            required: true
        }
    },
    data() {
        return {
            // Objeto para definir los atributos de la noticia
            neww: {
                title: null,
                body: null
            },
            // Variable para almacenar posibles errores al enviar la noticia
            errors: [],
            // Variable para saber si ya se intento enviar la noticia
            submitAttemp: false
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
            .catch(errors => {
                if (errors.response.status == 422) {
                    this.errors = errors.response.data.errors;
                    this.submitAttemp = true;
                }
            });
        }
    },
    directives: {
        // Cambia el estilo de los inputs segun si hay errores
        error: {
            componentUpdated(el, binding, vnode) {
                // Si hay un error y ya se intento enviar la noticia...
                if (binding.value && vnode.context.submitAttemp) {
                    el.classList.add("is-invalid");
                    el.classList.remove("is-valid");
                } else if (vnode.context.submitAttemp) {
                    el.classList.add("is-valid");
                    el.classList.remove("is-invalid");
                }
            }
        }
    }
}
</script>