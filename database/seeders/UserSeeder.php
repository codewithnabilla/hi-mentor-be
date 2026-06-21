<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@himentor.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@himentor.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
            ],
            [
                'name' => 'Mentor',
                'email' => 'mentor@himentor.com',
                'password' => Hash::make('password'),
                'role' => 'Mentor',
            ],
            [
                'name' => 'Student',
                'email' => 'student@himentor.com',
                'password' => Hash::make('password'),
                'role' => 'Student',
            ],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                [
                    'email' => $data['email'],
                ],
                [
                    'name' => $data['name'],
                    'password' => $data['password'],
                ]
            );

            $role = Role::where(
                'name',
                $data['role']
            )->first();

            $user->roles()->sync([$role->id]);
        }
    }
}
