<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use DB;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //update permissions disini
        $data = [
            ["guard_name" => "web", "name" => "control panel.read"],
            ["guard_name" => "web", "name" => "setting.read"],
            ["guard_name" => "web", "name" => "setting/manage_account.read"],
            ["guard_name" => "web", "name" => "setting/manage_account/users.create"],
            ["guard_name" => "web", "name" => "setting/manage_account/users.read"],
            ["guard_name" => "web", "name" => "setting/manage_account/users.update"],
            ["guard_name" => "web", "name" => "setting/manage_account/users.update-role"],
            ["guard_name" => "web", "name" => "setting/manage_account/users.delete"],
            ["guard_name" => "web", "name" => "setting/manage_account/users.reset-password"],
            ["guard_name" => "web", "name" => "setting/manage_account/roles.create"],
            ["guard_name" => "web", "name" => "setting/manage_account/roles.read"],
            ["guard_name" => "web", "name" => "setting/manage_account/roles.update"],
            ["guard_name" => "web", "name" => "setting/manage_account/roles.delete"],
            ["guard_name" => "web", "name" => "setting/manage_account/permissions.read"],
            //tambahkan permissionnya disini
        ];
        
        //setelah ditambah jalankan perintah : php artisan db:seed --class=PermissionSeeder
        foreach ($data as $x) {
                if(!Permission::where('name', $x['name'])
                ->where('guard_name', $x['guard_name'])->first()){
                    $permission = Permission::create(['name' => $x['name'],'guard_name' => $x['guard_name']]);
                    $role_admin = Role::where('name',"admin")->first();
                    $role_admin->givePermissionTo($x['name']);
                }
        }
    }
}
