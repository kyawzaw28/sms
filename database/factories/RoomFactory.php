<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $roomNames = [
            'Room1',
            'Room2',
            'Room3',
            'Room4',
            'Room5',
            'Room6',
        ];

        return [
            'name' =>$this->faker->unique()->randomElement($roomNames),
        ];
    }
}
