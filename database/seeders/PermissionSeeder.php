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
            ["guard_name" => "web", "name" => "setting/manage_coa.read"],
            ["guard_name" => "web", "name" => "setting/manage_coa/coa.read"],
            ["guard_name" => "web", "name" => "setting/manage_coa/coa.create"],
            ["guard_name" => "web", "name" => "setting/manage_coa/coa.update"],
            ["guard_name" => "web", "name" => "setting/manage_coa/coa.delete"],
            ["guard_name" => "web", "name" => "setting/manage_coa/subject.read"],
            ["guard_name" => "web", "name" => "setting/manage_coa/subject.create"],
            ["guard_name" => "web", "name" => "setting/manage_coa/subject.update"],
            ["guard_name" => "web", "name" => "setting/manage_coa/subject.delete"],
            ["guard_name" => "web", "name" => "setting/manage_coa/parameter.read"],
            ["guard_name" => "web", "name" => "setting/manage_coa/parameter.create"],
            ["guard_name" => "web", "name" => "setting/manage_coa/parameter.update"],
            ["guard_name" => "web", "name" => "setting/manage_coa/parameter.delete"],
            ["guard_name" => "web", "name" => "setting/manage_coa/sampling_time.read"],
            ["guard_name" => "web", "name" => "setting/manage_coa/sampling_time.create"],
            ["guard_name" => "web", "name" => "setting/manage_coa/sampling_time.update"],
            ["guard_name" => "web", "name" => "setting/manage_coa/sampling_time.delete"],
            ["guard_name" => "web", "name" => "setting/manage_coa/regulation_standard.read"],
            ["guard_name" => "web", "name" => "setting/manage_coa/regulation_standard.create"],
            ["guard_name" => "web", "name" => "setting/manage_coa/regulation_standard.update"],
            ["guard_name" => "web", "name" => "setting/manage_coa/regulation_standard.delete"],
            ["guard_name" => "web", "name" => "setting/manage_coa/regulation_standard_category.read"],
            ["guard_name" => "web", "name" => "setting/manage_coa/regulation_standard_category.create"],
            ["guard_name" => "web", "name" => "setting/manage_coa/regulation_standard_category.update"],
            ["guard_name" => "web", "name" => "setting/manage_coa/regulation_standard_category.delete"],
            ["guard_name" => "web", "name" => "setting/manage_director.read"],
            ["guard_name" => "web", "name" => "setting/manage_director/director.read"],
            ["guard_name" => "web", "name" => "setting/manage_director/director.create"],
            ["guard_name" => "web", "name" => "setting/manage_director/director.update"],
            ["guard_name" => "web", "name" => "setting/manage_director/director.delete"],
            ["guard_name" => "web", "name" => "director.update"], // Tambahkan ini
            //tambahkan permissionnya disini
        ];

        //setelah ditambah jalankan perintah : php artisan db:seed --class=PermissionSeeder
        foreach ($data as $x) {
            // Buat permission jika belum ada
            $permission = Permission::firstOrCreate(
                ['name' => $x['name'], 'guard_name' => $x['guard_name']]
            );
            // Ambil role admin
            $role_admin = Role::where('name', "admin")->first();
            // Berikan permission ke role admin jika belum ada
            if ($role_admin && !$role_admin->hasPermissionTo($x['name'])) {
                $role_admin->givePermissionTo($x['name']);
            }
        }
    }
}
