<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use DateInterval;
use DatePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Classitem;
use App\Models\Room;

use function PHPSTORM_META\type;

class SchedulerController extends Controller
{
    // public static function buildMonth($year, $month)
    // {
    //     $startOfMonth = CarbonImmutable::now();
    //     $endOfMonth = $startOfMonth->endOfMonth();

    //     return [
    //         'year' => $startOfMonth->year,
    //         'month' => $startOfMonth->format('F'),
    //     ];
    // }

    // public function index(){

    //     $period = CarbonPeriod::create('2023-06-14', '2023-12-20');
    //     $i = 6;


    //     // Iterate over the period
    //     foreach ($period as $date) {
    //         echo $date->format('m');
    //     }

    //     // Convert the period to an array of dates
    //     $dates = $period->toArray();


    // }





    public static function index()
    {


        // Month Array Create //
        $currentDate = Carbon::today()->startOfMonth();
        $dateDiff  = Carbon::today()->addMonths(5);
        $period = CarbonPeriod::create($currentDate , $dateDiff , '1 month');
        $monthArr = $period->toArray();

        // Time Array Create //
        $currentTime = Carbon::create(2023 , 7 , 19 , 6 );
        $timeArr = [];

        for($i=0 ; $i<=12 ; $i++){
            $time = $currentTime->addHours(1)->format('G:i');
            array_push($timeArr , $time);
        }

        // Classitem data and Room data Create //
        $data = Classitem::orderBy('start_date','desc')->get();
        $roomsForSelect = Room::all();

        if(request('keyword')){
            $keyword = request('keyword');
            $rooms = Room::when( request("keyword") , function ($query){
                $query->where("name" , request('keyword'));
            })->orWhereHas( 'classitems' , function($query) use ($keyword) {
                $query->where('name' , 'like' , "%$keyword%");
            })->get();
        }else{
            $rooms = Room::all();
          
        
        }




        return view('scheduler.index' , compact(['monthArr' , 'timeArr', 'data' ,'rooms' , 'roomsForSelect']));
    }


    public function nextMonth($from ){

        // Month Array Create //
        $currentDate = Carbon::create($from);
        $dateDiff = $currentDate->addMonths(5);
        $period = CarbonPeriod::create( $from , $dateDiff , '1 month');
        $monthArr = $period->toArray();

        // Time Array Create //
        $currentTime = Carbon::create(2023 , 7 , 19 , 6 );
        $timeArr = [];
        for($i=0 ; $i<=12 ; $i++){
            $time = $currentTime->addHours(1)->format('G:i');
            array_push($timeArr , $time);
        };

        // Classitem data and Room data Create //
        $data = Classitem::orderBy('start_date','desc')->get();
        $roomsForSelect = Room::all();
        if(request('keyword')){
            $rooms = Room::when( request("keyword") , function ($query){
                $query->where("name" , request('keyword'));
            })->orWhereHas('classitems' , function($query){
                $keyword = request('keyword');
                $query->where('name' , 'like' , "%$keyword%");
            })
            ->get();
        }else{
            $rooms = Room::all();
        }

        return view('scheduler.index' , compact(['monthArr' , 'timeArr', 'data' ,'rooms' , 'roomsForSelect']));


    }

    public function preMonth($from){

        // Month Array Create //
        $currentDate = Carbon::create($from);
        $dateDiff = $currentDate->subMonths(5);
        $period = CarbonPeriod::create( $dateDiff ,$from ,  '1 month');
        $monthArr = $period->toArray();

        // Time Array Create //
        $currentTime = Carbon::create(2023 , 7 , 19 , 6 );
        $timeArr = [];
        for($i=0 ; $i<=12 ; $i++){
            $time = $currentTime->addHours(1)->format('G:i');
            array_push($timeArr , $time);
        };

        // Classitem data and Room data Create //
        $data = Classitem::orderBy('start_date','desc')->get();
        $roomsForSelect = Room::all();

        if(request('keyword')){

            $rooms = Room::when( request("keyword") , function ($query){
                $query->where("name" , request('keyword'));
            })->orWhereHas('classitems' , function($query){
                $keyword = request('keyword');
                $query->where('name' , 'like' , "%$keyword%");
            })
            ->get();

        }else{
            $rooms = Room::all();
        }

        return view('scheduler.index' , compact(['monthArr' , 'timeArr', 'data' ,'rooms' , 'roomsForSelect']));
    }

}
