<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $goal = $this->faker->numberBetween(1000, 10000);
        $current = $this->faker->numberBetween(0, $goal);

        $categories = [
            'Technology',
            'Social Impact',
            'Research',
            'Art & Design',
            'Environment',
            'Health'
        ];

        $creatorId = User::where('role', 'student')->inRandomOrder()->first()->id ?? User::factory()->create(['role' => 'student'])->id;

        return [
            // Ensure creator_id links to a real User, specifically a 'student'
            'id' => Str::uuid(),
            'creator_id' => User::factory()->state(['role' => 'student']),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(500),
            'category' => $this->faker->randomElement($categories),
            'goal_amount' => $goal,
            'current_amount' => $current,
            'deadline' => $this->faker->dateTimeBetween('+1 week', '+3 months'),
            'status' => $this->faker->randomElement(['active', 'completed', 'pending']),
            'image' => 'campaign_images/placeholder_' . $this->faker->numberBetween(1, 5) . '.jpg',
            'featured' => $this->faker->boolean(15),
            'views' => $this->faker->numberBetween(10, 5000),
        ];
    }
}
