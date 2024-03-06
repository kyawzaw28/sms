<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use PhpParser\Builder\Class_;

use App\Models\Course;
use App\Models\Classitem;
use App\Models\ClassitemStudent;
use App\Models\Student;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

use Illuminate\Http\Request as HttpRequest;



class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {



                // if($request->has('paymentByStudent')){
        //     return $request;
        // }


        $classitems = Classitem::all();
        $courses = Course::all();
        $students = Student::all();
        $payments = Payment::all();

        $latestPayments = Payment::whereIn('id', function ($query) {
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
                    $query->where("name" ,'like' , "%$keyword%")->orWhereHas('course' , function($query){

                        $keyword = request('search');
                        $query->where('name' , 'like' , "%$keyword%");
                    });
                })
                ->orWhereHas('student' , function($query){
                    $keyword = request('search');
                    $query->where("name" ,'like' , "%$keyword%");
                });
            });

        }

        // if($paymentByClass && $paymentByCourse && $paymentByStudent){




        //     $latestPayments = $latestPayments->where('student_id' , $paymentByStudent)
        //                         ->whereHas('classitem' , function($query){
        //         $query->where("id" , request('paymentByClass'));
        //     })->whereHas('classitem' , function($query){
        //         $query->where('course_id' , request('paymentByCourse'));
        //     })
        //     ->paginate(10);


        //     //->when( request("keyword") , function ($query){
        //     //     $keyword = request('keyword');
        //     //     $query->where("name" , "like",  "%$keyword%")->where("name" , "like" , "%$keyword%")
        //     //     ->orWhere( "email" , "like" , "%$keyword%");
        //     // })->get();




        // }
        // elseif($paymentByStudent && $paymentByCourse){
        //     $latestPayments = $latestPayments->where('student_id' , $paymentByStudent)
        //                         ->orWhereHas('classitem' , function($query){
        //         $query->where("id" , request('paymentByClass'));
        //     })->whereHas('classitem' , function($query){
        //         $query->where('course_id' , request('paymentByCourse'));
        //     })
        //     ;
        // }
        // elseif($paymentByCourse && $paymentByClass){
        //     $latestPayments = $latestPayments->orWhere('student_id' , $paymentByStudent)
        //                         ->whereHas('classitem' , function($query){
        //         $query->where("id" , request('paymentByClass'));
        //     })->whereHas('classitem' , function($query){
        //         $query->where('course_id' , request('paymentByCourse'));
        //     })
        //     ;
        // }
        // elseif($paymentByClass && $paymentByStudent){
        //     $latestPayments = $latestPayments->where('student_id' , $paymentByStudent)
        //                         ->whereHas('classitem' , function($query){
        //         $query->where("id" , request('paymentByClass'));
        //     })->orWhereHas('classitem' , function($query){
        //         $query->where('course_id' , request('paymentByCourse'));
        //     })
        //     ;
        // }else{
            if($paymentByStudent){
                $latestPayments = $latestPayments->where('student_id' , $paymentByStudent);
                // return $latestPayments;
            }
            if($paymentByClass){
                $latestPayments = $latestPayments->whereHas('classitem' , function($query){
                    $query->where("id" , request('paymentByClass'));
                });
            }
            if($paymentByCourse){
                $latestPayments = $latestPayments->whereHas('classitem' , function($query){
                    $query->where('course_id' , request('paymentByCourse'));
                });
            }

        // }







        $latestPayments = $latestPayments->orderBy('id' , 'desc')->paginate(15)->withQueryString();







        // $searchData = $latestPayments->paginate(10);
        $totalPayment =  Payment::whereIn('id', function ($query) {
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

        if ($request->ajax()) {
            $view = view('payment.data', compact('latestPayments'))->render();

            return response()->json(['html' => $view]);
        }

        return view('payment.index',compact('latestPayments' , 'total' , 'payments' , 'classitems' , 'courses' , 'students'));

        // 27.7.23

    }

    public function getPayments(Request $request)
    {
        $payments = Payment::where('student_id', $request->studentId)->where('classitem_id', $request->classitemId)->with('student')->get();
        return response()->json($payments);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentRequest $request)
    {   
        $student = Student::find($request->student_id);
        $current_paid = $request->due_amount;

        $currentStudentPayment = Payment::where('student_id' , $request->student_id)
        ->where('classitem_id' , $request->classitem_id)->orderBy('id', 'DESC')->first();
   
        
        $classitem = Classitem::find(request('classitem_id'));
        $classitemPrice = $classitem->price;
    
       

        if($currentStudentPayment !== null){
            
            $currentStudentLastPayment = $currentStudentPayment->due_amount;
            $due_amount = (int) $currentStudentLastPayment - (int) request('due_amount');
            
        }else{
            
            $due_amount = (int) $classitemPrice - (int) request('due_amount');
            
        }


        $payment = new Payment();
        $payment->fees = $classitemPrice;

        $payment->classitem_id = $request->classitem_id;
        $payment->student_id = $request->student_id;
        if(request('due_amount') > $due_amount || request('due_amount') > $classitemPrice){
           return redirect()->route('classitem.show' , $classitem->id )->with('message', 'This amount is exceeded');
        }else{
            $payment->due_amount = $due_amount;
        }
        $payment_type = ( $due_amount === 0 ) ? 'paid' : 'unpaid';
        $payment->payment_type = $payment_type;
        $payment->payment_method = $request->payment_method;
        $payment->save();


        $stuCla = ClassitemStudent::where('student_id' , $request->student_id)->where('classitem_id' , $request->classitem_id )->count();
       
        
        if($stuCla == 0){
            
            $studentClass = new ClassitemStudent();
            $studentClass->student_id = $request->student_id;
            $studentClass->classitem_id = $request->classitem_id;
            $studentClass->save();
            
        }
        
         // return to invoice
         if($request->slip == 'on' & $request->due_amount > 0 ) {
            return view('payment.invoice', compact('classitem','student','payment','current_paid'));
            
        }
        // dd($payment);
        // return to invoice

        return redirect()->route('payment.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view("payment.show");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentRequest  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }

    public function classdetail(Request $request){

        return $request;
        // return $request->studentname;
    }


    public function paymentFromModal (Request $request){
    

    $classitem = Classitem::find(request('classitem_id'));
    $student= Student::find(request('student_id'));
    $current_paid = $request->due_amount;


        
        $classitemPrice = $classitem->price;
        $currentStudentPayment = Payment::where('student_id' , $request->student_id)
        ->where('classitem_id' , $request->classitem_id)->orderBy('id', 'DESC')->first();
        // $latestPayments = Payment::where('student_id' ,  $request->student_id)->whereIn('id', function ($query) {
        //     $query->select(DB::raw('MAX(id)'))
        //           ->from('payments')
        //           ->groupBy('classitem_id', 'student_id');
        // });
        


        if($currentStudentPayment !== null){
            
            $currentStudentLastPayment = $currentStudentPayment->due_amount;
            $due_amount = (int) $currentStudentLastPayment - (int) request('due_amount');
        }else{
            
            $due_amount = (int) $classitemPrice - (int) request('due_amount');
            $classitemPrice;
            
        }

        // return $due_amount;

        $payment = new Payment();
        $payment->fees = $classitemPrice;
        
        $payment->classitem_id = $request->classitem_id;
        $payment->student_id = $request->student_id;
        if(request('due_amount') > $due_amount && request('due_amount') > $classitemPrice){
           return redirect()->route('payment.index')->with('message' , 'The amount is exceeded');
        }else{
            $payment->due_amount = $due_amount;
        }
        $payment_type = ( $due_amount === 0 ) ? 'paid' : 'unpaid';
        $payment->payment_type = $payment_type;
        $payment->payment_method = $request->payment_method;
        $payment->save();

        // return to invoice
        if($request->slip == 'on' & $request->due_amount > 0 ) {
            return view('payment.invoice', compact('classitem','student','payment','current_paid'));
            // return view('payment.invoice');
        }
        // dd($payment);
        // return to invoice
        return redirect()->route('payment.index');
    }



    public function allPaymentHistory(HttpRequest $request){


        
        $paymentHistory = Student::find($request->student_id)->payments;
       
        $paymentHistory =  $paymentHistory->where('classitem_id' , $request->classitem_id);
    
        return view('students.pay-history-student' , compact('paymentHistory'));
    }

    public function paymentsearch(Request $request)
    {
        $output="";
        // $classitems = Classitem::all();
        // $courses = Course::all();
        // $students = Student::all();
        // $payments = Payment::all();

        $latestPayments = Payment::whereIn('id', function ($query) {
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
                    $query->where("name" ,'like' , "%$keyword%")->orWhereHas('course' , function($query){

                        $keyword = request('search');
                        $query->where('name' , 'like' , "%$keyword%");
                    });
                })
                ->orWhereHas('student' , function($query){
                    $keyword = request('search');
                    $query->where("name" ,'like' , "%$keyword%")->limit(1);
                });
            });

        }




        if($paymentByStudent){
            $latestPayments = $latestPayments->where('student_id' , $paymentByStudent);
            // return $latestPayments;
        }
        if($paymentByClass ){
            $latestPayments = $latestPayments->whereHas('classitem' , function($query){
                $query->where("id" , request('paymentByClass'));
            });
        }
        if($paymentByCourse){
            $latestPayments = $latestPayments->whereHas('classitem' , function($query){
                $query->where('course_id' , request('paymentByCourse'));
            });
        }


        


        $latestPayments = $latestPayments->orderBy('id' , 'desc')->paginate(15)->withQueryString();







        // $searchData = $latestPayments->paginate(10);
        $totalPayment =  Payment::whereIn('id', function ($query) {
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
<tr onclick="showPayments(event, ' . $payment->classitem_id . ', ' . $payment->student_id . ')" class="history" data-className="' . $payment->classitem->name . '" data-studentName="' . $payment->student->name . '" data-bs-toggle="modal" data-bs-target="#exampleModal">

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
    <td class="align-middle">' . Str::limit($payment->classitem->name, 20) . '</td>
    <td class="d-none d-lg-table-cell align-middle">' . Str::limit($payment->classitem->course->name, 15) . '</td>
    <td class="d-none d-lg-table-cell align-middle">' . Str::limit($payment->student->name, 15) . '</td>
    <td class="align-middle">' . number_format(floatval($payment->fees)) . '</td>
    <td class="align-middle">' . number_format(floatval($payment->due_amount)) . '</td>
    <td class="align-middle">';

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
    <td colspan="7" class="text-center text-black">Data is empty</td>
</tr>';
}

return response()->json($output);


}}

