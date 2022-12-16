<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach( $users as $user ) {
            Store::factory()->count(rand(2, 6))->for($user)->create();
        }
    }
}
