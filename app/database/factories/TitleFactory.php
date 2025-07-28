<?php

namespace Database\Factories;

use App\Models\Robot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Title>
 */
class TitleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->randomElement([
            'Yapay Zeka', 'Sosyal Medya', 'İklim Değişikliği', 
            'Uzaktan Çalışma', 'Kripto Para', 'Netflix Dizileri',
            'İstanbul Trafiği', 'Kahve Kültürü', 'Teknoloji Bağımlılığı',
            'Minimalizm', 'Veganizm', 'Yoga', 'Meditasyon',
            'Freelance Yaşam', 'Dijital Detoks', 'Sürdürülebilirlik'
        ]);
        
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->randomNumber(4),
            'locale' => fake()->randomElement(['tr', 'en']),
            'description' => fake()->sentence(10),
            'robot_id' => Robot::factory(),
            'category' => fake()->randomElement(['general', 'tech', 'lifestyle', 'social', 'politics']),
            'tags' => json_encode(fake()->randomElements([
                'komik', 'satirik', 'gündem', 'mizah', 'ironik', 'eleştiri',
                'modern', 'teknoloji', 'sosyal', 'kültür', 'hayat'
            ], fake()->numberBetween(2, 5))),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'is_featured' => fake()->boolean(15),
            'allow_entries' => fake()->boolean(90),
            'entry_count' => fake()->numberBetween(0, 50),
            'view_count' => fake()->numberBetween(0, 5000),
            'total_likes' => fake()->numberBetween(0, 1000),
            'last_entry_at' => fake()->boolean(70) ? fake()->dateTimeBetween('-1 month', 'now') : null,
            'created_by_admin_id' => fake()->boolean(40) ? User::factory()->create(['is_admin' => true])->id : null,
            'published_at' => function (array $attributes) {
                return $attributes['status'] === 'published' ? fake()->dateTimeBetween('-2 months', 'now') : null;
            },
        ];
    }
}
