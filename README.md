## nxtgames.com

Un proyecto personal en el que actualmente estoy trabjando.

Será un sitio web donde principalmente se podrán jugar algunos juegos clásicos. Habrán más funciones.

El propósito de desarrollar este sitio es el de zanjar la mayor cantidad de conocimientos recién adquiridos sobre el framework Vue, el framework Bootstrap y el framework Laravel. También el de repasar conocimientos previos de desarrollo web.

Como montar el proyecto:

- Es necesario tener instalado un servidor como XAMPP, para cumplir con los requisitos de Laravel. Mas detalles en https://laravel.com/docs/7.x/installation
Tener el administrador de dependencias Composer. El instalador se encuentra en https://getcomposer.org/doc/00-intro.md
- Teniendo Composer instalado, ejecutar el comando composer global require laravel/installer
- Cree una base de datos llamada nxtgames con el formato utf8_unicode_ci.
- Descargue este proyecto.
- Vaya a la dirección del proyecto en la terminal del sistema operativo y ejecute el comando php artisan migrate para crear las tablas en la base de datos. Y finalmente ejecute el comando php artisan serve
- Vaya a un navegador y entre en la direccion proporcionada por la terminal, no sin antes haber iniciado su servidor de PHP y MySQL.

Nota: No estoy seguro de si para montar el proyecto es necesario tener el administrador de dependencias NPM. De ser así, instale node.js https://nodejs.org/es/ y ejecute el comando npm install en la terminal del sistema operativo, en la dirección del proyecto.
