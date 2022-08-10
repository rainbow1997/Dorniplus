<?php

namespace Database\Factories;

use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProvinceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Province::class;

    public function definition()
    {
        return [
            //
            'title' => $this->faker->name(),

        ];
    }
}
