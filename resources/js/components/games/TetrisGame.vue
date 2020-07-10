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
                    0000
                </div>
                <h4 class="mt-3">Nivel</h4>
                <div class="p-1 border" id="level">
                    01
                </div>
                <h4 class="mt-3">Siguiente Tetrominó</h4>
                <div class="p-1 border" id="screen2" style="height: 160px;">
                    
                </div>
                <div class="flex-fill d-flex flex-column justify-content-end">
                    <button class="mt-2 btn btn-secondary" v-on:click="manageGame()">{{ playBtnTxt }}</button>
                    <button class="mt-2 btn btn-danger" v-on:click="restartGame()">Reiniciar</button>              
                </div>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    data() {
        return {
            // para saber el esstado en en que se encuentra el juego
            gameState: 'ready',

            // para el texto del boton gris
            playBtnTxt: "Jugar",

            // para manipular el tetromino que se aparezca en la pantalla
            currentTet: new Array(),

            // para definir la funcion que se ejecutara cada x milisegundos
            interval: null,

            // para saber si en una celda hay un cuadrado o no
            booleans: new Array(),

            // para almacenar todos los divs que se vayan creando
            divs: new Array(),

            // para saber la forma del tetromino
            tetType: String,

            // para saber la orientacion del tetromino
            tetOrientation: Number
        }
    },
    methods: {
        // empieza o pausa el juego
        manageGame() {
            if (this.gameState === 'ready') {
                this.startGame();
            } else if (this.gameState === 'playing') {
                this.pauseGame();
            } else if (this.gameState === 'paused') {
                this.continueGame();
            }
        },

        // asigna valores iniciales
        initValues() {
            this.gameState = 'playing';
            this.playBtnTxt = "Pausa";

            // inicializan la matriz booleans
            for (let l = 0; l < 20; l++) {
                let row = [];
                for (let m = 0; m < 12; m++) {
                    row[m] = false;
                }
                this.booleans[l] = row;   
            }

            for (let l = 1; l < 19; l++) {
                for (let m = 1; m < 11; m++) {
                    this.booleans[l][m] = true;
                }                
            }

            // inicializa la matriz de divs
            for (let l = 0; l < 18; l++) {
                let row = [];
                for (let m = 0; m < 10; m++) {
                    row[m] = null;
                }
                this.divs[l] = row;   
            }
        },

        // empieza el juego
        startGame() {
            this.initValues();
            this.putTetromino("screen");
            this.interval = setInterval(this.carryTetromino, 500);
        },

        // pausa el juego
        pauseGame() {
            this.gameState = 'paused';
            this.playBtnTxt = "Continuar";
            clearInterval(this.interval);
        },

        continueGame() {
            this.gameState = 'playing';
            this.playBtnTxt = "Pausa";
            this.interval = setInterval(this.carryTetromino, 500);
        },

        restartGame(){
            this.gameState = 'ready';
            this.playBtnTxt = "Jugar";    
            
            clearInterval(this.interval);
            document.querySelector("#screen").innerHTML = null;
        },

        // "baja" el tetromino 40px
        carryTetromino() {
            if (this.tetHaveSpace('down')) {
                this.moveTet('down');
            } else {
                let rows = new Array();
                let l = 0;
                this.currentTet.forEach(square => {
                    let col = this.getPosition(square, 'left') / 40;
                    let row = this.getPosition(square, 'top') / 40;
                    this.booleans[row + 1][col + 1] = false;

                    this.divs[row][col] =  square;

                    if (!rows.includes(row)) { 
                        rows[l] = row;
                        l++;
                    }
                });

                this.checkRows(rows);

                this.putTetromino("screen");
            }
        },

        // checa las filas donde se ponen los tetrominos para ver si hay que eliminarlas
        checkRows(rows) {
            let rowsRemoved = false;
            for (let l = 0; l < rows.length; l++) {
                let squaresNumber = 0;

                // en cada fila...
                for (let m = 0; m < 10; m++) {
                    // se revisa cuantos cuadrados hay
                    if (this.divs[rows[l]][m]) squaresNumber++;
                }

                // si hay 10...
                if (squaresNumber === 10) {             
                    // se eliminan todos los de la fila
                    for (let m = 0; m < 10; m++) {
                        this.divs[rows[l]][m].remove();
                        this.divs[rows[l]][m] = null;

                        // se libera el espacio en la matriz booleans
                        this.booleans[rows[l] + 1][m + 1] = true;
                    }

                    for (let m = rows[l] - 1; m >= 0; m--) {
                        for (let n = 0; n < 10; n++) {
                            if (this.divs[m][n]) {
                                this.moveSquare(this.divs[m][n], 40, 0);

                                //this.booleans[m + 2][n + 1] = false;
                            } 
                        }
                    }
                }
            }
        },

        // verifica si tetromino tiene espacio para poder bajar
        tetHaveSpace(direction) {
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
            let emptyCell1 = this.booleans[row + 1 + rowOffset][col + 1 + colOffset];

            row = this.getPosition(this.currentTet[1], 'top') / 40;
            col= this.getPosition(this.currentTet[1], 'left') / 40;
            let emptyCell2 = this.booleans[row + 1 + rowOffset][col + 1 + colOffset];

            row = this.getPosition(this.currentTet[2], 'top') / 40;
            col = this.getPosition(this.currentTet[2], 'left') / 40;
            let emptyCell3 = this.booleans[row + 1 + rowOffset][ col + 1 + colOffset];

            row = this.getPosition(this.currentTet[3], 'top') / 40;
            col = this.getPosition(this.currentTet[3], 'left') / 40;
            let emptyCell4 = this.booleans[row + 1 + rowOffset][col + 1 + colOffset];

            return (emptyCell1 && emptyCell2 && emptyCell3 && emptyCell4)? true : false;
        },

        // obtiene los pixeles de la propieded .left o .top de un elemento
        getPosition(element, side) {
            let value;
            if (side === 'left') {
                value = String(element.style.left);
            } else if (side === 'top') {
                value = String(element.style.top);       
            }
            return Number(value.substring(0,  value.length - 2));
        },

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
        
        squareCanOcupy(square, rowOffset, colOffset) {
            let row = this.getPosition(square, 'top') / 40;
            let col = this.getPosition(square, 'left') / 40;
            return this.booleans[row + 1 + rowOffset][col + 1 + colOffset];
        },

        moveSquare(square, topOffset, leftOffset) {
            let newTop = this.getPosition(square, 'top') + topOffset;
            square.style.top = newTop + "px";

            let newLeft = this.getPosition(square, 'left') + leftOffset;
            square.style.left =  newLeft + "px";
        },

        // rota la figura
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

        // pone un tetromino en una de las 2 pantallas
        putTetromino(location) {
            let basicStyle = "display: inline-block; width: 40px; height: 40px; position: absolute;"

            let cyanSquareStyle = basicStyle + "background: cyan;";
            let yellowSquareStyle = basicStyle + "background: yellow;";
            let magentaSquareStyle = basicStyle + "background: magenta;";
            let blueSquareStyle = basicStyle + "background: blue;";
            let orangeSquareStyle = basicStyle + "background: orange;";
            let lawnGreenSquareStyle = basicStyle + "background: lawnGreen;";
            let redSquareStyle = basicStyle + "background: red;";


            let screen = document.querySelector("#" + location);

            let square1 = document.createElement("div");
            let square2 = document.createElement("div");
            let square3 = document.createElement("div");
            let square4 = document.createElement("div");

            let squareArray = [square1, square2, square3, square4];
            
            // this.getRandomInt(1, 7)
            switch (2) {
                case 1: // I
                    this.tetType = 'I';

                    let left = 120;
                    squareArray.forEach(square => {
                        square.style.cssText = cyanSquareStyle;
                        square.style.top = "40px";
                        square.style.left = left + "px";
                        left += 40;
                    });

                    break;
                case 2: // O
                    this.tetType = 'O';

                    squareArray.forEach(square => {
                        square.style.cssText = yellowSquareStyle;
                    });

                    squareArray[0].style.top = '40px'; squareArray[0].style.left = '160px'; 
                    squareArray[1].style.top = '40px'; squareArray[1].style.left = '200px';
                    squareArray[2].style.top = '80px'; squareArray[2].style.left = '160px';
                    squareArray[3].style.top = '80px'; squareArray[3].style.left = '200px';

                    break;
                case 3: // T
                    this.tetType = 'T';

                    squareArray.forEach(square => {
                        square.style.cssText = magentaSquareStyle;
                    });

                    squareArray[0].style.top = '40px'; squareArray[0].style.left = '120px'; 
                    squareArray[1].style.top = '40px'; squareArray[1].style.left = '160px';
                    squareArray[2].style.top = '40px'; squareArray[2].style.left = '200px';
                    squareArray[3].style.top = '80px'; squareArray[3].style.left = '160px';

                    break;
                case 4: // J
                    this.tetType = 'J';

                    squareArray.forEach(square => {
                        square.style.cssText = blueSquareStyle;
                    });

                    squareArray[0].style.top = '40px'; squareArray[0].style.left = '120px'; 
                    squareArray[1].style.top = '40px'; squareArray[1].style.left = '160px';
                    squareArray[2].style.top = '40px'; squareArray[2].style.left = '200px';
                    squareArray[3].style.top = '80px'; squareArray[3].style.left = '200px';

                    break;
                case 5: // L
                    this.tetType = 'L';

                    squareArray.forEach(square => {
                        square.style.cssText = orangeSquareStyle;
                    });
                    squareArray[0].style.top = '40px'; squareArray[0].style.left = '200px'; 
                    squareArray[1].style.top = '80px'; squareArray[1].style.left = '120px';
                    squareArray[2].style.top = '80px'; squareArray[2].style.left = '160px';
                    squareArray[3].style.top = '80px'; squareArray[3].style.left = '200px';


                    break;
                case 6: // S
                    this.tetType = 'S';

                    squareArray.forEach(square => {
                        square.style.cssText = lawnGreenSquareStyle;
                    });

                    squareArray[0].style.top = '80px'; squareArray[0].style.left = '120px'; 
                    squareArray[1].style.top = '80px'; squareArray[1].style.left = '160px';
                    squareArray[2].style.top = '40px'; squareArray[2].style.left = '160px';
                    squareArray[3].style.top = '40px'; squareArray[3].style.left = '200px';

                    break;
                case 7: // Z
                    this.tetType = 'Z';

                    squareArray.forEach(square => {
                        square.style.cssText = redSquareStyle;
                    });

                    squareArray[0].style.top = '40px'; squareArray[0].style.left = '120px'; 
                    squareArray[1].style.top = '40px'; squareArray[1].style.left = '160px';
                    squareArray[2].style.top = '80px'; squareArray[2].style.left = '160px';
                    squareArray[3].style.top = '80px'; squareArray[3].style.left = '200px';

                    break;
            }

            squareArray.forEach(square => {
                screen.appendChild(square);
            });

            this.tetOrientation = 1;

            this.currentTet = squareArray;
        },

        // obtiene un numero aleatorio entre min (inclusivo) y max (inclusivo)
        getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        },

        // metodo para imprimir una matriz cuando se necesite
        printMatrix(matrix, rows, cols) {
            for (let r = 0; r < rows; r++) {
                let row = "";
                for (let c = 0; c < cols; c++) {
                    row += r + "," + c + " " + (matrix[r][c]? " " : "*")  + "\t";
                }
                console.log(row);
            } 
        }
    },
    mounted() {
        window.addEventListener('keydown', (event) => {
            let direction;
            switch (event.key) {
                case 'w': // arriba
                    this.rotateTet();
                    break;
                case 'a': // izquierda
                    if (this.tetHaveSpace('left')) this.moveTet('left');
                    break;
                case 's': // abajo
                    if (this.tetHaveSpace('down')) this.moveTet('down');
                    break;
                case 'd': // derecha
                    if (this.tetHaveSpace('right')) this.moveTet('right');
                    break;
            }
        }, false); 

    }
}
</script>