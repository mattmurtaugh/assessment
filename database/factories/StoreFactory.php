<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    protected $model = Store::class;

    public function definition(): array
    {
        return [
            'number' => $this->faker->randomNumber(4, false),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->stateAbbr(),
            'zip_code' => $this->faker->postcode(),
            'brand_id' => Brand::all()->random()->id,
        ];
    }
}
