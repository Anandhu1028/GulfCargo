<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            "Admin"
        ];
        $permissions = [
            'role-index',
            'role-create',
            'role-edit',
            'role-delete',

            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-ban',
            'user-view',
            'user-role',

            'attendance-index',
            'attendance-create',
            'attendance-edit',
            'attendance-delete',

            'shipment-index',
            'shipment-create',
            'shipment-edit',
            'shipment-delete',
            'shipment-print',
            'shipment-show',


        ];

        foreach ($permissions as $permission) {
            if (Permission::where('name', $permission)->first() == null) {
                Permission::create(['name' => $permission]);
            }
        }
        foreach ($roles as $role) {
            if (Role::where('name', $role)->first() == null) {
                $role = Role::create(['name' => $role, 'guard_name' => "web"]);
                $role->syncPermissions(Permission::all());
            }
        }
        $role = Role::where("name", "Admin")->first();
        $role->syncPermissions(Permission::all());
    }
}
