<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Province;
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
