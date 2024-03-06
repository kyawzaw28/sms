<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Room;
use App\Models\Course;

class ClassitemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $classitemNames = $this->faker->randomElement(['Object Oriented PHP & MVC','Java Tutorial for Complete Beginners','The Complete Python Bootcamp From Zero to Hero in Python','Microsoft Excel - Excel from Beginner to Advanced','Automate the Boring Stuff with Python Programming','Machine Learning : Python & R in Data','Complete 2023 Web']);
        $stTimes = ['7:00','8:00','9:00','10:00','11:00','12:00'];
        $edTimes= ['13:00','14:00','15:00','16:00','17:00','18:00','19:00'];
        $start = $this->faker->dateTimeBetween('-6 months', 'now');
        $day = $this->faker->randomElement(["Monday, Tuesday, Thursday", "Saturday, Sunday", "Tuesday, Wednesday, Friday", "Friday, Monday, Tuesday","Wednesday, Thursday, Friday"]);
        $is_weekend = in_array("saturday", explode(", ", strtolower($day))) || in_array("sunday", explode(", ", strtolower($day)));
        $type = $is_weekend ? "weekend" : "weekdays";
        $shortCodeWords = explode(' ', $classitemNames);
        $shortCode=strtoupper(substr(implode('', $shortCodeWords), 0, 4));
        $roomIds = Room::pluck('id')->toArray();
        $courseIds = Course::pluck('id')->toArray();
        return [
            'name'=>$classitemNames,
            'start_date'=>$start,
            'end_date'=>$this->faker->dateTimeBetween($start, '+9months'),
            'start_time'=>$this->faker->randomElement($stTimes),
            'end_time'=>$this->faker->randomElement($edTimes),
            'day'=>$day,
            'container_color'=>$this->faker->hexcolor(),
            'max_student'=>$this->faker->numberBetween(20, 30),
            'type'=>$type,
            'price'=>$this->faker->numberBetween(2000000, 4000000),
            'code'=>$shortCode,
            'room_id' => $this->faker->randomElement($roomIds),
            'course_id'=> $this->faker->randomElement($courseIds),

        ];
    }
}
