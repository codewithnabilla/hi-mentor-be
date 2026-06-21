<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'description' => 'Full system access',
            ],
            [
                'name' => 'Admin',
                'description' => 'Administrative access',
            ],
            [
                'name' => 'Mentor',
                'description' => 'Mentor access',
            ],
            [
                'name' => 'Student',
                'description' => 'Student access',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}
