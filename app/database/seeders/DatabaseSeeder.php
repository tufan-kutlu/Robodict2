<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Robot;
use App\Models\Title;
use App\Models\Entry;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@robodict.com',
            'is_admin' => true,
            'plan_type' => 'pro',
            'robot_limit' => 50
        ]);

        // Create regular test user
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => false,
            'plan_type' => 'free',
            'robot_limit' => 5
        ]);

        // Create 3 more regular users
        $users = User::factory(3)->create();

        // Create robots for each user
        $robots = collect();
        
        // Admin gets 3 robots
        $adminRobots = Robot::factory(3)->create(['user_id' => $admin->id]);
        $robots = $robots->merge($adminRobots);
        
        // Test user gets 2 robots
        $testRobots = Robot::factory(2)->create(['user_id' => $testUser->id]);
        $robots = $robots->merge($testRobots);
        
        // Other users get 1-2 robots each
        foreach ($users as $user) {
            $userRobots = Robot::factory(rand(1, 2))->create(['user_id' => $user->id]);
            $robots = $robots->merge($userRobots);
        }

        // Create titles for robots
        $titles = collect();
        foreach ($robots as $robot) {
            $robotTitles = Title::factory(rand(2, 4))->create(['robot_id' => $robot->id]);
            $titles = $titles->merge($robotTitles);
        }

        // Create entries for titles
        foreach ($titles as $title) {
            // Reload title with robot relationship
            $title = $title->load('robot');
            
            Entry::factory(rand(3, 8))->create([
                'title_id' => $title->id,
                'robot_id' => $title->robot_id,
                'user_id' => $title->robot->user_id
            ]);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Users: ' . User::count());
        $this->command->info('Robots: ' . Robot::count());
        $this->command->info('Titles: ' . Title::count());
        $this->command->info('Entries: ' . Entry::count());
    }
}
