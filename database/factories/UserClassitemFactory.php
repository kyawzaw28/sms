<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Classitem;

class UserClassitemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userIds = User::where('role_id', '=', '1')->pluck('id')->toArray();
        $classitemIds = Classitem::pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($userIds),
            'classitem_id' => $this->faker->randomElement($classitemIds),
        ];
    }
}
