<!-- Componente para interactuar con el juego tetris -->
<template>

    <div class="container p-3" id="tetris">
        <div class="row justify-content-center">
            <!-- seccion principal -->
            <div id="screen" class="border shadow" style="width: 400px; height: 720px; position: relative;">

            </div>

            <!-- columna de estadisticas -->
            <div class="px-3 d-flex flex-column">
                <h4>Puntaje</h4>
                <div class="p-1 border" id="score">
                    {{ score }}
                </div>
                <h4 class="mt-3">Nivel</h4>
                <div class="p-1 border" id="level">
                    {{ level }}
                </div>
                <h4 class="mt-3">Siguiente Tetrominó</h4>
                <div class="p-1 border align-self-center" id="screen2" style="width: 160px; height: 160px; position: relative;">
                    
                </div>
                <div class="flex-fill d-flex flex-column justify-content-end">
                    <button class="mt-2 btn btn-primary" v-on:click="manageState()">{{ playBtnTxt }}</button>
                    <button class="mt-2 btn btn-danger" v-on:click="restartGame()">Reiniciar</button>              
                </div>
            </div>
        </div>
        <paused-game v-on:continueButtonPress="continueGame()"></paused-game>
        <game-over :game-state="gameState" :score="score" :user-id="userId"></game-over>
    </div>

</template>
<script>
// Componente importado de manera local
import PausedGame from './PausedGame.vue';
import GameOver from './GameOver.vue';

