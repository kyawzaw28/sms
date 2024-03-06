

@extends('layout.template')
@section('custom')
    <style>
        @media screen and (max-width:460px) {
            #main-wrapper {
                position: fixed !important;
            }

            .max-height {
                padding-bottom: 100px !important;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endsection
@section('ajaxcsrf')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-9">
                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item "><a href="#">Payment</a></li>
                            <li class="breadcrumb-item active " aria-current="page">List</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 ">
                <!-- Button trigger modal -->
                <div class="mx-auto">
                    <div class="ui search">
                        <div class="ui icon input w-100">
                            <input class=" form-control " placeholder="search payment" type="search"
                                value="" id="paymentId" name="search">
                                
                                <i class="search icon"></i>
                            
                        </div>
                       
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>







    <div class="row  px-3 max-height">

        {{-- <div class="col-9 col-sm-12"> --}}
        <div class=" col-sm-12 col-md-9 table-container">
            <div class="card rounded-3 ">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2 mb-lg-0 py-2">
                        <p class="mb-0 fw-bolder">Total - {{$latestPayments->total()}}</p>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <a href="#"
                                class="btn d-flex justify-content-center align-items-center setorigin" style="font-size: 1.3rem;">
                                <i class="mdi mdi-reload"></i>
                            </a>
                        </div>
                        <div class="d-flex justify-content-end  d-xs-block d-md-none ">
                            <button type="button" class="btn plus-btn btn-outline-secondary d-flex " data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                <i class="mdi mdi-filter-outline h5 mb-0"></i>
                            </button>
                        </div>
                    </div>
                    <div class=" table-responsive">
                        <table class="table table-striped table-hover">
                            {{-- <thead>
                                <tr style="border-bottom: 2px solid black">
                                  


                                    <th scope="col" class="d-lg-table-cell list-date-col">Date</th>
                                    <th scope="col" class=" list-class-col">Class</th>
                                    <th scope="col" class="d-none d-lg-table-cell list-course-col">Course</th>
                                    <th scope="col" class="d-none d-lg-table-cell list-student-col">Student</th>
                                    <th scope="col" class=" list-fees-col">Fees</th>
                                    <th scope="col" class=" list-due-col">Due</th>
                                    <th scope="col" class=" text-center list-type-col">Status</th>
                                </tr>
                            </thead> --}}
                            <thead>
                                <tr class="table-header" style="border-bottom: 2px solid black">
                                    <th class="w-15" scope="col">Date</th>
                                    <th class=" w-25" scope="col">Class</th>
                                    <th class=" w-30 d-none d-lg-table-cell" scope="col">Course</th>
                                    <th scope="col" class=" d-none d-lg-table-cell w-auto">Student</th>
                                    <th scope="col" class=" w-auto">Fees</th>
                                    <th scope="col" class=" w-auto">Due</th>
                                    <th scope="col" class=" text-center w-auto">Status</th>
                                </tr>
                            </thead>
                            <tbody class="original" id="data-wrapper">
                                @include('payment.data')    
                            </tbody>
                            <tbody class="find" id="data-wrapper2">
                            </tbody>
                            @if(count($latestPayments)>=15)
                              <tr>
                                <td colspan="7" class="text-center">
                                    <button class="btn btn-secondary load-more-data"><i class="fa fa-refresh"></i> More Data...</button>
                                </td>
                              </tr>
                              @endif
                              <tr>
                                <td colspan="7" class="text-center">
                                    <button class="btn btn-secondary load-more-data2" style="display: none;"><i class="fa fa-refresh"></i> More Data...</button>
                                </td>
                              </tr>
                        </table>
                         <!-- Data Loader -->
    <div class="auto-load text-center" style="display: none;">
        <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
            <path fill="#000"
                d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                    from="0 50 50" to="360 50 50" repeatCount="indefinite" />
            </path>
        </svg>
    </div>
                        <div class=" paginate ">
                            {{-- {{ $latestPayments->links('pagination::bootstrap-4')}} --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-3 d-none d-md-block" >
            <div class="card" style="height: 100%">
                <div class="card-body position-relative filter-card">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="mdi mdi-filter-outline h3 me-1"></i>
                        <p class="  fs-4 mb-2 text-center">Payment Filter</p>
                    </div>
                    <form action="">
                        <div class=" mb-3">
                            
                            <label for="">Student</label>
                            <select class="ui search dropdown w-100 shadow-none "  name="paymentByStudent" style="width: 100%; height:36px;" id="studentId">
                                <option value=" ">Select Student</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" mb-3">
                            <label for="">Course</label>
                            <select id="courseIdPay" class="ui dropdown w-100 shadow-none courseId" style="width: 100%; height:36px;" name="paymentByCourse">
                                <option value = "">Select Course</option>
                                {{-- @foreach($courses as $course)
                                    <option value="{{$course->id}}" {{ $course->id == request('studentByCourse') ? 'selected' : '' }}>
                                        {{$course->name}}
                                    </option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Class</label>
                            <select id="classIdPay" required class="ui dropdown w-100 shadow-none classId" style="width: 100%; height:36px;" name="paymentByClass">
                                <option value = " ">Select Class</option>
                                {{-- @foreach($classitems as $class)
                                    <option value="{{$class->id}}" {{ $class->id == request('studentByClass') ? 'selected' : '' }} >
                                        {{$class->name}}
                                    </option>
                                @endforeach --}}
                            </select>
                        </div>
                        {{-- <div class="d-flex justify-content-center">
                            <div class="position-absolute filterbtn">
                                <button class="btn btn-secondary cnl-btn me-2" type="submit">Cancel</button>
                                <button class="btn btn-primary sub-btn " type="submit">Submit</button>
                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('dataloader')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
@push('scripts')
    

    <div class="modal fade hide" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content rounded-6">
            <div class="modal-header">
              <h5 class="modal-title className" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form target="_blank" action="{{route('payments.createModal')}}" onsubmit = "return(validate());" method="POST" name = "myForm">
                <div class="modal-body">
                    <div class=" mb-2">
                        <span class="">Student name - </span><p class="studentName fw-bold d-inline-block"></p>
                    </div>

                    <div class="payment-list-container">

                        <div>

                        <div class="payment-list">
                        <div class="payment-list-header">
                            <p>Transfer Date</p>
                            <p>Fees</p>
                            <p>Due Amount</p>
                            <p class="text-nowrap">Payment method</p>
                        </div>
                        <div id="paymentList"  class="payHistory">

                        </div>
                        </div>
                        </div>
                    </div>
                    </div>


                    @csrf
                <input type="text" class="d-none" name="student_id" hidden id="curStudentId" value="">
                <input type="text" class="d-none" name="classitem_id" hidden id="curClassId" value="">
                <div class="row p-3">
                    <div class="col-6">
                        <div class="mt-3 mb-3">
                            <label for="amount mb-0">
                                <p class="small-header mb-0">Amount</p>
                                
                            </label>
                            <input type="text" class="form-control  amount" name="due_amount"
                                placeholder="Enter Amount">
                                <span class=" fs-6 text-danger amount-error"></span>               
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-3 mb-3">
                            <label for="">Payment Method</label>
                            <div class="input-group ">
                                <select name="payment_method"
                                    class="form-select slectopt" id="class">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="bank transfer">Bank Transfer</option>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
                <div class=" mb-3 d-flex px-3">
                    <div class="form-group margin-right ">
                        <input name="slip" class=" form-check-input" type="checkbox" name="flexRadioDefault"
                            id="flexRadioDefault1">
                        <label class="form-check-label mb-0" for="flexRadioDefault1">
                            <p class="small-header mb-0">Print out the slip</p>
                        </label>
                    </div>
                </div>
                <div class="text-center p-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                </div>
            </form>
            
          </div>
        </div>
      </div>



    </div>

   
   
   


    {{-- Modal for right side bar --}}
    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Payment Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body  position-relative">

                        <div class=" mb-3">
                            <label for="">Student</label>
                            <select class="ui dropdown w-100 shadow-none js-example-basic-single" class="" name="paymentByStudent" style="width: 100%; height:36px;">
                                <option>Select Student</option>
                                <option value = " ">Select Student</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class=" mb-3">
                            <label for="">Course</label>
                            <select id="courseId" class="ui dropdown w-100 shadow-none courseId" style="width: 100%; height:36px;" name="paymentByCourse">
                                <option value = " ">Select Course</option>
                                {{-- @foreach($courses as $course)
                                    <option value="{{$course->id}}" {{ $course->id == request('studentByCourse') ? 'selected' : '' }}>
                                        {{$course->name}}
                                    </option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Class</label>
                            <select id="classId" required class="select2  form-select shadow-none classId" style="width: 100%; height:36px;" name="PaymentByCourse">
                                <option value = " ">Select Class</option>
                                {{-- @foreach($classitems as $class)
                                    <option value="{{$class->id}}" {{ $class->id == request('studentByClass') ? 'selected' : '' }} >
                                        {{$class->name}}
                                    </option>
                                @endforeach --}}
                            </select>
                        </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>

            </div>
        </div>
    </div>

    <script>

        
          
       

        let className;
        let studentName;
        let fees;
        let paid;

        // $('.history').map(function(){
        //         $(this).on('click', function(){
        //         className = $(this).attr('data-className');
        //         studentName = $(this).attr('data-studentName');
        //         fees = Number($(this).children('.fees').text());
        //         paid = Number($(this).children('.paid').text());
        //         console.log(className , studentName);
        //     });
        // });

        function validate(){
                         
                         let amount = Number(document.myForm.due_amount.value);
                         paid = Number(paid);
                         fees = Number(fees);
                         if(amount > fees || amount > paid ){
                             // console.log(amount , paid);                             
                             $('.amount-error').text('This amount is exceeded');
                             return false;
                         };
 
                         if(amount == ''){
                             $('.amount-error').text('Amount is required');
                             return false;
                         };
                         
                     };


            // Function to show the Bootstrap modal
            function showModal(response){
                // $('#exampleModalLabel').text(className);
                // $('.studentName').text(studentName);
               
                
                
                // console.log(aa);
                response.map(function(el){
                    
                    let text = el.created_at;
                    $('.payHistory').map(function(){
                        $(this).append(`
                        <div class="payment-list-body">
                            <p class="payment-lists">${ text.slice(0, 10) }</p>
                            <p class="payment-lists ">${el.fees}</p>
                            <p class="payment-lists ">${el.due_amount}</p>
                            <p class="payment-lists">${el.payment_method}</p>
                        </div>

                    `);
                    })
                });
                $('#exampleModal').modal('show');
            };


        var ENDPOINT = "{{ route('classitem.index') }}";





      

        function showPayments(event, classitemId, studentId ) {


            $('#curStudentId').val(studentId);
            $('#curClassId').val(classitemId);

            
            className = event.currentTarget.getAttribute('data-className');
            studentName = event.currentTarget.getAttribute('data-studentName');
            fees = $(event.currentTarget).find('.fees').text().trim();
            paid = $(event.currentTarget).find('.paid').text().trim();

            $('#exampleModalLabel').text(className);
            $('.studentName').text(studentName);
            // console.log(className , studentName);
            // console.log(classitemId, studentId);


            $.ajax({
                url: "{{ route('payments.get') }}?classitemId="+classitemId+"&studentId="+studentId,
                type: "get",
            })
            .done(function (response) {
                showModal(response);



            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });

            $('.payHistory').empty();
            className = '';
            studentName = '';
           
        }



       

        let payments =  {!! json_encode($payments->toArray())  !!} ;



       



        let courseId = [];
        let classId = [];
        let requestCourseId =  @php
            if(request('studentByCourse')){
                echo request('studentByCourse');
            }else{
                echo -1;
            }
        @endphp ;


        let courses =  {!! json_encode($courses->toArray())  !!} ;
        courses.forEach(element => {
                 courseId.push(element.id);


                $('.courseId').map(function (el) {
                    $(this).append(`
                        <option  value="${element.id}" ${ element.id == requestCourseId ? 'selected' : '' }>
                            ${element.name}
                        </option>
                    `);
                });

        });


        let classes =  {!! json_encode($classitems->toArray())  !!} ;
        let requestClassId =  @php
            if(request('studentByClass')){
                echo request('studentByClass');
            }else{
                echo -1;
            }
        @endphp ;


        classes.forEach(element => {

               classId.push(element.course_id);
               $('.classId').map(function (el) {
                    $(this).append(`
                        <option value="${element.id}" data-course="${element.course_id}" ${ element.id == requestClassId ? 'selected' : '' } >
                            ${element.name}
                        </option>
                    `);
               });

        });



        $('.courseId').map(function (el) {

            $(this).on('change' , function () {
                let currentCourseId = $(this).val();
                console.log(currentCourseId);
                $("#classId option").hide();
                $(`[data-course=${currentCourseId}]`).show();
            });

        });

        //ajaxloaddata
        var ENDPOINT = "{{ route('payment.index') }}";
    var page = 1;
    // $('.load-more-data2').hide();
    $(".load-more-data").click(function(){
        page++;
        infinteLoadMore(page);
    });

    /*------------------------------------------
    --------------------------------------------
    call infinteLoadMore()
    --------------------------------------------
    --------------------------------------------*/
    function infinteLoadMore(page) {
        $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            })
            .done(function (response) {
                if (response.html == '') {
                    $('.auto-load').html("We don't have more data to display :(");
                    return;
                }
                $('.auto-load').hide();
                // console.log(response.html);
                    $("#data-wrapper").append(response.html);


                if (response.html.includes('Data is Empty')) {
                    $('.load-more-data').hide();
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }

    var ENDPOINT2 = "{{ route('payment.search') }}";
    var pagetwo = 1;
    $(".load-more-data2").click(function(){
        pagetwo++;
        infinteLoadMore2(pagetwo);
    });

    /*------------------------------------------
    --------------------------------------------
    call infinteLoadMore()
    --------------------------------------------
    --------------------------------------------*/
    function infinteLoadMore2(page) {
        var paymentId = $("#paymentId").val();
        var studentId = $("#studentId").val();
        var courseId = $("#courseId").val();
        var classId = $("#classId").val();

        let query = `?search=${paymentId}&paymentByStudent=${studentId}&paymentByCourse=${courseId}&paymentByClass=${classId}`;
        $.ajax({

                url: ENDPOINT2 + query +"&page=" + pagetwo,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            })
            .done(function (response) {
                if (response== '') {
                    $('.auto-load').html("We don't have more data to display :(");
                    return;
                }
                $('.auto-load').hide();
                    $("#data-wrapper2").append(response);


                if (response.includes('Data is empty')) {
                    console.log('hi');
                    $('.load-more-data2').hide();
                }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    };

    $('.ui.dropdown').dropdown();

    $('.ui.search').search();

    

    </script>
@endpush
