<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [
            'Web Development',
            'Software Development',
            'Data Science Fundamentals',

        ];
        foreach ($courses as $course){
            Course::factory()->create([
               "name" => $course,
            ]);
        }
    }
}
