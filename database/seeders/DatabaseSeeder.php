<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CourseSeeder::class);
        \App\Models\Room::factory()->count(6)->create();
        \App\Models\Role::create(['name'=>'Admin']);
        \App\Models\Role::create(['name'=>'Lecturer']);
        \App\Models\User::factory()->count(20)->create();
        \App\Models\Student::factory()->count(20)->create();
        \App\Models\Classitem::factory()->count(6)->create();
        \App\Models\ClassitemStudent::factory()->count(20)->create();
        \App\Models\UserClassitem::factory()->count(20)->create();
        $this->call(PaymentSeeder::class);
    }
}
