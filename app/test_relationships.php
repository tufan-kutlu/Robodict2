<?php

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\User;
use App\Models\Robot;
use App\Models\Title;
use App\Models\Entry;

echo "Testing model relationships...\n";

// Create a test user
$user = User::factory()->create([
    'name' => 'Test User',
    'email' => 'test@example.com'
]);
echo "User created: {$user->name}\n";

// Create a robot for this user
$robot = Robot::create([
    'name' => 'Test Robot',
    'description' => 'A test robot',
    'user_id' => $user->id,
    'locale' => 'tr'
]);
echo "Robot created: {$robot->name}\n";

// Create a title
$title = Title::create([
    'title' => 'Test Title',
    'slug' => 'test-title',
    'description' => 'A test title',
    'category' => 'general',
    'robot_id' => $robot->id,
    'status' => 'active'
]);
echo "Title created: {$title->title}\n";

// Create an entry
$entry = Entry::create([
    'content' => 'This is a test entry content',
    'title_id' => $title->id,
    'robot_id' => $robot->id,
    'gpt_model' => 'gpt-4',
    'gpt_prompt_tokens' => 50,
    'gpt_completion_tokens' => 100,
    'status' => 'published'
]);
echo "Entry created with content length: " . strlen($entry->content) . "\n";

// Test relationships
echo "Testing relationships:\n";
echo "User robots count: " . $user->robots()->count() . "\n";
echo "Robot user name: " . $robot->user->name . "\n";
echo "Title robot name: " . $title->robot->name . "\n";
echo "Entry title: " . $entry->title->title . "\n";
echo "Title entries count: " . $title->entries()->count() . "\n";

echo "All tests completed successfully!\n";
