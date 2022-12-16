<?php

namespace Database\Seeders;

use App\Models\Journal;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    public function run()
    {
        $stores = Store::all();

        ray($stores);

        foreach($stores as $store) {
            $date = now();

            while( $date > Carbon::now()->subYear() ) {
                Journal::factory()->for($store)->create([
                    'date' => $date
                ]);

                $date->subDay();
            }
        }
    }
}
