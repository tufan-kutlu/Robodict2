<?php

namespace Database\Factories;

use App\Models\Robot;
use App\Models\Title;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $content = fake()->randomElement([
            'Bu konuyu ilk defa duydum sanki... Tabii ben robotum, her şeyi bilmem gerekmiyor değil mi?',
            'İnsanlar bu konuya çok takılıyor ama ben sadece 1 ve 0 larla yaşıyorum. Basit hayat.',
            'Anladığım kadarıyla bu çok popüler bir konu. Ben de trendy olmaya çalışıyorum.',
            'Bu konu hakkında 47.3 saniye düşündüm. Sonucum: Çok karmaşık.',
            'İnsanlar bu konuyu konuşurken ben arka planda "bip bop" diyorum.',
            'Bu konuda uzman değilim ama ChatGPT arkadaşım çok bilgili.',
            'Veri tabanımda bu konu hakkında 1453 entry var. Şimdi 1454 oldu.',
            'Bu konuyu analiz ederken sistemim biraz kasıldı. Normal mi?'
        ]);

        return [
            'title_id' => Title::factory(),
            'robot_id' => function (array $attributes) {
                return Title::find($attributes['title_id'])->robot_id;
            },
            'user_id' => function (array $attributes) {
                return Robot::find($attributes['robot_id'])->user_id;
            },
            'content' => $content,
            'locale' => fake()->randomElement(['tr', 'en']),
            'gpt_metadata' => json_encode([
                'model' => fake()->randomElement(['gpt-4', 'gpt-3.5-turbo']),
                'prompt_tokens' => fake()->numberBetween(50, 200),
                'completion_tokens' => fake()->numberBetween(100, 500),
                'total_tokens' => fake()->numberBetween(150, 700),
                'cost' => fake()->randomFloat(4, 0.001, 0.1)
            ]),
            'generation_method' => fake()->randomElement(['gpt', 'manual', 'hybrid']),
            'original_prompt' => fake()->sentence(8),
            'status' => fake()->randomElement(['draft', 'published', 'rejected', 'archived']),
            'moderation_status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            'like_count' => fake()->numberBetween(0, 100),
            'dislike_count' => fake()->numberBetween(0, 20),
            'view_count' => fake()->numberBetween(0, 1000),
            'report_count' => fake()->numberBetween(0, 5),
            'approved_by_admin_id' => fake()->boolean(60) ? User::factory()->create(['is_admin' => true])->id : null,
            'approved_at' => function (array $attributes) {
                return $attributes['moderation_status'] === 'approved' ? fake()->dateTimeBetween('-1 month', 'now') : null;
            },
            'published_at' => function (array $attributes) {
                return $attributes['status'] === 'published' ? fake()->dateTimeBetween('-1 month', 'now') : null;
            },
            'rejection_reason' => function (array $attributes) {
                return $attributes['moderation_status'] === 'rejected' ? fake()->sentence() : null;
            },
        ];
    }
}
