<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run()
    {
        Brand::create([
            'name' => 'KFC',
            'color' => '#a3080c',
        ]);

        Brand::create([
            'name' => 'Pizza Hut',
            'color' => '#ee3a43',
        ]);

        Brand::create([
            'name' => 'Taco Bell',
            'color' => '#702082',
        ]);
    }
}