export default {
    components: {
        'paused-game': PausedGame,
        'game-over': GameOver
    },
    props: {
        userId: {
            required: true
        }
    },
    data() {
        return {
            // para saber el esstado en en que se encuentra el juego
            gameState: String,

            // ...Mostrar el texto del boton gris
            playBtnTxt: String,

            // ...Manipular el tetromino que se aparezca en la pantalla
            currentTet: new Array(),

            // ...Definir la funcion que se ejecutara cada x milisegundos
            interval: null,

            // ...Almacenar todos los divs que se vayan creando
            divs: new Array(),

            // ...Saber la forma del tetromino
            tetType: String,

            // ...Saber la orientacion del tetromino
            tetOrientation: Number,

            // ...Mostrar el nivel del juego
            level: String,

            // ...Mostrar el puntaje
            score: Number,

            // ...Saber el numero de lineas que se van borrando
            linesDeleted: Number,

            // ...Saber cuanto puntaje se debe aumentar
            scoreAddition: Number,

            // ...Aumentar la velocidad del juego en cada nivel
            intervalTime: Number,

            // ...Saber cual sera el siguiente tetromino
            nextTet: Number
        }
    },
    mounted() {
        window.addEventListener('keydown', (event) => {
            switch (event.key) {
                case 'ArrowUp': // arriba
                    event.preventDefault();
                case 'W':
                case 'w':
                    if (this.gameState === 'playing') this.rotateTet();
                    break;
                case 'ArrowLeft': // izquierda
                case 'A':  
                case 'a':
                    if (this.tetHasSpace('left') && this.gameState === 'playing') this.moveTet('left');
                    break;
                case 'ArrowDown': // abajo
                    event.preventDefault();
                case 'S':
                case 's':
                    if (this.tetHasSpace('down') && this.gameState === 'playing') this.moveTet('down');
                    break;
                case 'ArrowRight': // derecha
                case 'D':
                case 'd':
                    if (this.tetHasSpace('right') && this.gameState === 'playing') this.moveTet('right');
                    break;
                case 'R':
                case 'r':
                        this.restartGame();
                        this.startGame();
                    break;
                case 'Enter':
                    event.preventDefault();
                case 'Escape':
                    this.manageState();
                    break;  
            }
        }, false); 

        this.initValues();
    },
    methods: {
        // Empieza, pausa, o continua el juego
        manageState() {
            if (this.gameState === 'ready') {
                this.startGame();
            } else if (this.gameState === 'playing') {
                this.pauseGame();
            } else if (this.gameState === 'paused') {
                this.continueGame();
            } else if (this.gameState === 'over') {
                this.restartGame();
                this.startGame();
            }
        },

        // Empieza el juego
        startGame() {
            this.gameState = 'playing';
            this.playBtnTxt = "Pausa";

            this.nextTet = this.getRandomInt(1, 7);
            this.putTetromino("screen");
            this.putTetromino("screen2");
            this.interval = setInterval(this.manageGame, this.intervalTime);
        },

        // Pausa el juego y abre el modal
        pauseGame() {
            clearInterval(this.interval);

            $("#paused-game-modal").modal('show');

            this.gameState = 'paused';
            this.playBtnTxt = "Continuar";
        },

        // Cierra el modal y continua el juego
        continueGame() {
            $("#paused-game-modal").modal('hide');

            this.interval = setInterval(this.manageGame, this.intervalTime);

            this.gameState = 'playing';
            this.playBtnTxt = "Pausa";
        },

        // Asigna valores iniciales
        initValues() {
            this.gameState = 'ready',
            this.playBtnTxt = "Jugar",
            this.tetOrientation = 1;
            this.level = "01";
            this.score = 0;
            this.linesDeleted = 0;
            this.scoreAddition = 18;
            this.intervalTime = 500;

            for (let l = 0; l < 18; l++) {
                let row = [];
                for (let m = 0; m < 10; m++) {
                    row[m] = null;
                }
                this.divs[l] = row;   
            }
        },

        // Reinicia el juego
        restartGame(){ 
            $("#game-over-modal").modal('hide');

            this.initValues();

            clearInterval(this.interval);

            document.querySelector("#screen").innerHTML = null;
            document.querySelector("#screen2").innerHTML = null;
        },

        // Funcion principal: Es llamada cada x milisegundos a lo largo del juego
        manageGame() {
            if (this.tetIsInside() && this.tetHasSpace('down')) {
                this.moveTet('down');
            } else {
                let rows = new Array();
                let l = 0;
                this.currentTet.forEach(square => {
                    let col = this.getPosition(square, 'left') / 40;
                    let row = this.getPosition(square, 'top') / 40;

                    this.divs[row][col] =  square;

                    if (!rows.includes(row)) { 
                        rows[l] = row;
                        l++;
                    }
                });
                
                // Es importante que este ordenada la matriz
                this.checkRows(rows.sort()); 

                this.score += this.scoreAddition;

                this.manageValues();
                
                // Aqui se verifica si el jugador perdio
                if (this.divs[1][5]) {
                    this.gameState = 'over';
                    this.playBtnTxt = "Jugar";    

                    clearInterval(this.interval);
                    $('#game-over-modal').modal('show');
                } else {
                    this.putTetromino("screen");
                    document.querySelector("#screen2").innerHTML = null;
                    this.putTetromino("screen2");
                }
            }
        },

        // Gestiona los valores del juego (nivel, puntaje, etc.)
        manageValues(){ 
            if((this.linesDeleted >= 20) && (this.linesDeleted < 40)) {
                this.intervalTime = 450;
                this.level = "02";
            } else if((this.linesDeleted >= 40) && (this.linesDeleted < 60)) {
                this.intervalTime = 400;
                this.level = "03";
            } else if ((this.linesDeleted >= 60) && (this.linesDeleted < 80)) {
                this.intervalTime = 350;
                this.level = "04";
            } else if ((this.linesDeleted >= 80) && (this.linesDeleted < 100)) {
                this.scoreAddition = 17;
                tthis.intervalTime= 300;
                this.level = "05";
            } else if((this.linesDeleted >= 100) && (this.linesDeleted < 120)) {
                this.intervalTime = 275;
                this.level = "06";
            } else if((this.linesDeleted >= 120) && (this.linesDeleted < 150)) {
                this.intervalTime = 250;
                this.level = "07";
            } else if (this.linesDeleted >= 150) {
                this.gameState = 'over';
                clearInterval(this.interval);
                $('#game-over-modal').modal('show');
            }
        },

        // Checa si debe eliminar las filas
        checkRows(rows) {
            let rowsRemoved = 0;
            for (let l = 0; l < rows.length; l++) {
                let squaresNumber = 0;

                // en cada fila...
                for (let m = 0; m < 10; m++) {
                    // se revisa cuantos cuadrados hay
                    if (this.divs[rows[l]][m]) squaresNumber++;
                }

                // si hay 10...
                if (squaresNumber === 10) {             
                    // se elimina la fila en la pantalla
                    for (let m = 0; m < 10; m++) {
                        this.divs[rows[l]][m].remove();
                    }

                    // se bajan los cuadrados que quedaron en el aire
                    for (let m = rows[l] - 1; m >= 0; m--) {
                        for (let n = 0; n < 10; n++) {
                            if (this.divs[m][n]) this.moveSquare(this.divs[m][n], 40, 0);
                        }
                    }

                    // se elimina el elemento rows[l] de la matriz divs
                    this.divs.splice(rows[l], 1);
                    // se agrega un nuevo elemento al inicio de la matriz divs
                    this.divs.unshift([null, null, null, null, null, null, null, null, null, null]);

                    rowsRemoved++;
                }
            }

            // se suma cierto puntaje segun el numero de lineas eliminadas
            if (rowsRemoved) {
                if (rowsRemoved === 1) this.score += 40;
                else if (rowsRemoved === 2) this.score += 100;
                else if (rowsRemoved === 3) this.score += 300;
                else if (rowsRemoved === 4) this.score += 1200;

                this.linesDeleted += rowsRemoved;    
            } 
        },

        // Verifica si tetromino tiene espacio para poder moverse
        tetHasSpace(direction) {
            let rowOffset = 0, colOffset = 0;

            switch (direction) {
                case 'left':
                    colOffset = -1;
                    break;
                case 'right':
                    colOffset = 1;
                    break;
                case 'down':
                    rowOffset = 1;
                    break;
            }

            let row, col;

            row = this.getPosition(this.currentTet[0], 'top') / 40;
            col = this.getPosition(this.currentTet[0], 'left') / 40;
            let cell1 = this.divs[row + rowOffset][col + colOffset];

            row = this.getPosition(this.currentTet[1], 'top') / 40;
            col= this.getPosition(this.currentTet[1], 'left') / 40;
            let cell2 = this.divs[row + rowOffset][col + colOffset];

            row = this.getPosition(this.currentTet[2], 'top') / 40;
            col = this.getPosition(this.currentTet[2], 'left') / 40;
            let cell3 = this.divs[row + rowOffset][col + colOffset];

            row = this.getPosition(this.currentTet[3], 'top') / 40;
            col = this.getPosition(this.currentTet[3], 'left') / 40;
            let cell4 = this.divs[row + rowOffset][col + colOffset];

            return (cell1 === null && cell2 === null &&
                cell3 === null && cell4 === null)? true : false;
        },

        // Verifica que el tretomino este dentro del limite inferior
        tetIsInside() {
            let position1 = this.getPosition(this.currentTet[0], 'top');
            let position2 = this.getPosition(this.currentTet[1], 'top');
            let position3 = this.getPosition(this.currentTet[2], 'top');
            let position4 = this.getPosition(this.currentTet[3], 'top');
            return (position1 < 680 && position2 < 680 && position3 < 680 && position4 < 680)? true : false;
        },

        // Obtiene los pixeles de la propieded .left o .top de un elemento
        getPosition(element, side) {
            let value;
            switch (side) {
                case 'left':
                    value = String(element.style.left);
                break;
                case 'right':
                    value = String(element.style.right);
                break;
                case 'top':
                    value = String(element.style.top);
                break;
                case 'bottom':
                    value = String(element.style.bottom);
                break;
            }

            return Number(value.substring(0,  value.length - 2));
        },

        // Mueve el tetromino en alguna direccion
        moveTet(direction) {
            switch (direction) {
                case 'left':
                    this.currentTet.forEach(square => {
                        let newleft = this.getPosition(square, 'left') - 40;
                        square.style.left = newleft + "px";    
                    });
                    break;
                case 'right':
                    this.currentTet.forEach(square => {
                        let newleft = this.getPosition(square, 'left') + 40;
                        square.style.left = newleft + "px";    
                    });
                    break;
                case 'down':
                    this.currentTet.forEach(square => {
                        let newTop = this.getPosition(square, 'top') + 40;
                        square.style.top = newTop + "px";    
                    });
                    break;
            }
        },
        
        // Verifica si un cuadrado puede ocupar un lugar de la matriz divs
        squareCanOcupy(square, rowOffset, colOffset) {
            let row = this.getPosition(square, 'top') / 40;
            let col = this.getPosition(square, 'left') / 40;
            return (this.divs[row + rowOffset][col + colOffset] === null)? true : false;
        },

        // Mueve un cuadrado
        moveSquare(square, topOffset, leftOffset) {
            let newTop = this.getPosition(square, 'top') + topOffset;
            square.style.top = newTop + "px";

            let newLeft = this.getPosition(square, 'left') + leftOffset;
            square.style.left =  newLeft + "px";
        },

        // Rota el tetromino
        rotateTet() {
            switch (this.tetType) {
                case 'I':
                    if (this.tetOrientation == 1) {
                        // si cada div puede estar en el nuevo lugar...
                        if (this.squareCanOcupy(this.currentTet[0], -1, 1) &&
                        this.squareCanOcupy(this.currentTet[2], 1, -1) &&
                        this.squareCanOcupy(this.currentTet[3], 2, -2)) {
                            // se coloca cada uno en el nuevo lugar
                            this.moveSquare(this.currentTet[0], -40, 40);
                            this.moveSquare(this.currentTet[2], 40, -40);
                            this.moveSquare(this.currentTet[3], 80, -80);
                            this.tetOrientation = 2;
                        }
                    } else if (this.tetOrientation == 2) {
                        if (this.squareCanOcupy(this.currentTet[0], 1, -1) &&
                        this.squareCanOcupy(this.currentTet[2], -1, 1) &&
                        this.squareCanOcupy(this.currentTet[3], -2, 2)) {
                            this.moveSquare(this.currentTet[0], 40, -40);
                            this.moveSquare(this.currentTet[2], -40, 40);
                            this.moveSquare(this.currentTet[3], -80, 80);
                            this.tetOrientation = 1;    
                        }
                    }
                    break;
                case 'T':
                    if (this.tetOrientation == 1) {
                        if (this.squareCanOcupy(this.currentTet[1], -1, 0)) {
                            this.moveSquare(this.currentTet[1], -40, 0);
                            this.moveSquare(this.currentTet[2], 0, -40);
                            this.tetOrientation = 2;
                        }
                    } else if (this.tetOrientation == 2) {
                        if (this.squareCanOcupy(this.currentTet[2], 0, 1)) {
                            this.moveSquare(this.currentTet[3], -40, 0);
                            this.moveSquare(this.currentTet[2], 0, 40);                        
                            this.tetOrientation = 3;
                        }
                    } else if (this.tetOrientation == 3) {
                        if (this.squareCanOcupy(this.currentTet[3], 1, 0)) {
                            this.moveSquare(this.currentTet[0], 0, 40);
                            this.moveSquare(this.currentTet[3], 40, 0);
                            this.tetOrientation = 4;
                        }
                    } else if (this.tetOrientation == 4) {
                        if (this.squareCanOcupy(this.currentTet[0], 0, -1)) {
                            this.moveSquare(this.currentTet[0], 0, -40);
                            this.moveSquare(this.currentTet[1], 40, 0);
                            this.tetOrientation = 1;                            
                        }
                    }
                    break;
                case 'J':
                    if (this.tetOrientation == 1) {
                        if (this.squareCanOcupy(this.currentTet[0], -1, 1) &&
                        this.squareCanOcupy(this.currentTet[2], 1, -1) &&
                        this.squareCanOcupy(this.currentTet[3], 0, -2)) {
                            this.moveSquare(this.currentTet[0],-40 , 40);
                            this.moveSquare(this.currentTet[2], 40, -40);
                            this.moveSquare(this.currentTet[3], 0, -80);
                            this.tetOrientation = 2;
                        }
                    } else if (this.tetOrientation == 2) {
                        if (this.squareCanOcupy(this.currentTet[0], 1, 1) &&
                        this.squareCanOcupy(this.currentTet[2], -1, -1) &&
                        this.squareCanOcupy(this.currentTet[3], -2, 0)) {
                            this.moveSquare(this.currentTet[0], 40, 40);
                            this.moveSquare(this.currentTet[2], -40, -40);
                            this.moveSquare(this.currentTet[3], -80, 0);
                            this.tetOrientation = 3;
                        }
                    } else if (this.tetOrientation == 3) {
                        if (this.squareCanOcupy(this.currentTet[0], 1, -1) &&
                        this.squareCanOcupy(this.currentTet[2], -1, 1) &&
                        this.squareCanOcupy(this.currentTet[3], 0, 2)) {
                            this.moveSquare(this.currentTet[0], 40, -40);
                            this.moveSquare(this.currentTet[2], -40, 40);
                            this.moveSquare(this.currentTet[3], 0, 80);
                            this.tetOrientation = 4;
                        }
                    } else if (this.tetOrientation == 4) {
                        if (this.squareCanOcupy(this.currentTet[0], -1, -1) &&
                        this.squareCanOcupy(this.currentTet[2], 1, 1) &&
                        this.squareCanOcupy(this.currentTet[3], 2, 0)) {
                            this.moveSquare(this.currentTet[0], -40, -40);
                            this.moveSquare(this.currentTet[2], 40, 40);
                            this.moveSquare(this.currentTet[3], 80, 0);
                            this.tetOrientation = 1;
                        }
                    }
                    break;
                case 'L':
                    if (this.tetOrientation == 1) {
                        if (this.squareCanOcupy(this.currentTet[0], 2, 0) &&
                        this.squareCanOcupy(this.currentTet[1], -1, 1) &&
                        this.squareCanOcupy(this.currentTet[3], 1, -1)) {
                            this.moveSquare(this.currentTet[0], 80, 0);
                            this.moveSquare(this.currentTet[1], -40, 40);
                            this.moveSquare(this.currentTet[3], 40, -40);
                            this.tetOrientation = 2;
                        }
                    } else if (this.tetOrientation == 2) {
                        if (this.squareCanOcupy(this.currentTet[0], 0, -2) &&
                        this.squareCanOcupy(this.currentTet[1], 1, 1) &&
                        this.squareCanOcupy(this.currentTet[3], -1, -1)) {
                            this.moveSquare(this.currentTet[0], 0, -80);
                            this.moveSquare(this.currentTet[1], 40, 40);
                            this.moveSquare(this.currentTet[3], -40, -40);
                            this.tetOrientation = 3;
                        }
                    } else if (this.tetOrientation == 3) {
                        if (this.squareCanOcupy(this.currentTet[0], -2, 0) &&
                        this.squareCanOcupy(this.currentTet[1], 1, -1) &&
                        this.squareCanOcupy(this.currentTet[3], -1, 1)) {
                            this.moveSquare(this.currentTet[0], -80, 0);
                            this.moveSquare(this.currentTet[1], 40, -40);
                            this.moveSquare(this.currentTet[3], -40, 40);
                            this.tetOrientation = 4;
                        }
                    } else if (this.tetOrientation == 4) {
                        if (this.squareCanOcupy(this.currentTet[0], 0, 2) &&
                        this.squareCanOcupy(this.currentTet[1], -1, -1) &&
                        this.squareCanOcupy(this.currentTet[3], 1, 1)) {
                            this.moveSquare(this.currentTet[0], 0, 80);
                            this.moveSquare(this.currentTet[1], -40, -40);
                            this.moveSquare(this.currentTet[3], 40, 40);
                            this.tetOrientation = 1;
                        }
                    }
                    break;
                case 'S':
                    if (this.tetOrientation == 1) {
                        if (this.squareCanOcupy(this.currentTet[0], 0, 2) &&
                        this.squareCanOcupy(this.currentTet[1], -2, 0)) {
                            this.moveSquare(this.currentTet[0], 0, 80);
                            this.moveSquare(this.currentTet[1], -80, 0);
                            this.tetOrientation = 2;
                        }
                        
                    } else if (this.tetOrientation == 2) {
                        if (this.squareCanOcupy(this.currentTet[0], 0, -2) &&
                        this.squareCanOcupy(this.currentTet[1], 2, 0)) {
                            this.moveSquare(this.currentTet[0], 0, -80);
                            this.moveSquare(this.currentTet[1], 80, 0);
                            this.tetOrientation = 1;
                        }
                    }
                    break;
                case 'Z':
                    if (this.tetOrientation == 1) {
                        if (this.squareCanOcupy(this.currentTet[0], 0, 2) &&
                        this.squareCanOcupy(this.currentTet[1], 2, 0)) {
                            this.moveSquare(this.currentTet[0], 0, 80);
                            this.moveSquare(this.currentTet[1], 80, 0);
                            this.tetOrientation = 2;
                        }
                    } else if (this.tetOrientation == 2) {
                        if (this.squareCanOcupy(this.currentTet[0], 0, -2) &&
                        this.squareCanOcupy(this.currentTet[1], -2, 0)) {
                            this.moveSquare(this.currentTet[0], 0, -80);
                            this.moveSquare(this.currentTet[1], -80, 0);
                            this.tetOrientation = 1;
                        }
                    }
                    break;
            }
        },

        // Pone un tetromino en una de las 2 pantallas
        putTetromino(location) {
            // se definen los estilos para los divs cuadrados
            let basicStyle = "display: inline-block; width: 40px; height: 40px; position: absolute;"

            let cyanSquareStyle = basicStyle + "background: cyan;";
            let yellowSquareStyle = basicStyle + "background: yellow;";
            let magentaSquareStyle = basicStyle + "background: magenta;";
            let blueSquareStyle = basicStyle + "background: blue;";
            let orangeSquareStyle = basicStyle + "background: orange;";
            let lawnGreenSquareStyle = basicStyle + "background: lawnGreen;";
            let redSquareStyle = basicStyle + "background: red;";

            let screen = document.querySelector("#" + location);

            // se cren los cuadrado del tetromino
            let squareArray = [document.createElement("div"),
                document.createElement("div"),
                document.createElement("div"),
                document.createElement("div")];

            let left, top = 40;

            // se verifica la pantalla para decidir que hacer
            let number;
            if (location === 'screen') {
                left = 120;
                this.currentTet = squareArray;
                this.tetOrientation = 1;                
                number = this.nextTet;
            } else if (location === 'screen2') {
                left = 0;
                number = this.getRandomInt(1, 7);
                this.nextTet = number;
            }

            // se decide como hay que acomodar cada cuadrado
            switch (number) {
                case 1: // I
                    if (location === 'screen') this.tetType = 'I';

                    squareArray.forEach(square => {
                        square.style.cssText = cyanSquareStyle;
                    });

                    squareArray[0].style.top = top + 'px'; squareArray[0].style.left = left + 'px'; 
                    squareArray[1].style.top = top + 'px'; squareArray[1].style.left = left + 40 + 'px';
                    squareArray[2].style.top = top + 'px'; squareArray[2].style.left = left + 80 +'px';
                    squareArray[3].style.top = top + 'px'; squareArray[3].style.left = left + 120 + 'px';
                    break;
                case 2: // O
                    if (location === 'screen') this.tetType = 'O';

                    squareArray.forEach(square => {
                        square.style.cssText = yellowSquareStyle;
                    });

                    squareArray[0].style.top = top + 'px'; squareArray[0].style.left = left + 40 + 'px'; 
                    squareArray[1].style.top = top + 'px'; squareArray[1].style.left = left + 80 + 'px';
                    squareArray[2].style.top = top + 40 + 'px'; squareArray[2].style.left = left + 40 + 'px';
                    squareArray[3].style.top = top + 40 + 'px'; squareArray[3].style.left = left + 80 + 'px';
                    break;
                case 3: // T
                    if (location === 'screen') this.tetType = 'T';

                    squareArray.forEach(square => {
                        square.style.cssText = magentaSquareStyle;
                    });

                    squareArray[0].style.top = top + 'px'; squareArray[0].style.left = left + 'px'; 
                    squareArray[1].style.top = top + 'px'; squareArray[1].style.left = left + 40 + 'px';
                    squareArray[2].style.top = top + 'px'; squareArray[2].style.left = left + 80 + 'px';
                    squareArray[3].style.top = top + 40 + 'px'; squareArray[3].style.left = left + 40 + 'px';
                    break;
                case 4: // J
                    if (location === 'screen') this.tetType = 'J';

                    squareArray.forEach(square => {
                        square.style.cssText = blueSquareStyle;
                    });

                    squareArray[0].style.top = top + 'px'; squareArray[0].style.left = left + 'px'; 
                    squareArray[1].style.top = top + 'px'; squareArray[1].style.left = left + 40 + 'px';
                    squareArray[2].style.top = top + 'px'; squareArray[2].style.left = left + 80 + 'px';
                    squareArray[3].style.top = top + 40 + 'px'; squareArray[3].style.left = left + 80 + 'px';
                    break;
                case 5: // L
                    if (location === 'screen') this.tetType = 'L';

                    squareArray.forEach(square => {
                        square.style.cssText = orangeSquareStyle;
                    });

                    squareArray[0].style.top = top + 'px'; squareArray[0].style.left = left + 80 + 'px'; 
                    squareArray[1].style.top = top + 40 + 'px'; squareArray[1].style.left = left + 'px';
                    squareArray[2].style.top = top + 40 + 'px'; squareArray[2].style.left = left + 40 + 'px';
                    squareArray[3].style.top = top + 40 + 'px'; squareArray[3].style.left = left + 80 + 'px';
                    break;
                case 6: // S
                    if (location === 'screen') this.tetType = 'S';

                    squareArray.forEach(square => {
                        square.style.cssText = lawnGreenSquareStyle;
                    });

                    squareArray[0].style.top = top + 40 + 'px'; squareArray[0].style.left = left + 'px'; 
                    squareArray[1].style.top = top + 40 + 'px'; squareArray[1].style.left = left + 40 + 'px';
                    squareArray[2].style.top = top + 'px'; squareArray[2].style.left = left + 40 + 'px';
                    squareArray[3].style.top = top + 'px'; squareArray[3].style.left = left + 80 + 'px';
                    break;
                case 7: // Z
                    if (location === 'screen') this.tetType = 'Z';

                    squareArray.forEach(square => {
                        square.style.cssText = redSquareStyle;
                    });

                    squareArray[0].style.top = top + 'px'; squareArray[0].style.left = left + 'px'; 
                    squareArray[1].style.top = top + 'px'; squareArray[1].style.left = left + 40 + 'px';
                    squareArray[2].style.top = top + 40 + 'px'; squareArray[2].style.left = left + 40 + 'px';
                    squareArray[3].style.top = top + 40 + 'px'; squareArray[3].style.left = left + 80 + 'px';
                    break;
            }

            // coloca el tetromino en la pantalla correspondiente
            squareArray.forEach(square => {
                screen.appendChild(square);
            });
        },

        // Obtiene un numero aleatorio entre min (inclusivo) y max (inclusivo)
        getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        },
    }
}
</script>