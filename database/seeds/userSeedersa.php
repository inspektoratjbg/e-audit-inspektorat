<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class userSeedersa extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        //
        /*      
            // user pertama  
            user::create([
            'name' => 'Kang Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]); */



        // create permissions
        /* 
        // dasaran
        Permission::create(["name" => "user.list"]);
        Permission::create(["name" => "user.role"]);
        Permission::create(["name" => "role.list"]);
        Permission::create(["name" => "role.create"]);
        Permission::create(["name" => "role.edit"]);
        Permission::create(["name" => "role.delete"]);
        Permission::create(["name" => "permissions.list"]);
        Permission::create(["name" => "permissions.create"]);
        Permission::create(["name" => "permissions.edit"]);
        Permission::create(["name" => "permissions.delete"]);

        Role::create(['name' => 'Administrator'])->givePermissionTo(['user.list', 'user.role', 'role.list', 'role.create', 'role.edit', 'role.delete', 'permissions.list', 'permissions.create', 'permissions.edit', 'permissions.delete']);

        $user = User::find(1);
        $user->assignRole('Administrator'); */

        /*   // setup ppk
        Permission::create(["name" => "ppk.list"]);
        Permission::create(["name" => "ppk.create"]);
        Permission::create(["name" => "ppk.edit"]);
        Permission::create(["name" => "ppk.delete"]);

        $role=Role::where('name','Administrator')->first();
        $role->givePermissionTo(['ppk.list','ppk.create','ppk.edit','ppk.delete']); */

        /*         // setup konsultan
        Permission::create(["name" => "konsultan.list"]);
        Permission::create(["name" => "konsultan.create"]);
        Permission::create(["name" => "konsultan.edit"]);
        Permission::create(["name" => "konsultan.delete"]);

        $role = Role::where('name', 'Administrator')->first();
        $role->givePermissionTo(['konsultan.list', 'konsultan.create', 'konsultan.edit', 'konsultan.delete']);
 */
        /* // setup pekerjaan
        Permission::create(["name" => "pekerjan.list"]);
        Permission::create(["name" => "pekerjan.create"]);
        Permission::create(["name" => "pekerjan.edit"]);
        Permission::create(["name" => "pekerjan.delete"]);

        $rolea = Role::where('name', 'PPK')->first();
        $rolea->givePermissionTo(['pekerjan.list', 'pekerjan.create', 'pekerjan.edit', 'pekerjan.delete']); */


        /* // setup addedendum
        Permission::create(["name" => "addedum.create"]);
        $rolea = Role::where('name', 'PPK')->first();
        $rolea->givePermissionTo(['addedum.create']); */

        // setup progres
        /*  Permission::create(["name" => "progres.create"]);
        $per = ['progres.create'];

        $rolea = Role::where('name', 'PPK')->first();
        $rolea->givePermissionTo($per);

        $roleb = Role::where('name', 'Konsultan')->first();
        $roleb->givePermissionTo($per); */

        Permission::create(["name" => "rencana.list"]);
        Permission::create(["name" => "rencana.edit"]);
        Permission::create(["name" => "rencana.create"]);
        $per = ['rencana.list', 'rencana.edit','rencana.create'];

        $rolea = Role::where('name', 'PPK')->first();
        $rolea->givePermissionTo($per);
        $roleb = Role::where('name', 'Konsultan')->first();
        $roleb->givePermissionTo($per);
    }
}
