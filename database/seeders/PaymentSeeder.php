<?php

namespace Database\Seeders;

use App\Models\Classitem;
use App\Models\ClassitemStudent;
use Illuminate\Database\Seeder;
use App\Models\Payment;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        // $paid = [100000, 300000, 40000];       
        // $dueAmount = $this->faker->randomElement($paid);
        
        // $type = ($dueAmount === 0 ) ? 'paid' : 'unpaid';
        
        // $studentIds = Student::pluck('id')->toArray();
        // $classitemIds = Classitem::pluck('id')->toArray();
        // return [
        //     'fees' => Classitem::inRandomOrder()->first()->price,
        //     'due_amount' => $dueAmount,
        //     'payment_type' => $type,
        //     'payment_method' => $this->faker->randomElement($paymentMethod),
        //     'student_id' => ClassitemStudent::inRandomOrder()->first()->student_id,
        //     'classitem_id' => ClassitemStudent::inRandomOrder()->first()->classitem_id,
        // ];
        $paid = [100000, 300000, 40000];       
        $paidAmount = $faker->randomElement($paid);
        $paymentMethod = ['cash', 'card', 'bank transfer'];

        $classitemStudent = ClassitemStudent::all();
        foreach($classitemStudent as $classStudent){

            $fees =  Classitem::find($classStudent->classitem_id)->price;
            $dueAmount = $fees - $paidAmount;
             $type = ($dueAmount === 0 ) ? 'paid' : 'unpaid';
            Payment::create([
                    'fees' => Classitem::find($classStudent->classitem_id)->price,
                    'due_amount' => $dueAmount,
                    'payment_type' => $type,
                    'payment_method' => $faker->randomElement($paymentMethod),
                    'student_id' => $classStudent->student_id,
                    'classitem_id' => $classStudent->classitem_id
            ]);
            
        };
    }
}
