<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'team_1' => $this->faker->userName,
            'team_2' => $this->faker->userName,
            'score_1' => $this->faker->numberBetween(1,10),
            'score_2' => $this->faker->numberBetween(1,10),
            'played' => $this->faker->boolean,
        ];
    }
}
