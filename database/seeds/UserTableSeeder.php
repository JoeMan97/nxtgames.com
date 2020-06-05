<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buscamos en la tabla role los roles que tengan el atributo 'name' con 'x'
        $role_user = Role::where('name','Usuario')->first();
        $role_admin = Role::where('name','Administrador')->first();

        // Creamos los usuarios especificando sus atributos...
        $user = new User();
        $user->name = "José Carrillo";
        $user->email = "joseemanueelct@gmail.com";
        $user->password = bcrypt('hola1234');
        $user->picture = public_path().'/images/'.'default_user.png';
        $user->save();
        $user->roles()->attach($role_user);
        $user->roles()->attach($role_admin);
    }
}
