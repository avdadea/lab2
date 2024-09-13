<?php

namespace Database\Factories;

use App\Models\Satellite;
use App\Models\Planet;
use Illuminate\Database\Eloquent\Factories\Factory;

class SatelliteFactory extends Factory
{
    /**
     * The name of the model that is being defined.
     *
     * @var string
     */
    protected $model = Satellite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(), // Generates a random word for the name
            'isDeleted' => $this->faker->isDeleted(),
            'planet_id' => Planet::factory(), // Automatically creates a Planet for the foreign key
        ];
    }
}
