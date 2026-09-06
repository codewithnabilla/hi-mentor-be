<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Technology',
                'code' => 'TECH',
                'description' => 'Software development, data, infrastructure, cybersecurity, and other technology careers.',
            ],
            [
                'name' => 'Marketing',
                'code' => 'MKT',
                'description' => 'Digital marketing, content, SEO, social media, advertising, and growth careers.',
            ],
            [
                'name' => 'Design',
                'code' => 'DESIGN',
                'description' => 'UI/UX, product design, graphic design, and other creative careers.',
            ],
            [
                'name' => 'Business',
                'code' => 'BUSINESS',
                'description' => 'Business analysis, product management, project management, and business operations.',
            ],
            [
                'name' => 'Finance',
                'code' => 'FINANCE',
                'description' => 'Accounting, financial analysis, banking, investment, and other finance careers.',
            ],
            [
                'name' => 'Human Resources',
                'code' => 'HR',
                'description' => 'Recruitment, people operations, talent development, and human resources careers.',
            ],
            [
                'name' => 'Sales',
                'code' => 'SALES',
                'description' => 'Sales, business development, account management, and related careers.',
            ],
            [
                'name' => 'Operations',
                'code' => 'OPS',
                'description' => 'Business operations, supply chain, logistics, procurement, and related careers.',
            ],

        ];

        foreach ($departments as $department) {
            Department::create([
                'name' => $department['name'],
                'code' => $department['code'],
                'description' => $department['description'],
            ]);
        }
    }
}
