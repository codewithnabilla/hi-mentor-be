<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            [
                'name' => 'React',
                'description' => 'Building user interfaces with React.',
            ],
            [
                'name' => 'SQL',
                'description' => 'Working with relational databases and SQL.',
            ],
            [
                'name' => 'Problem Solving',
                'description' => 'Analyzing problems and developing solutions.',
            ],
            [
                'name' => 'Communication',
                'description' => 'Communicating ideas effectively with others.',
            ],
            [
                'name' => 'Project Management',
                'description' => 'Planning and managing projects.',
            ],
        ];

        foreach ($skills as $skill) {
            Skill::create([
                'name' => $skill['name'],
                'description' => $skill['description']
            ]);
        }
    }
}
