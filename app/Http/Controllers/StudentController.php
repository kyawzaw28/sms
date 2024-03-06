<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Classitem;
use App\Models\Course;
use App\Models\Payment;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $classitems = Classitem::all();
        $courses = Course::all();
        $totalStudents = Student::all()->count();
        $searchByClass = Classitem::where('id' , request('studentByClass'))->get();

        $students = Student::query();
        $studentByClass = $request->studentByClass;
        $studentByCourse = $request->studentByCourse;



        if(request()->has('studentByCourse') || request()->has('studentByClass')){

            $students = $students->whereHas('classitems' , function($query){
                $query->where("classitems.id" , request('studentByClass'));
            })->whereHas('classitems' , function($query){
                $query->where('course_id' , request('studentByCourse'));
            })->when( request("keyword") , function ($query){
                $keyword = request('keyword');
                $query->where("name" , "like",  "%$keyword%")->where("name" , "like" , "%$keyword%")
                ->orWhere( "email" , "like" , "%$keyword%");
            })
            ->paginate(15);


        }

        else if (request('keyword')){


            $students = $students->when( request("keyword") , function ($query){
                $keyword = request('keyword');
                $query->where("name" , "like",  "%$keyword%")->where("name" , "like" , "%$keyword%")
                ->orWhere( "email" , "like" , "%$keyword%");
            })->whereHas('classitems' , function($query){

                $query->where("classitems.id" , request('studentByClass'));
            })->whereHas('classitems' , function($query){
                $query->where('course_id' , request('studentByCourse'));
            })
            ->paginate(15);

        }
        else{
            $students = Student::latest()->paginate(15);
        }

        if ($request->ajax()) {
            $view = view('students.data', compact('students'))->render();

            return response()->json(['html' => $view]);
        }

        return view('students.index' , compact('students' , 'totalStudents' , 'classitems' , 'courses' , 'searchByClass'))->with('message' , 'Students create successful');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Classitem::all();
        $courses = Course::all();
        return view('students.create' , compact('classes' , 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
    {
        
        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->address = $request->address;
        $student->phone = $request->phone;
        $student->save();
       


        if($request->classitem_id > -1 ){
        $current_paid = $request->due_amount;
        $currentStudentPayment = Payment::where('student_id' , $request->student_id)->orderBy('id', 'DESC')->first();


            $classitem = Classitem::find(request('classitem_id'));
            $classitemPrice = $classitem->price;
            $due_amount = (int) $classitemPrice - (int) request('due_amount');
            if($currentStudentPayment !== null){
                $currentStudentLastPayment = $currentStudentPayment->due_amount;
                $due_amount = (int) $currentStudentLastPayment - (int) request('due_amount');
            }else{
                $due_amount = (int) $classitemPrice - (int) request('due_amount');
            }

            $payment = new Payment();
            $payment->fees = $classitemPrice;
            $payment->due_amount = $due_amount;
            $payment->classitem_id = $request->classitem_id;
            $payment->student_id = $student->id;
            if(request('due_amount') > $due_amount || request('due_amount') > $classitemPrice){
                return redirect()->route('classitem.show' , $classitem->id )->with('message', 'This amount is exceeded');
             }else{
                 $payment->due_amount = $due_amount;
             }
            $payment_type = ( $due_amount === 0 ) ? 'paid' : 'unpaid';
            $payment->payment_type = $payment_type;
            $payment->payment_method = $request->payment_method;
            $payment->save();
            $student->classitems()->attach($request->classitem_id);

            // return to invoice
            if($request->slip == 'on' & $request->due_amount > 0 ) {
                return view('payment.invoice', compact('classitem','student','payment','current_paid'));
                // return view('payment.invoice');
            }
            // return to invoice
        }

        return redirect()->route('student.index')->with('message' , 'Student created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit( Student $student)
    {

        return view('students.edit' , compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentRequest  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
       
        $student->name = $request->name;
        $student->email = $request->email;
        $student->address = $request->address;
        $student->phone = $request->phone;
        $student->update();
        

        return redirect()->route('student.index');
    }

    public function getClassitems(Request $request){
        // $paymentModal = $student->payments()
        // ->select('payments.*', 'classitems.name as classitem_name', 'courses.name as course_name','students.name as student_name')
        // ->join('classitems', 'classitems.id', '=', 'payments.classitem_id')
        // ->join('courses', 'courses.id', '=', 'classitems.course_id')
        // ->join('students','students.id','=', 'payments.classitem_id');

        $classitems = Student::find($request->studentId)
        ->classitems()
        ->select('courses.name as course_name','classitems.*' )
        ->join('courses','courses.id','=','classitems.course_id')
        ->with(['users' => function($query) {
            $query->select('name');
        }])   
        ->get()        
        ;
       
        return response()->json($classitems);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('student.index')->with('del' , 'Student delete successfully');
    }

    public function relatedClass(Student $student){
        $studentoption = Student::all();
        $courseoption = Course::all();
        $classitems = $student->classitems;
        $selectedStudent = $student;

        // return view('students.class-student' , compact('classitems' , 'studentoption' , 'courseoption' , 'selectedStudent'));
        
        return view('students.class-student' , compact('classitems' , 'studentoption' , 'courseoption' , 'selectedStudent'));
    }

    public function relatedPayment(Student $student, Request $request){

        $payments = $student->payments()->whereIn('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                  ->from('payments')
                  ->groupBy('classitem_id', 'student_id');
        })->paginate(10);

        $paymentModal = $student->payments()
        ->select('payments.*', 'classitems.name as classitem_name', 'courses.name as course_name','students.name as student_name')
        ->join('classitems', 'classitems.id', '=', 'payments.classitem_id')
        ->join('courses', 'courses.id', '=', 'classitems.course_id')
        ->join('students','students.id','=', 'payments.student_id')
        ->whereIn('payments.id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('payments')
                ->groupBy('classitem_id', 'student_id');
        })
        ->get();
        $studentoption = Student::all();
        $courseoption = Course::all();
        $classitems = Classitem::all();
        $selectedStudent = $student;

        if ($request->ajax()){
            return response()->json($paymentModal);
        }

        return view('students.payment-student' , compact(['classitems' , 'studentoption' , 'courseoption' ,'selectedStudent' , 'payments']));
    }

    public function studentsearch(Request $request)
    {
        $output="";
        $classitems = Classitem::all();
        $courses = Course::all();
        $totalStudents = Student::all()->count();
        $searchByClass = Classitem::where('id' , request('studentByClass'))->get();

        $students = Student::query();
        $studentByClass = $request->studentByClass;
        $studentByCourse = $request->studentByCourse;


        // $students = $students->when(request('studentByCourse' , '!==' , 'all') , function($query){
        //     $query->whereHas('classitems' , function($query){
        //         $query->where("classitems.id" , request('studentByClass'));
        //     })->whereHas('classitems' , function($query){
        //         $query->where('course_id' , request('studentByCourse'));
        //     });
        // });

        if(request()->has('studentByCourse') || request()->has('studentByClass')){
                if(request('studentByCourse') == -1 && request('studentByClass')  == -1 ){
                    $students = Student::latest()->paginate(15);                  
                }else{
                    $students = $students->whereHas('classitems' , function($query){
                        $query->where("classitems.id" , request('studentByClass'));
                    })->orWhereHas('classitems' , function($query){
                        $query->where('course_id' , request('studentByCourse'));
                    })->when( request("keyword") , function ($query){
                        $keyword = request('keyword');
                        $query->where("name" , "like",  "%$keyword%")
                        ->orWhere("address" , "like" , "%$keyword%")
                        ->orWhere( "email" , "like" , "%$keyword%");
                    })
                    ->paginate(15);
                }

        }

        
       


        else if (request('keyword')){


            $students = $students->when( request("keyword") , function ($query){
                $keyword = request('keyword');
                $query->where("name" , "like",  "%$keyword%")
                ->orWhere("address" , "like" , "%$keyword%")
                ->orWhere( "email" , "like" , "%$keyword%");
            })->whereHas('classitems' , function($query){

                $query->where("classitems.id" , request('studentByClass'));
            })->whereHas('classitems' , function($query){
                $query->where('course_id' , request('studentByCourse'));
            })
            ->paginate(15);

        }
        else{
            $students = Student::latest()->paginate(15);
        }



        
        if(count($students)>0){
            foreach($students as $student)
            {
                $output.='
                <tr>
    <td scope="row">' . $student->name . '</td>
    <td>
        <p class="mb-0 d-block d-md-none">' . Str::limit($student->email, 15, '...') . '</p>
        <p class="mb-0 d-none d-md-block">' . $student->email . '</p>
        <p class="mb-0 text-black-50">' . $student->phone . '</p>
    </td>
    <td class="d-none d-lg-table-cell">
        <p>' . Str::limit($student->address, 50, '...') . '</p>
    </td>
    <td class="align-middle text-center">
        <a href="' . route('student.relatedPayment', $student->id) . '" class="btn table-btn-sm btn-primary">
            <i class="mdi mdi-credit-card-multiple h5"></i>
        </a>
    </td>
    <td class="align-middle text-center">
        <a href="' . route('student.relatedClass', $student->id) . '" class="btn table-btn-sm btn-primary">
            <i class="mdi mdi-book-open-page-variant h5"></i>
        </a>
    </td>
    <td class="text-end align-middle text-nowrap">
        <div class="d-none d-md-block control-btns">
            <a href="' . route('student.edit', $student->id) . '" class="btn table-btn-sm btn-primary">
                <i class="mdi mdi-pencil h5"></i>
            </a>
            <form action="' . route('student.destroy', $student->id) . '" class="d-inline-block" method="post">
            <input type="hidden" name="_token" value="' . csrf_token() . '">
            <input type="hidden" name="_method" value="delete">
                <button type="submit" class="btn table-btn-sm btn-danger del-btn alertbox">
                    <i class="mdi mdi-delete h5 text-white"></i>
                </button>
            </form>
        </div>
        <div class="btn-group control-btn dropup d-block d-md-none">
            <button type="button"
                class="btn table-btn-sm btn-outline-dark border border-0 dropdown-toggle"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-dots-vertical h4"></i>
            </button>
            <ul class="dropdown-menu mb-1">
                <div class="d-flex">
                    <li>
                        <a href="' . route('student.edit', $student->id) . '"
                            class="btn table-btn-sm btn-outline-primary border border-0">
                            <i class="mdi mdi-pencil h5"></i>
                        </a>
                    </li>
                    <li>
                        <form action="' . route('student.destroy', $student->id) . '" method="post">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="delete">
                            <button type="submit" class="btn table-btn-sm btn-outline-danger border border-0">
                                <i class="mdi mdi-delete h5 "></i>
                            </button>
                        </form>
                    </li>
                </div>
            </ul>
        </div>
    </td>
</tr>';

}
} else {
    $output .= '<tr>
    <td colspan="6" class="text-center text-black">Data is empty</td>
</tr>';
}
return response()->json($output);
    }

}


