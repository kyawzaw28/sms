<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classitem;
class ClassitemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Classitem::factory()->count(6)->create();
    }
}
