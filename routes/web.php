<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassitemController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\SchedulerController;
use App\Models\Lecturer;
use App\Models\Payment;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/login',function(){
    return view('auth.login');
})->name('auth.login')->middleware('guest');

// Route::get('/back',function(){
//     return view('students.index');
// })->name('back');

Route::post('/login',[UserController::class,'login'])->name('user.login');
Route::get('/logout',[UserController::class,'logout'])->name('user.logout');
Route::get('/forgot-password',[UserController::class,'forgetpwdview'])->name('user.forgetpwdview');
Route::post('/forgot-password',[UserController::class,'forgetpwd'])->name('user.forgetpwd');
Route::get('/reset-password/{token}',[UserController::class,'resetpwd'])->name('user.resetpwd');
Route::post('/reset-password',[UserController::class,'postresetpwd'])->name('user.postresetpwd');

Route::middleware(['auth','verified'])->group(function(){
Route::get('/', [ SchedulerController::class , 'index'])->name('schdeuler.index');
Route::get('/nextMonth/{from}' , [ SchedulerController::class , 'nextMonth' ])->name('schedular.nextMonth');
Route::get('/preMonth/{from}' , [ SchedulerController::class , 'preMonth' ])->name('schedular.preMonth');

Route::resource('user', UserController::class);

Route::resource('payment' , PaymentController::class);

Route::get('payments/get' , [ PaymentController::class , 'getPayments' ])->name("payments.get");
Route::get('classitems/get' , [ StudentController::class , 'getClassitems' ])->name("classitems.get");
Route::post('payments/get' , [ PaymentController::class , 'paymentFromModal' ])->name("payments.createModal");


Route::post('paymenthistory' , [ PaymentController::class , 'allPaymentHistory' ])->name('payment.allhistory');

Route::resource('lecturer' , LecturerController::class);

Route::resource('room' , RoomController::class);
Route::resource('course' , CourseController::class);
Route::resource('student' , StudentController::class);
Route::resource('classitem' , ClassitemController::class);

Route::get('student/{student}' , [ StudentController::class , 'relatedPayment' ])->name("student.relatedPayment");
Route::get('student/{student}/class' , [ StudentController::class , 'relatedClass' ])->name("student.relatedClass");

Route::get('classpayment/{classitem}' , [ ClassitemController::class , 'classPayment' ])->name("classitem.classPayment");

//allsearch
Route::get('/classitemsearch',[ClassitemController::class, 'classitemsearch'])->name('classitem.search');
Route::get('/classpaymentsearch',[ClassitemController::class, 'classPaymentSearch'])->name('classitemPayment.search');
Route::get('/adminmsearch',[UserController::class,'adminsearch'])->name('admin.search');
Route::get('/lecturersearch',[LecturerController::class,'lecturersearch'])->name('lecturer.search');
Route::get('/studentsearch',[StudentController::class,'studentsearch'])->name('student.search');
Route::get('/paymentsearch',[PaymentController::class,'paymentsearch'])->name('payment.search');
Route::get('/classitemfilter',[ClassitemController::class, 'classitemfilter'])->name('classitem.filter');

// Route::get('studentmodal/{studentmodal}' , [StudentController::class, 'studentPaymentModal'])->name('student.studentPaymentModal');

});


// views/changeauth
// Route::get('/changeusername',function(){
//     return view('changeauth.usernamechange');
// })->name('cusername');
Route::get('/userInfo' , [UserController::class , 'showInfo'])->name('userInfo');
Route::get('changeusername/{user}',[UserController::class,'changeUsername'])->name('cusername');
Route::put('updateusername/{user}',[UserController::class,'updateUsername'])->name('uusername');
Route::get('changeuseremail/{user}',[UserController::class,'changeUserEmail'])->name('cuseremail');
Route::put('updateuseremail/{user}',[UserController::class,'updateUseremail'])->name('uuseremail');
Route::get('changeuserpassword/{user}',[UserController::class,'changeUserPassword'])->name('cuserpassword');
Route::put('updateuserpassword/{user}',[UserController::class,'updateUserPassword'])->name('uuserpassword');





