<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassitemStudent;

class ClassitemStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClassitemStudent::factory()->count(10)->create();
    }
}
