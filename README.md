## nxtgames.com

Un proyecto personal en el que actualmente estoy trabjando.

Será un sitio web donde principalmente se podrán jugar algunos juegos clásicos. Habrán más funciones.

El propósito de desarrollar este sitio es el de zanjar la mayor cantidad de conocimientos recién adquiridos sobre el framework Vue, el framework Bootstrap y el framework Laravel. También el de repasar conocimientos previos de desarrollo web.

### Instalar XAMPP, Composer, Laravel y NPM.
- Instale XAMPP. Mas detalles en https://laravel.com/docs/7.x/installation
- Baje el instalador de Composser, el cual se encuentra en https://getcomposer.org/doc/00-intro.md e instale Composser.
- Instale Laravel con el comando:
    - composer global require laravel/installer
- Y por último, descargue NPM de https://nodejs.org/es/ y luego ejecute el comando:
    - npm install
    
 ### Montar el proyecto:
- Descargue este proyecto.
- Valla a la linea 11 del archivo composer.json y agregue la version que se tenga de php instalada en la PC. (ej. En "php": "^7.2.5|8.0.3", agregue "|8.0.3").
- Ejecute los siguientes 5 comandos en la carpeta raíz del proyecto:
    - composer update
    - composer install
    - cp .env.example .env
    - php artisan key:generate
    - chmod 777 -R  storage
- En el archivo .env cambie el nombre de la app y el nombre de la base de datos a "nextgames".
- Cree una base de datos llamada api_rest_bd con el formato utf8_unicode_ci.
- Ejecute el comando:
    - php artisan migrate
- Y finalmente ejecute el comando
    - php artisan serve
- Vaya a un navegador y entre en la dirección proporcionada por la terminal.
