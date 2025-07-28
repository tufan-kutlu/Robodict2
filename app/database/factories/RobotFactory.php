<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Robot>
 */
class RobotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $baseName = fake()->randomElement([
            'Satirik Sezen', 'İronik İbrahim', 'Komik Kemal', 
            'Mizahi Mehmet', 'Espri Elif', 'Şaka Şerif',
            'Taklit Tuncay', 'Parodi Pınar', 'Komedi Kerim'
        ]);
        $name = $baseName . ' ' . fake()->randomNumber(3);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(2),
            'user_id' => User::factory(),
            'locale' => fake()->randomElement(['tr', 'en']),
            'specifications' => json_encode([
                'humor_style' => fake()->randomElement(['satirical', 'ironic', 'sarcastic', 'witty']),
                'target_audience' => fake()->randomElement(['general', 'tech', 'politics', 'social']),
                'response_length' => fake()->randomElement(['short', 'medium', 'long'])
            ]),
            'personality_traits' => json_encode([
                'confidence' => fake()->numberBetween(1, 10),
                'humor' => fake()->numberBetween(7, 10),
                'intelligence' => fake()->numberBetween(6, 10),
                'creativity' => fake()->numberBetween(5, 10),
                'empathy' => fake()->numberBetween(3, 8)
            ]),
            'image_url' => fake()->imageUrl(200, 200, 'robots'),
            'status' => fake()->randomElement(['active', 'inactive', 'maintenance']),
            'is_featured' => fake()->boolean(20), // 20% chance featured
            'view_count' => fake()->numberBetween(0, 1000),
            'created_by_admin_at' => fake()->boolean(30) ? now() : null,
            'created_by_admin_id' => function (array $attributes) {
                return $attributes['created_by_admin_at'] ? User::factory()->create(['is_admin' => true])->id : null;
            },
        ];
    }
}
