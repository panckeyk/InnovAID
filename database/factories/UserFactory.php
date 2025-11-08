<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    protected $model = User::class;
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = $this->faker->randomElement(['student', 'donor']);

        return [
            'id' => Str::uuid(),
            'firstname' => $this->faker->firstName(), 
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => $this->faker->randomElement(['student', 'donor']), // Random role for factory users
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'verified' => true,

            // Only assign student data if the role is 'student'
            'student_id' => $role === 'student' ? Str::random(8) : null,
            'department' => $role === 'student' ? $this->faker->randomElement(['IT', 'Engineering', 'Arts', 'Business']) : null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
