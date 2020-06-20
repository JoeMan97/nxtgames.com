<!-- Contendor para mostrar el listado de noticias -->
<template>

    <div>
        <!-- Muestra un mensaje dependiendo del estatus de la noticia -->
        <div>
            <div class="p-3 mt-4 bg-success text-white" v-if="(status === 'publicada')">Noticia publicada exitósamente</div>
            <div class="p-3 mt-4 bg-info text-white" v-else-if="(status === 'editada')">Noticia editada</div>
            <div class="p-3 mt-4 bg-info text-white" v-else-if="(status === 'eliminada')">Noticia eliminada</div>   
        </div>

        <!-- Spinner que se muestra mientras carga el listado de noticias -->
        <spinner v-if="loading"></spinner>

        <!-- Listado de noticias en forma de cards -->
        <div v-else class="mt-4 card" v-for="neww in newws" v-bind:key="neww.id">
            <div class="card-header"></div>
            <div class="card-body">
                <h4 class="card-title">
                    {{ neww.title }}
                    </h4>
                <div class="card-text mb-3">
                    {{ cutBody(neww.body) }}
                </div>
                <a :href="'/noticias/id/' + neww.id">Ver noticia</a>
            </div>
        </div>
    </div>

</template>
<script>
import { apiNewsURLS } from '../../constants.js'

export default {
    props:{
        // variable que indica el estatus de la noticia
        status: {
            required: true,
        }
    },
    data () {
        return {
            // variable para mostrar y ocultar el spinner
            loading: true,
            // variable para obtener todas las noticias
            newws: [],
        }
    },
    created() {
        // Obtiene todas las noticias
        axios.get(apiNewsURLS["GET_NEWS"]).then(response => (
            this.newws = response.data,

            // Al obtenerlas se oculta el spinner
            this.loading = false
        ));
    },
    methods: {
        // Retorna una parte del cuerpo de la noticia
        cutBody(body) {
            if (body.length < 250) return body;

            body = body.substring(0, 250);

            if (body.substring(body.length -1) === " ") {
                body = body.substring(0, body.length - 1);
            }
                
            if (body.substring(body.length -1) === ".") {
                body = body.substring(0, body.length - 1);
            }

            return body + "...";
        }
    }
}
</script>