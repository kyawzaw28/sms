<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserClassitem;

class UserClassitemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserClassitem::factory()->count(10)->create();
    }
}
