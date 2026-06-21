<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::where(
            'name',
            'Super Admin'
        )->first();

        $permissions = Permission::pluck('id');

        $superAdmin
            ->permissions()
            ->sync($permissions);
    }
}
