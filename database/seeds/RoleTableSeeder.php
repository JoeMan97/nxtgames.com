<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = "Usuario";
        $role->description = "El Usuario tiene permitido jugar cualquier juego, consultar las noticias del sitio.";
        $role->save();

        $role = new Role();
        $role->name = "Administrador";
        $role->description = "El Administrador el único rol que tiene permitido hacer crear, editar y eliminar noticias.";
        $role->save();
    }
}
