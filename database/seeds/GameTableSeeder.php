<?php

use Illuminate\Database\Seeder;
use App\Game;

class GameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Conecta 4
        $game = new Game();
        $game->name = 'Conecta 4';
        $game->description = 'Conecta 4 (también conocido como 4 en Linea en algunas versiones) es un juego de mesa para dos jugadores distribuido por Hasbro, en el que se introducen fichas en un tablero vertical con el objetivo de alinear cuatro consecutivas de un mismo color. Fue creado en 1974 por Ned Strongin y Howard Wexler para Milton Bradley Company.

        El objetivo de Conecta 4 es alinear cuatro fichas sobre un tablero formado por seis filas y siete columnas. Cada jugador dispone de 21 fichas de un color (por lo general, rojas o amarillas). Por turnos, los jugadores deben introducir una ficha en la columna que prefieran (siempre que no esté completa) y ésta caerá a la posición más baja. Gana la partida el primero que consiga alinear cuatro fichas consecutivas de un mismo color en horizontal, vertical o diagonal.​ Si todas las columnas están llenas pero nadie ha hecho una fila válida, hay empate.';
        $game->save();

        // El juego de la vida
        $game = new Game();
        $game->name = 'El juego de la vida';
        $game->description = 'El juego de la vida es un autómata celular diseñado por el matemático británico John H. Conway en 1970.

        Hizo su primera aparición pública en el número de octubre de 1970 de la revista Scientific American, en la columna de juegos matemáticos de Martin Gardner. Desde un punto de vista teórico, es interesante porque es equivalente a una máquina universal de Turing, es decir, todo lo que se puede computar algorítmicamente se puede computar en el juego de la vida.

        Ha atraído mucho interés debido a la gran variabilidad de la evolución de los patrones. Se considera que la vida es un buen ejemplo de emergencia y autoorganización. Es interesante para los científicos, matemáticos, economistas y otros observar cómo patrones complejos pueden provenir de la implementación de reglas muy sencillas.

        Para muchos aficionados, el juego de la vida solo era un desafío de programación y una manera divertida de usar ciclos de la CPU.1​ Para otros, sin embargo, el juego adquirió más connotaciones filosóficas.';
        $game->save();

        // Snake
        $game = new Game();
        $game->name = 'Snake';
        $game->description = 'El Snake (a veces también llamado la serpiente) es un videojuego lanzado a mediados de la década de 1970 que ha mantenido su popularidad desde entonces, convirtiéndose en un clásico. En 1998, el Snake obtuvo una audiencia masiva tras convertirse en un juego estándar pre-grabado en los teléfonos Nokia.

        En el juego, el jugador o usuario controla una larga y delgada criatura, semejante a una serpiente, que vaga alrededor de un plano delimitado, recogiendo alimentos (o algún otro elemento), tratando de evitar golpear a su propia cola o las "paredes" que rodean el área de juego. Cada vez que la serpiente se come un pedazo de comida, la cola crece más, provocando que aumente la dificultad del juego. El usuario controla la dirección de la cabeza de la serpiente (arriba, abajo, izquierda o derecha) y el cuerpo de la serpiente la sigue. Además, el jugador no puede detener el movimiento de la serpiente, mientras que el juego está en marcha.';
        $game->save();

        // Tetris
        $game = new Game();
        $game->name = 'Tetris';
        $game->description = 'Tetris es un videojuego de puzle originalmente diseñado y programado por Alekséi Pázhitnov en la Unión Soviética. Fue lanzado el 6 de junio de 1984,3​ mientras trabajaba para el Centro de Computación Dorodnitsyn de la Academia de Ciencias de la Unión Soviética en Moscú, RSFS de Rusia. Su nombre deriva del prefijo numérico griego tetra- (todas las piezas del juego, conocidas como Tetrominós que contienen cuatro segmentos) y del tenis, el deporte favorito de Pázhitnov.

        Distintos tetriminos, figuras geométricas compuestas por cuatro bloques cuadrados unidos de forma ortogonal, las cuales se generan de una zona que ocupa 5x5 bloques en el área superior de la pantalla. No hay consenso en cuanto a las dimensiones para el área del juego, variando en cada versión. Sin embargo, dos filas de más arriba están ocultas al jugador.';
        $game->save();
    }
}
