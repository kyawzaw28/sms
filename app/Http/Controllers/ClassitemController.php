<?php

namespace App\Http\Controllers;

use App\Models\Classitem;
use App\Models\Room;
use App\Models\Course;
use App\Models\User;
use App\Http\Requests\StoreClassitemRequest;
use App\Http\Requests\UpdateClassitemRequest;
use App\Models\Student;
use App\Models\UserClassitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClassitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $studentoption = Student::all();
        $courseoption = Course::all();

       

        $classItemQuery = Classitem::query();
        $coursesearchclassitem = $request->coursesearchclassitem;
        $studentsearchclassitem = $request->studentsearchclassitem;


        if($coursesearchclassitem && $studentsearchclassitem) {
            $classItemQuery = $classItemQuery->where('course_id', $request->coursesearchclassitem)
                                ->whereHas('students', function ($query) use ($request) {
                                    $query->where('students.id', $request->studentsearchclassitem);
                                });
        } else {


            if($coursesearchclassitem) {
                $classItemQuery = $classItemQuery->where('course_id', $request->coursesearchclassitem);
            }

            if($studentsearchclassitem) {
                $classItemQuery = $classItemQuery->orWhereHas('students', function ($query) use ($request) {
                    $query->where('students.id', $request->studentsearchclassitem);
                });
            }
        }


        if($request->classitemsearch) {
            $classItemQuery = $classItemQuery->where('name', 'like', '%' . $request->classitemsearch . '%');
        }

        // $classids = $classitemIdsQuery->pluck('id')->toArray();

        $classitem =  $classItemQuery->orderBy('id', 'desc')->paginate(15)->withQueryString();


       
            // $classitem = $this->classitemfilter($classitem);
        // } else {
        //     $classitem =  Classitem::orderBy('id', 'desc')->paginate(7);
        // }

        if ($request->ajax()) {
            $view = view('classitem.data', compact('classitem'))->render();

            return response()->json(['html' => $view]);
        }

        return view('classitem.index', compact(['classitem','courseoption','studentoption']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Classitem::class);
        $roomoption = Room::all();
        $courseoption = Course::all();
        $lectureroption =  User::where('role_id', 2)->get();
        return view('classitem.create',compact(['roomoption','courseoption','lectureroption']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClassitemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClassitemRequest $request)
    {
        $days = $request->days;
        $day_string = implode(', ', $days);       
        $lecturerIds = $request->input('lecturers', []);
        $roomday = Classitem::where('room_id',$request->room)
        ->where('type', $request->daytype)
        ->first();
        $startendtime = Classitem::whereBetween('start_time',[$request->starttime, $request->endtime])
        ->whereBetween('end_time',[$request->starttime, $request->endtime])
        ->exists();
        $startendday=Classitem::whereBetween('start_date',[$request->startdate, $request->enddate])
        ->whereBetween('end_date',[$request->startdate, $request->enddate])
        ->exists();
       

        $classitemId = new Classitem();
            $classitemId->name = $request->name;
            $classitemId->start_date = $request->startdate;
            $classitemId->end_date = $request->enddate;
            $classitemId->course_id = $request->course;
            if(!is_null($roomday) && !is_null($startendtime) && !is_null($startendday)){
                return redirect()->route('classitem.create' )->with('message', 'Room is not Free in that time range. Please select different time');
             }else{
                $classitemId->start_time = $request->starttime;
             }
            $classitemId->end_time = $request->endtime;
            $classitemId->room_id = $request->room;
            $classitemId->day = $day_string;
            $classitemId->price = $request->price;
            $classitemId->max_student = $request->maxstudent;
            $classitemId->container_color = $request->color;
            $classitemId->code = $request->shortcode;
        $classitemId->save();
        $classitemId->users()->attach($lecturerIds);

       

       return redirect()->route('classitem.index')->with('message','Data Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classitem  $classitem
     * @return \Illuminate\Http\Response
     */
    public function show(Classitem $classitem , Request $request)
    {
        $selectedStudent = $request->ss;
        $students = Student::all();
        return view('classitem.show', compact('classitem','students', 'selectedStudent'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classitem  $classitem
     * @return \Illuminate\Http\Response
     */
    public function edit(Classitem $classitem)
    {
        $roomoption = Room::all();
        $courseoption = Course::all();
        $lectureroption =  User::where('role_id', 2)->get();
        return view('classitem.edit',compact(['classitem','courseoption','roomoption','lectureroption']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClassitemRequest  $request
     * @param  \App\Models\Classitem  $classitem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClassitemRequest $request, Classitem $classitem)
    {
        

        
        $days = $request->days;
        $day_string = implode(', ', $days);
        $lecturerIds = $request->lecturer;

        

        
        $classitem->name = $request->name;
        $classitem->start_date = $request->startdate;
        $classitem->end_date = $request->enddate;
        $classitem->course_id = $request->course;
        $classitem->start_time = $request->starttime;
        $classitem->end_time = $request->endtime;
        $classitem->room_id = $request->room;
        $classitem->day = $day_string;
        $classitem->price = $request->price;
        $classitem->max_student = $request->maxstudent;
        $classitem->container_color = $request->color;
        $classitem->code = $request->shortcode;
        $classitem->update();

             
        $classitem->users()->sync($request->input('lecturers', []));
        
       

        return redirect()->route('classitem.index')->with('message', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classitem  $classitem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classitem $classitem)
    {
        $this->authorize('delete', $classitem);
        $classitem->delete();
        return redirect()->route('classitem.index')->with('del', 'Data is deleted');
    }

    public function classPayment(Classitem $classitem)

    {
        $selectedClass = $classitem;
        // $payments = $classitem->payments()->get();
        $payments = $classitem->payments()->whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                  ->from('payments')
                  ->groupBy('classitem_id', 'student_id');
        })->paginate(10);
        $studentoption = Student::all();
        $courseoption = Course::all();
        $classitems = Classitem::all();
        

        return view('classitem.classpayment' , compact(['classitems' , 'studentoption' , 'courseoption' ,'selectedClass' , 'payments']));
    }

    public function classitemsearch(Request $request)
    {

        $output="";
        $classItemQuery =  Classitem::query();
        $coursesearchclassitem = $request->coursesearchclassitem;
        $studentsearchclassitem = $request->studentsearchclassitem;

        
        // if($coursesearchclassitem || $studentsearchclassitem){
        //     if($coursesearchclassitem == -1 && $studentsearchclassitem == -1){
               
        //         $searchdata = $classItemQuery->orderBy('id', 'desc')->paginate(15)->withQueryString();
        //     }elseif($studentsearchclassitem){
                
        //             $classItemQuery = $classItemQuery->whereHas('students', function ($query) use ($studentsearchclassitem) {
        //                 $query->where('students.id', $studentsearchclassitem);
        //             });
                   
                               
        //     }elseif($coursesearchclassitem) {
        //         $classItemQuery = $classItemQuery->where('course_id', $coursesearchclassitem);
        //     }
        // };

        if ($coursesearchclassitem == -1 && $studentsearchclassitem == -1) {
            // Retrieve all data when both criteria are -1
            $searchdata = $classItemQuery->orderBy('id', 'desc')->paginate(15)->withQueryString();
        } else {
            // Apply filters based on search criteria
            if ($coursesearchclassitem && $studentsearchclassitem) {
                // Both course and student criteria provided
                $classItemQuery->where('course_id', $coursesearchclassitem)
                    ->whereHas('students', function ($query) use ($studentsearchclassitem) {
                        $query->where('students.id', $studentsearchclassitem);
                    });
            } else {
                // Only one criteria provided
                if ($coursesearchclassitem) {
                    // Filter based on course criteria
                    $classItemQuery->where('course_id', $coursesearchclassitem);
                }
        
                if ($studentsearchclassitem) {
                    // Filter based on student criteria
                    $classItemQuery->whereHas('students', function ($query) use ($studentsearchclassitem) {
                        $query->where('students.id', $studentsearchclassitem);
                    });
                }
            }
        }
        

        

        // if($coursesearchclassitem || $studentsearchclassitem){
        //     if($coursesearchclassitem == -1 && $studentsearchclassitem == -1){
        //         $searchdata = $classItemQuery->orderBy('id', 'desc')->paginate(15)->withQueryString();
        //     }
        // };

        
      
        // elseif($coursesearchclassitem && $studentsearchclassitem){
        //     $classItemQuery = $classItemQuery->where('course_id', $coursesearchclassitem)
        //                             ->whereHas('students', function ($query) use ($studentsearchclassitem) {
        //                                 $query->where('students.id', $studentsearchclassitem);
        //                             });
        // }

        // if($coursesearchclassitem && $studentsearchclassitem) {
            
        //     $classItemQuery = $classItemQuery->where('course_id', $coursesearchclassitem)
        //                         ->whereHas('students', function ($query) use ($studentsearchclassitem) {
        //                             $query->where('students.id', $studentsearchclassitem);
        //                         });

        // } 

        

        

    //     if($coursesearchclassitem && $studentsearchclassitem) {                   
    //         $classItemQuery = $classItemQuery->where('course_id', $coursesearchclassitem)
    //                             ->whereHas('students', function ($query) use ($studentsearchclassitem) {
    //                                 $query->where('students.id', $studentsearchclassitem);
    //                             });

    // }else{
    //         if($coursesearchclassitem) {
    //         $classItemQuery = $classItemQuery->where('course_id', $coursesearchclassitem);
    //     }

    //     if($studentsearchclassitem) {
    //         $classItemQuery = $classItemQuery->whereHas('students', function ($query) use ($studentsearchclassitem) {
    //             $query->where('students.id', $studentsearchclassitem);
    //         });
    //     }
    
    // }
        

        

        if($request->classitemsearch) {
            $classItemQuery = $classItemQuery->where('name', 'like', '%' . $request->classitemsearch . '%')
            ->orWhereHas('course', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->classitemsearch . '%');
            })
            ->orWhereHas('users', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->classitemsearch . '%');
            });
        };

        $searchdata = $classItemQuery->orderBy('id', 'desc')->paginate(15)->withQueryString();



if(count($searchdata)>0){
    foreach($searchdata as $classdata)
    {

    $output .=
    '
    <tr>
      <td class="align-middle">
        <p class="d-none d-md-block text-cut">' .Str::limit($classdata->name,20). '</p>
        <div class="d-block d-md-none">
          <p>' . $classdata->name . '</p>
          <p class=" text-black-50 text-cut">'.Str::limit($classdata->users->pluck('name')->implode(', '),20).' </p>
        </div>
      </td>
      <td class="align-middle">'.Str::limit($classdata->course->name,20).'</td>
      <td class="d-none d-md-table-cell align-middle" >'.Str::limit($classdata->users->pluck('name')->implode(', '),20).' </td>
      ';
      $isUnpaid = false;
      foreach ($classdata->payments as $payment) {
      if ($payment->payment_type === "unpaid") {
      $isUnpaid = true;
      break;
      }
      }
      if ($isUnpaid) {
      $output .= '
      <td class=" align-middle">
        <div
          class="text-danger fw-bold pay-status d-flex  ">
          unpaid
        </div>
      </td>
      ';
      } else {
      $output .= '
      <td class=" align-middle">
        <div class="text-success fw-bold pay-status d-flex  ">
          paid
        </div>
      </td>
      ';
      }
      $output .= '<td class="d-none d-md-table-cell align-middle text-center">
      <a href="' . route('classitem.classPayment', $classdata->id) . '" class="btn table-btn-sm btn-primary">
          <i class="mdi mdi-credit-card-multiple h5"></i>
      </a>
    </td>';
    $output .= '<td class="text-end align-middle text-nowrap">
        <div class="d-none d-md-block control-btns">';
        $output .= '<a href="' . route('classitem.edit', $classdata) . '" class="me-1 btn table-btn-sm btn-primary ">
        <i class="mdi mdi-pencil h5"></i>
    </a>';
    $output .= '<a href="' . route('classitem.show', $classdata) . '" class="btn table-btn-sm btn-primary">
    <i class="mdi mdi-information-outline h5"></i>
    </a>';
    $output .= '<form action="' . route('classitem.destroy', $classdata->id) . '" method="post" class="d-inline">
    <input type="hidden" name="_token" value="' . csrf_token() . '">
    <input type="hidden" name="_method" value="delete">
    <button type="submit" class="btn table-btn-sm btn-danger del-btn alertbox">
        <i class="mdi mdi-delete h5 text-white"></i>
    </button>
    </form>';
    $output .= '</div>

    <div class="btn-group dropup d-block d-md-none control-btn">
        <button type="button" class="btn table-btn-sm btn-outline-dark border border-0 dropdown-toggle"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="mdi mdi-dots-vertical h4"></i>
        </button>

        <ul class="dropdown-menu mb-1">
            <div class="d-flex justify-content-around">
                <li>
                    <a href="' . route('classitem.edit', $classdata) . '" class="btn table-btn-sm btn-outline-primary border border-0">
                        <i class="mdi mdi-pencil h5"></i>
                    </a>
                </li>
                <li>
                    <form action="' . route('classitem.destroy', $classdata->id) . '" method="post" class="d-inline">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="delete">
                        <button type="submit" class="btn table-btn-sm btn-outline-danger border border-0 alertbox">
                            <i class="mdi mdi-delete h5 "></i>
                        </button>
                    </form>
                </li>
                <li>
                    <a href="' . route('classitem.show', 'detail') . '" class="btn table-btn-sm btn-outline-secondary border border-0">
                        <i class="mdi mdi-information-outline h4"></i>
                    </a>
                </li>
            </div>
        </ul>
    </div>
    </td></tr>';
}
} else {
    $output .= '<tr>
    <td colspan="6" class="text-center text-danger">Data not found</td>
</tr>';
}



// return response($output);
// if ($request->ajax()) {
//     $view = view('classitem.data', compact('searchdata'))->render();

//     $data =  response()->json(['html' => $view]);
// }

return response()->json($output);

}


   



public function classPaymentSearch(Request $request)
    {
        $output="";
       

        $classitem = Classitem::find(request('classId'));
        // $latestPayments = Payment::whereIn('id', function ($query) {
        //     $query->select(DB::raw('MAX(id)'))
        //           ->from('payments')
        //           ->groupBy('classitem_id', 'student_id');
        // });
        $latestPayments = $classitem->payments()->whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                  ->from('payments')
                  ->groupBy('classitem_id', 'student_id');
        });

        $paymentByStudent = $request->paymentByStudent;
        $paymentByClass = $request->paymentByClass;
        $paymentByCourse = $request->paymentByCourse;

        if (request('search')){
            $latestPayments = $latestPayments->where(function($q) {
                $q->whereHas('classitem' , function($query){
                    $keyword = request('search');
                    $query->where("name" ,'like' , "%$keyword%");
                })
                ->orWhereHas('student' , function($query){
                    $keyword = request('search');
                    $query->where("name" ,'like' , "%$keyword%")->limit(1);
                });
            });

        }

      


        $latestPayments = $latestPayments->orderBy('id' , 'desc')->paginate(15)->withQueryString();



        // $searchData = $latestPayments->paginate(10);
        $totalPayment =  $classitem->payments()->whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                  ->from('payments')
                  ->groupBy('classitem_id', 'student_id');
        })->get();

        $total = count($totalPayment);

        // return $latestPayments;

        // foreach ($latestPayments as $payment) {
        //     $classId = $payment->class_id;
        //     $studentId = $payment->student_id;

        //     echo "<pre>";
        //     echo $payment ;
        //     echo "</pre>";
        // }


        // return count($payments);

        if(count($latestPayments)>0){
            foreach($latestPayments as $payment)
            {
        $output .= '
<tr onclick="showPayments(event, ' . $payment->classitem_id . ', ' . $payment->student_id . ')" class="history" data-className="' . $payment->classitem->name . '" data-studentName="' . $payment->student->name . '" data-bs-toggle="modal" data-bs-target="#exampleModalTwo">

    <td class="d-table-cell d-lg-none text-nowrap align-middle">
        <p>' . $payment->created_at . '</p>
        <p>' . $payment->student->name . '</p>
    </td>
    <td class="fees d-none">'
        . $payment->fees  .
    '</td>
    <td class="paid d-none">'
       . $payment->due_amount .
   '</td>

    <td class="d-none d-lg-table-cell align-middle">' . $payment->created_at->format('d-m-Y') . '</td>
   
    
    <td class="d-none d-lg-table-cell align-middle">' . Str::limit($payment->student->name, 15) . '</td>
    <td class="align-middle">' . number_format(floatval($payment->fees)) . '</td>
    <td class="align-middle">' . number_format(floatval($payment->due_amount)) . '</td>
    <td class="text-center">';

        if ($payment->payment_type=="paid"){
            $output.='<div class="text-success fw-bold pay-status ">
                paid
            </div>';
        } else {
            $output.='<div class=" text-danger fw-bold pay-status ">
                unpaid
            </div>';
        }
    $output.= '</td>
</tr>';
}
} else {
    $output .= '<tr>
    <td colspan="6" class="text-center text-danger">Data not found</td>
</tr>';
}

return response()->json($output);




}}
