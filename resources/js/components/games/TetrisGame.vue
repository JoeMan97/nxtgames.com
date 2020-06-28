<!-- Componente para visualizar el juego en si -->
<template>

    <div class="container p-3" id="tetris">
        <div class="row justify-content-center">
            <!-- seccion donde se colocan los tetrominos -->
            <div id="screen" class="border" style="width: 400px; height: 720px">

            </div>

            <!-- columna de estadisticas -->
            <div class="px-3 d-flex flex-column">
                <h4>Puntaje</h4>
                <div class="p-1 border" id="score">
                    0000
                </div>
                <h4 class="mt-3">Nivel</h4>
                <div class="p-1 border" id="level">
                    00
                </div>
                <h4 class="mt-3">Siguiente Tetrominó</h4>
                <div class="p-1 border" id="next" style="height: 160px;">
                    
                </div>
                <div class="flex-fill d-flex flex-column justify-content-end">
                    <button class="mt-2 btn btn-secondary">Pausa</button>
                    <button class="mt-2 btn btn-danger">Reiniciar</button>              
                </div>
            </div>
        </div>
    </div>

</template>
<style scoped>

</style>
<script>

</script>
