<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Classitem;

class ClassitemStudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $studentIds = Student::pluck('id')->toArray();
        $classitemIds = Classitem::pluck('id')->toArray();
        return [            
            'classitem_id' => $this->faker->randomElement($classitemIds),
            'student_id' => $this->faker->randomElement($studentIds),
        ];
    }
}
