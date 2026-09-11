<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use App\Models\Skill;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // Owner
        $owner = User::firstOrCreate(
            ['email' => 'owner@designhub.test'],
            [
                'name' => 'Owner Admin',
                'password' => $password,
                'role' => 'owner',
            ]
        );

        // Client
        $client = User::firstOrCreate(
            ['email' => 'client@designhub.test'],
            [
                'name' => 'Demo Client',
                'password' => $password,
                'role' => 'client',
            ]
        );

        // Skills (10 skills)
        $skills = [
            'Branding', 'UI/UX Design', 'Web Development', 'Illustration',
            'Video Editing', 'Motion Graphics', 'Copywriting', 'SEO',
            '3D Modeling', 'Presentation Design'
        ];

        $skillModels = [];
        foreach ($skills as $skillName) {
            $skillModels[] = Skill::firstOrCreate(
                ['slug' => strtolower(str_replace(' ', '-', $skillName))],
                ['name' => $skillName]
            );
        }

        // Members (6 members)
        for ($i = 1; $i <= 6; $i++) {
            $memberUser = User::firstOrCreate(
                ['email' => "member{$i}@designhub.test"],
                [
                    'name' => "Member {$i}",
                    'password' => $password,
                    'role' => 'member',
                ]
            );

            $member = Member::firstOrCreate(
                ['user_id' => $memberUser->id],
                [
                    'slug' => "member-{$i}",
                    'availability' => true,
                    'verified' => true,
                    'bio' => "Professional creative {$i}",
                    'location' => 'Jakarta',
                ]
            );

            // Attach 3 random skills
            $randomSkills = collect($skillModels)->random(3)->pluck('id')->toArray();
            $member->skills()->syncWithoutDetaching($randomSkills);

            // 2 Services
            for ($s = 1; $s <= 2; $s++) {
                Service::firstOrCreate(
                    ['slug' => "service-{$s}-member-{$i}"],
                    [
                        'member_id' => $member->id,
                        'title' => "Creative Service {$s} by Member {$i}",
                        'description' => 'High quality creative service.',
                        'price' => rand(500000, 5000000),
                    ]
                );
            }

            // 2 Approved Portfolios
            for ($p = 1; $p <= 2; $p++) {
                Portfolio::firstOrCreate(
                    ['slug' => "portfolio-{$p}-member-{$i}"],
                    [
                        'member_id' => $member->id,
                        'title' => "Awesome Portfolio {$p}",
                        'description' => 'A great project I did recently.',
                        'status' => 'approved',
                    ]
                );
            }
        }

        // 3 Orders with different statuses
        $serviceForOrder = Service::first();
        if ($serviceForOrder) {
            $statuses = ['pending', 'in_progress', 'completed'];
            foreach ($statuses as $index => $status) {
                Order::firstOrCreate(
                    ['order_number' => "ORD-" . str_pad($index + 1, 4, '0', STR_PAD_LEFT)],
                    [
                        'client_id' => $client->id,
                        'member_id' => $serviceForOrder->member_id,
                        'service_id' => $serviceForOrder->id,
                        'brief' => "I need a design for {$status}",
                        'budget' => $serviceForOrder->price,
                        'deadline' => now()->addDays(7),
                        'status' => $status,
                    ]
                );
            }
        }
    }
}
