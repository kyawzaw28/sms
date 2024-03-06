@extends('layout.template')

@section('custom')
    <style>
        @media screen and (max-width:460px) {
            #main-wrapper {
                height: 100vmax;
                overflow: visible;
            }

            .max-height {
                padding-bottom: 100px !important;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
@endsection
@section('ajaxcsrf')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class=" col-12 col-md-9 d-flex ">
                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item "><a href="{{ route('student.index') }}">Students</a></li>
                            <li class="breadcrumb-item active " aria-current="page">List</li>
                            {{-- @if (request('studentByClass'))
                                <li class="breadcrumb-item active " aria-current="page">Search by <span
                                        class=" text-primary">{{ $searchByClass }}</span></li>
                            @endif --}}
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="mx-auto">
                    <form action="{{ route('student.index') }}">
                        <div class="ui search">
                            <div class="ui icon input w-100">
                                <input class="form-control border-end-0 border" placeholder="search student" type="search"
                                    name="keyword" value="{{ request('keyword') }}" id="keyword">
                                @if (request('studentByCourse') || request('studentByClass'))
                                    <input hidden name="studentByCourse" value="{{ request('studentByCourse') }}">
                                    <input hidden name="studentByClass" value="{{ request('studentByClass') }}">
                                @endif
                                <i class="search icon"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row  px-3 max-height ">
        <div class="col-12 col-md-9 table-container">
            <div class="card rounded-3 ">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2 mb-lg-0 py-2">
                        <p class="mb-0 fw-bolder">Total - {{ $students->total() }}</p>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <a href="{{ route('student.create') }}"
                                class="btn d-flex justify-content-center align-items-center plus-btn btn-outline-secondary ">
                                <i class="mdi mdi-plus h5 mb-0"></i>
                            </a>
                            <div class="d-flex justify-content-end  d-xs-block d-md-none ">
                                <button type="button" class="btn plus-btn btn-outline-secondary d-flex "
                                    data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    <i class="mdi mdi-filter-outline h5 mb-0"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="student-table table-responsive">
                        <table class="table table-striped table-hover  student-list ">
                            <thead>
                                <tr class=" table-header" style="border-bottom: 2px solid black">
                                    <th class="w-15" scope="col">Name</th>
                                    <th class=" w-25" scope="col">Contact</th>
                                    <th class=" w-30 d-none d-lg-table-cell" scope="col">Address</th>
                                    <th scope="col" class="text-center">Payment</th>
                                    <th scope="col" class="text-center">Class</th>
                                    <th scope="col" class="text-end">
                                        <p class=" d-none d-md-block">Control</p>
                                    </th>
                                </tr>
                            </thead>
                            
                            <tbody class="tbody-container original" id="data-wrapper">
                                @include('students.data')
                            </tbody>
                            <tbody class="find" id="data-wrapper2">
                            </tbody>
                            @if (count($students) >= 15)
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <button class="btn btn-secondary load-more-data"><i class="fa fa-refresh"></i> Load
                                            More Data...</button>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="6" class="text-center">
                                    <button class="btn btn-secondary load-more-data2" style="display: none;"><i
                                            class="fa fa-refresh"></i> Load More Data...</button>
                                </td>
                            </tr>
                        </table>
                        <!-- Data Loader -->
                        <div class="auto-load text-center" style="display: none;">
                            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60"
                                viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                                <path fill="#000"
                                    d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                    <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                        dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                                </path>
                            </svg>
                        </div>
                        <div class=" paginate ">
                            {{-- {{$students->links('pagination::bootstrap-4')}} --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-3 d-none d-md-block">
            <div class="card ">
                <div class="card-body position-relative filter-card">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="mdi mdi-filter-outline h3 me-1"></i>
                        <p class="  fs-4 mb-2 text-center">Student Filter</p>
                    </div>

                    <form action="{{ route('student.index') }}" method="get">
                        @if (request('keyword'))
                            <input hidden name="keyword" value="{{ request('keyword') }}">
                        @endif
                        <div class=" mb-3">
                            <label for="">Course</label>
                            <select id="courseId" class=" ui dropdown w-100 shadow-none courseId"
                                style="width: 100%; height:36px;" name="studentByCourse">
                                <option value="-1">Select Course</option>

                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="">Class</label>
                            <select id="classId" class="ui dropdown w-100 shadow-none classId"
                                style="width: 100%; height:36px;" name="studentByClass">
                                <option value="-1">Select Class</option>

                            </select>
                        </div>

                        {{-- <div class="d-flex justify-content-center align-items-center ">
                            <div class="filterbtn">
                                <a href="{{route('student.index')}}" class="btn btn-secondary cnl-btn me-2" type="submit">Cancel</a>
                                <button class="btn btn-primary sub-btn " type="submit">Submit</button>
                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Student Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body  position-relative">

                    <form action="{{ route('student.index') }}" method="get">
                        @if (request('keyword'))
                            <input hidden name="keyword" value="{{ request('keyword') }}">
                        @endif
                        <div class=" mb-3">
                            <label for="">Course</label>
                            <select id="courseId" class="ui dropdown w-100 shadow-none courseId"
                                style="width: 100%; height:36px;" name="studentByCourse">
                                <option value="-1">Select Course</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Class</label>
                            <select id="classId" required class="ui dropdown w-100 shadow-none classId"
                                style="width: 100%; height:36px;" name="studentByClass">
                                <option value="-1">Select Class</option>

                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- paymentmodal --}}
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 700px;">
            <div class="modal-content rounded-6">
                <div class="modal-header">
                    <h5 class="modal-titlefirst" >Payments</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- amyStudentTitle --}}
                    <div class=" mb-2">
                        <span class="">Student name - </span>
                        <p class="StudentNameFirst fw-bold d-inline-block"></p>
                    </div>
                    <div class="payment-list-containerfirst">
                        <table class="table addline">
                            <thead>
                                <tr>
                                    <th scope="col" class="headingtext">Date</th>
                                    <th scope="col" class="headingtext">Class</th>
                                    <th scope="col" class="headingtext">Course</th>
                                    <th scope="col" class="headingtext">Fees</th>
                                    <th scope="col" class="headingtext">Due</th>
                                    <th scope="col" class="headingtext">Type</th>
                                </tr>
                            </thead>

                            <tbody class="payHistory EmptyData">
                            </tbody>

                        </table>
                    </div>
                </div>
                {{-- <div class="text-center p-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div> --}}
            </div>
        </div>
    </div>


    {{-- amypaymentmodel --}}
    <div class="modal fade hide" id="exampleModalRelate" tabindex="-1" aria-labelledby="exampleModalLabelrelate"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-6">
                <div class="modal-header">
                    <h5 class="modal-title className mb-0" id="exampleModalLabelrelate">Payments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payments.createModal') }}" onsubmit="return(validate());" method="POST"
                    name="myForm">
                    <div class="modal-body">
                        <div class=" mb-2">
                            <span class="">Student name - </span>
                            <p class="studentName fw-bold d-inline-block"></p>
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
                                    <div id="paymentList" class="allPayHistory">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    @csrf
                    <input type="text" class="d-none" name="student_id" hidden id="curStudentIdChg" value="">
                    <input type="text" class="d-none" name="classitem_id" hidden id="curClassIdChg" value="">
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
                                    <select name="payment_method" class="form-select slectopt" id="class">
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
                    <div class="text-center p-3 backbtn">

                    </div>

            </div>
            </form>

        </div>
    </div>
    </div>



    </div>

    {{-- Classitemmodal --}}
    <div class="modal fade " id="classitemModal" tabindex="-1" role="dialog" aria-labelledby="classitemModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content rounded-6">
                <div class="modal-header">
                    <h5 class="modal-titlefirst mb-0 ">Enrolled Classes</h5>
                    <br>
                   
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </button>
                </div>
                <div class="modal-body">
                    <p class=" d-block">Student name - <Span class="classStudentName"></Span></p>

                    <div class="payment-list-containerfirst">
                        <table class="table addline">
                            <thead>
                                <tr style="border-bottom: 2px solid black">
                                    <th scope="col" class="">Class Name</th>
                                    <th scope="col" class="">Course name</th>
                                    <th class="d-none d-md-table-cell  w-30" scope="col">Lecturers</th>
                                    <th scope="col" class="">Fees</th>
                                </tr>
                            </thead>

                            <tbody class="relatedClass">
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- amypaymentmodel --}}
    {{-- <div class="modal fade hide" id="exampleModalRelate" tabindex="-1" aria-labelledby="exampleModalLabelrelate"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-6">
                <div class="modal-header">
                    <h5 class="modal-title className" id="exampleModalLabelrelate">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payments.createModal') }}" onsubmit="return(validate());" method="POST"
                    name="myForm">
                    <div class="modal-body">
                        <div class=" mb-2">
                            <span class="">Student name - </span>
                            <p class="studentName fw-bold d-inline-block"></p>
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
                                    <div id="paymentList" class="payHistory">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    @csrf
                    <input type="text" class="d-none" name="student_id" hidden id="curStudentIdChg" value="">
                    <input type="text" class="d-none" name="classitem_id" hidden id="curClassIdChg" value="">
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
                                    <select name="payment_method" class="form-select slectopt" id="class">
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
    </div> --}}



    </div>

    <script>
        let test = $('#test');
        @if (session('message'))
            new Noty({
                type: 'success',
                layout: 'bottomLeft',
                theme: 'nest',
                text: 'Student create successfully',
                timeout: '4000',
                progressBar: true,
                closeWith: ['click'],
                killer: true,

            }).show();
        @endif

        @if (session('del'))
            new Noty({
                type: 'success',
                layout: 'bottomLeft',
                theme: 'nest',
                text: 'Classitem delete successfully',
                timeout: '2000',
                progressBar: true,
                closeWith: ['click'],
                killer: true,

            }).show();
        @endif

        let courseId = [];
        let classId = [];
        let requestCourseId = @php
            if (request('studentByCourse')) {
                echo request('studentByCourse');
            } else {
                echo -1;
            }
        @endphp;


        let courses = {!! json_encode($courses->toArray()) !!};
        courses.forEach(element => {
            courseId.push(element.id);


            $('.courseId').append(`<option value="" >Select Class</option>`);
            $('.courseId').map(function(el) {
                $(this).append(`
                        <option  value="${element.id}" ${ element.id == requestCourseId ? 'selected' : '' }>
                            ${element.name}
                        </option>
                    `);
            });

        });


        let classes = {!! json_encode($classitems->toArray()) !!};
        let requestClassId = @php
            if (request('studentByClass')) {
                echo request('studentByClass');
            } else {
                echo -1;
            }
        @endphp;


        classes.forEach(element => {

            classId.push(element.course_id);
            $('.classId').map(function(el) {
                $(this).append(`
                        <option value="${element.id}" data-course="${element.course_id}" ${ element.id == requestClassId ? 'selected' : '' } >
                            ${element.name}
                        </option>
                    `);
            });

        });



        $('.courseId').map(function(el) {

            $(this).on('change', function() {
                let currentCourseId = $(this).val();
                console.log(currentCourseId);
                $("#classId option").hide();
                $(`[data-course=${currentCourseId}]`).show();
            });

        });


        //student load data
        var ENDPOINT = "{{ route('student.index') }}";
        var page = 1;
        // $('.load-more-data2').hide();
        $(".load-more-data").click(function() {
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
                    beforeSend: function() {
                        $('.auto-load').show();
                    }
                })
                .done(function(response) {
                    if (response.html == '') {
                        $('.auto-load').html("We don't have more data to display :(");
                        return;
                    }
                    $('.auto-load').hide();
                    $("#data-wrapper").append(response.html);


                    if (response.html.includes('Data is Empty')) {
                        $('.load-more-data').hide();
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }

        var ENDPOINT2 = "{{ route('student.search') }}";
        var pagetwo = 1;
        $(".load-more-data2").click(function() {
            pagetwo++;
            infinteLoadMore2(pagetwo);
        });

        /*------------------------------------------
        --------------------------------------------
        call infinteLoadMore()
        --------------------------------------------
        --------------------------------------------*/
        function infinteLoadMore2(page) {
            var keyword = $("#keyword").val();
            var courseId = $("#courseId").val();
            var classId = $("#classId").val();

            let query = `?studentsearch=${keyword}&studentByCourse=${courseId}&studentByClass=${classId}`;
            $.ajax({

                    url: ENDPOINT2 + query + "&page=" + pagetwo,
                    datatype: "html",
                    type: "get",
                    beforeSend: function() {
                        $('.auto-load').show();
                    }
                })
                .done(function(response) {
                    if (response == '') {
                        $('.auto-load').html("We don't have more data to display :(");
                        return;
                    }
                    $('.auto-load').hide();
                    $("#data-wrapper2").append(response);


                    if (response.includes('Data is Empty')) {
                        $('.load-more-data2').hide();
                    }
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }


        $('.ui.dropdown').dropdown();


        let student;
        //showpaymentdata
        function showpaydata(event , studentId){
            student = event.currentTarget.getAttribute('data-student');
            $('.StudentNameFirst').text(student);
           
            let showpaydataURL = event.currentTarget.getAttribute('data-url-payment');           
            $.get(showpaydataURL, function(data) {
                $('#exampleModalCenter').modal('show');
                data.map(function(el) {
                    $('.payHistory').map(function() {
                        console.log(el);
                        $(this).append(`
                          <tr onclick="showPayments(event, ${el.classitem_id}, ${el.student_id})" class="history" data-className="${el.classitem_name}" data-studentName="${el.student_name}" data-bs-toggle="modal" data-bs-target="#exampleModalRelate" data-bs-dismiss="modal">
                            <td>${el.created_at.slice(0,10)}</td>
                            <td class="d-none fees">${el.fees}</td>
                            <td class="d-none paid">${el.due_amount}</td>
                            <td>${el.classitem_name}</td>
                            <td>${el.course_name}</td>
                            <td>${Number(el.fees).toLocaleString('en-Us')}</td>
                            <td>${Number(el.due_amount).toLocaleString('en-Us')}</td>
                            <td class="${el.payment_type=="unpaid" ? 'text-danger' : 'text-success'} fw-bold">${el.payment_type}</td>                         
                            
                          </tr>

                    `);


                    })
                    // $('.modal-titlefirst').text(el.classitem_name);
                  

                })
                if (document.querySelector('.addline').rows.length == 1) {
                    $('.payHistory').append(`
                <tr>
                    <td colspan="6" class="text-center text-danger fontsetting">Not Paid yet</td>
                </tr>
            `);
                }
            })

            $('.payHistory').empty();
            $('.backbtn').empty();
        }

        //amy payment model box
        let className;
        let studentName;
        let fees;
        let paid;

        function showModal(response) {
            response.map(function(elrelated) {
                let text = elrelated.created_at;
                $('.allPayHistory').map(function() {
                    $(this).append(`
                        <div class="payment-list-body">
                            <p class="payment-lists">${ text.slice(0, 10) }</p>
                            <p class="payment-lists ">${Number(elrelated.fees).toLocaleString('en-Us')}</p>
                            <p class="payment-lists ">${Number(elrelated.due_amount).toLocaleString('en-Us')}</p>
                            <p class="payment-lists">${elrelated.payment_method}</p>
                        </div>

                    `);
                })
            });
            $('#exampleModalRelate').modal('show');
        };


        function showPayments(event, classitemId, studentId) {

          

            className = event.currentTarget.getAttribute('data-className');
            studentName = event.currentTarget.getAttribute('data-studentName');
            fees = $(event.currentTarget).find('.fees').text().trim();
            paid = $(event.currentTarget).find('.paid').text().trim();

            $('#curStudentIdChg').val(studentId);
            $('#curClassIdChg').val(classitemId);

            $('.backbtn').append(`
<a href="#" class="btn btn-secondary showpaydata" data-bs-target="#exampleModalCenter"  data-student="${studentName}"  onclick="showpaydata(event , ${studentId})"  data-bs-toggle="modal" data-url-payment="{{ URL::to('student/${studentId}') }}" data-bs-dismiss="modal">Cancel</a>
<button type="submit" class="btn btn-primary">Submit</button>
`);


            

            $('#exampleModalLabelrelate').text(className);
            $('.studentName').text(studentName);
            console.log(fees,paid);



            console.log(classitemId, studentId);
            $.ajax({
                    url: "{{ route('payments.get') }}?classitemId=" + classitemId + "&studentId=" + studentId,
                    type: "get",
                })
                .done(function(response) {
                    showModal(response);



                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });

            $('.allPayHistory').empty();
            // className = '';
            // studentName = '';


            // console.log(allHistory);
        }


        function validate() {

            let amount = Number(document.myForm.due_amount.value);
            paid = Number(paid);
            fees = Number(fees);
            console.log(amount , paid); 
            if (amount > fees || amount > paid) {
                                            
                $('.amount-error').text('This amount is exceeded');
                return false;
            };

            if (amount == '') {
                $('.amount-error').text('Amount is required');
                return false;
            };

        };
    </script>

@endpush
