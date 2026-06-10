<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'Ahmed Hassan',
            'email' => 'ahmed@example.com',
            'password' => Hash::make('password'),
            'theme' => 'light',
        ]);

        $user2 = User::create([
            'name' => 'Sara Ibrahim',
            'email' => 'sara@example.com',
            'password' => Hash::make('password'),
            'theme' => 'dark',
        ]);

        $user1Posts = [
            [
                'title' => 'Laravel Learning Plan',
                'body' => 'Complete Eloquent relationships and API Resources this week.',
            ],
            [
                'title' => 'Vue.js Notes',
                'body' => 'Learn components, props, emits and state management.',
            ],
            [
                'title' => 'Interview Preparation',
                'body' => 'Review OOP principles, SOLID and design patterns.',
            ],
            [
                'title' => 'Portfolio Improvements',
                'body' => 'Add project screenshots and update GitHub repositories.',
            ],
            [
                'title' => 'API Development',
                'body' => 'Implement authentication using Laravel Sanctum.',
            ],
            [
                'title' => 'Database Optimization',
                'body' => 'Study indexing and query optimization techniques.',
            ],
            [
                'title' => 'ERP System Ideas',
                'body' => 'Design modules for companies, branches and accounting.',
            ],
            [
                'title' => 'Weekly Goals',
                'body' => 'Finish current project and deploy a demo version.',
            ],
            [
                'title' => 'Code Refactoring',
                'body' => 'Improve controller structure and move logic to services.',
            ],
            [
                'title' => 'Backend Roadmap',
                'body' => 'Continue learning queues, caching and event-driven architecture.',
            ],
        ];

        foreach ($user1Posts as $post) {
            Post::create([
                'user_id' => $user1->id,
                'title' => $post['title'],
                'body' => $post['body'],
            ]);
        }

        $user2Posts = [
            [
                'title' => 'Project Meeting',
                'body' => 'Discuss requirements and define project milestones.',
            ],
            [
                'title' => 'Reading List',
                'body' => 'Read Laravel documentation about policies and gates.',
            ],
            [
                'title' => 'Testing Notes',
                'body' => 'Write feature tests for user authentication.',
            ],
            [
                'title' => 'Deployment Checklist',
                'body' => 'Prepare environment variables and production database.',
            ],
            [
                'title' => 'UI Enhancements',
                'body' => 'Improve navigation and responsive layouts.',
            ],
            [
                'title' => 'Bug Tracking',
                'body' => 'Fix validation issue on create note form.',
            ],
            [
                'title' => 'Research Topic',
                'body' => 'Explore microservices architecture using Laravel.',
            ],
            [
                'title' => 'Client Feedback',
                'body' => 'Update dashboard according to requested changes.',
            ],
            [
                'title' => 'Git Workflow',
                'body' => 'Use feature branches and pull requests effectively.',
            ],
            [
                'title' => 'Learning Goals',
                'body' => 'Master Laravel queues and job processing.',
            ],
        ];

        foreach ($user2Posts as $post) {
            Post::create([
                'user_id' => $user2->id,
                'title' => $post['title'],
                'body' => $post['body'],
            ]);
        }
    }
}