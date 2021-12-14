<?php

namespace Database\Factories;

use App\Models\Outflow;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutflowFactory extends Factory
{
    protected $model = Outflow::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'amount' => $this->faker->randomFloat(2, 0, 100),
            'date' => $this->faker->dateTimeBetween('-1 months', 'now'),
        ];
    }
}
