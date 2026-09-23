<?php

namespace Database\Seeders;

use App\Models\Career;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $careers = [
            [
                'code' => 'FRONTEND_DEVELOPER',
                'name' => 'Frontend Developer',
                'description' => 'Builds and maintains the user interface and user experience of web applications.',
                'icon' => 'code-2',
                'order' => 1,
            ],
            [
                'code' => 'BACKEND_DEVELOPER',
                'name' => 'Backend Developer',
                'description' => 'Builds and maintains server-side applications, APIs, databases, and business logic.',
                'icon' => 'server',
                'order' => 2,
            ],
            [
                'code' => 'FULLSTACK_DEVELOPER',
                'name' => 'Full Stack Developer',
                'description' => 'Develops both frontend and backend components of web applications.',
                'icon' => 'layers',
                'order' => 3,
            ],
            [
                'code' => 'MOBILE_DEVELOPER',
                'name' => 'Mobile Developer',
                'description' => 'Develops applications for mobile platforms such as Android and iOS.',
                'icon' => 'smartphone',
                'order' => 4,
            ],
            [
                'code' => 'UI_UX_DESIGNER',
                'name' => 'UI/UX Designer',
                'description' => 'Designs intuitive, accessible, and visually appealing digital experiences.',
                'icon' => 'palette',
                'order' => 5,
            ],
            [
                'code' => 'DATA_ANALYST',
                'name' => 'Data Analyst',
                'description' => 'Analyzes data to identify insights, trends, and information that support business decisions.',
                'icon' => 'chart-column',
                'order' => 6,
            ],
            [
                'code' => 'DATA_SCIENTIST',
                'name' => 'Data Scientist',
                'description' => 'Uses statistics, programming, and machine learning to analyze data and build predictive models.',
                'icon' => 'brain',
                'order' => 7,
            ],
            [
                'code' => 'QA_ENGINEER',
                'name' => 'QA Engineer',
                'description' => 'Ensures software quality by designing and executing tests and identifying defects.',
                'icon' => 'shield-check',
                'order' => 8,
            ],
            [
                'code' => 'DEVOPS_ENGINEER',
                'name' => 'DevOps Engineer',
                'description' => 'Automates software delivery and manages infrastructure, deployment, and application reliability.',
                'icon' => 'infinity',
                'order' => 9,
            ],
            [
                'code' => 'CYBERSECURITY_ANALYST',
                'name' => 'Cybersecurity Analyst',
                'description' => 'Protects systems, networks, and data by monitoring and responding to security threats.',
                'icon' => 'shield',
                'order' => 10,
            ],
            [
                'code' => 'PRODUCT_MANAGER',
                'name' => 'Product Manager',
                'description' => 'Defines product direction, prioritizes features, and coordinates teams to deliver valuable products.',
                'icon' => 'briefcase-business',
                'order' => 11,
            ],
            [
                'code' => 'PROJECT_MANAGER',
                'name' => 'Project Manager',
                'description' => 'Plans and coordinates projects to ensure they are delivered within scope, time, and budget.',
                'icon' => 'clipboard-list',
                'order' => 12,
            ],
            [
                'code' => 'DIGITAL_MARKETING_SPECIALIST',
                'name' => 'Digital Marketing Specialist',
                'description' => 'Plans and executes digital marketing strategies across online channels to reach business goals.',
                'icon' => 'megaphone',
                'order' => 13,
            ],
            [
                'code' => 'SEO_SPECIALIST',
                'name' => 'SEO Specialist',
                'description' => 'Improves website visibility and organic search performance through search engine optimization strategies.',
                'icon' => 'search',
                'order' => 14,
            ],
            [
                'code' => 'CONTENT_CREATOR',
                'name' => 'Content Creator',
                'description' => 'Creates digital content for platforms such as websites, social media, video, and other digital channels.',
                'icon' => 'clapperboard',
                'order' => 15,
            ],
        ];

        foreach ($careers as $career) {
            Career::create([
                'name' => $career['name'],
                'code' => $career['code'],
                'description' => $career['description'],
                'icon' => $career['icon'],
                'order' => $career['order']
            ]);
        }
    }
}
