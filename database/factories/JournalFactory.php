<?php

namespace Database\Factories;

use App\Models\Journal;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalFactory extends Factory
{
    protected $model = Journal::class;

    public function definition(): array
    {
        $revenue = $this->faker->numberBetween(2000, 6000);

        // Based off on industry averages. Padded each side to give outliers to the average.
        $foodCostPercent = $this->faker->numberBetween(25, 45);
        $laborCostPercent = $this->faker->numberBetween(25, 45);

        $foodCost = $revenue * ($foodCostPercent / 100);
        $laborCost = $revenue * ($laborCostPercent / 100);

        $profit = $revenue - $foodCost - $laborCost;

        return [
            'revenue' => $revenue,
            'food_cost' => $foodCost,
            'food_cost_percent' => $foodCostPercent,
            'labor_cost' => $laborCost,
            'labor_cost_percent' => $laborCostPercent,
            'profit' => $profit
        ];
    }
}
