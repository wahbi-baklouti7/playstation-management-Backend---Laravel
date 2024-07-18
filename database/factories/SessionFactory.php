<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Game;
use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Session::truncate();
        return [
            'amount' => $this->faker->numberBetween(0, 100),
            'start_time' => now(),
            'end_time' => now()->addHour(),
            'user_id' => User::all()->random()->id ?? User::factory()->create()->id,
            'device_id' => Device::all()->random()->id ?? Device::factory()->create()->id,
            'game_id' => Game::all()->random()->id ?? Game::factory()->create()->id
        ];
    }
}
