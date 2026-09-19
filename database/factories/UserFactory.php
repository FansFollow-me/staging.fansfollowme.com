<?php

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('Password123!'),
            'role' => UserRole::Fan,
            'status' => 'active',
            'email_verified_at' => now(),
            'date_of_birth' => now()->subYears(25)->toDateString(),
            'age_confirmed_at' => now(),
            'age_confirmation_ip' => '127.0.0.1',
        ];
    }
}
