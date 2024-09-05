<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductProperty;

class ProductPropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = ProductProperty::class;

    public function definition()
    {
        $properties = ['color', 'size', 'brand', 'material'];
        return [
            'property_name' => $this->faker->randomElement($properties),
            'property_value' => $this->faker->word,
        ];
    }
}
