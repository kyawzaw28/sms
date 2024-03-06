@extends('layout.template')
@section('custom')
    <style>
        @media screen and (max-width:460px) {
            #main-wrapper {
                position: relative !important;
            }

            .max-height {
                padding-bottom: 75px !important;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-9">
                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item "><a href="#">Student</a></li>
                            <li class="breadcrumb-item active " aria-current="page">Payments by Student</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 ">
                <!-- Button trigger modal -->
                <div class="mx-auto">
                    <div class="input-group">
                        <input class="form-control border-end-0 border" placeholder="search payment" type="search"
                            value="" id="example-search-input ">
                        <span class="input-group-append">
                            <button class="btn btn-outline-secondary bg-white border-start-0 border-bottom-0 border ms-n5"
                                type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
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
                    <div class="d-flex justify-content-between align-items-center mb-2 mb-lg-0">
                        <p class="mb-0 fw-bolder">Total - 10</p>
                        <div class="d-flex justify-content-end  d-xs-block d-md-none ">
                            <button type="button" class="btn plus-btn btn-outline-secondary d-flex " data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                <i class="mdi mdi-filter-outline h5 mb-0"></i>
                            </button>
                        </div>
                    </div>
                    <div class=" table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr style="border-bottom: 2px solid black">
                                    {{-- Mobile View --}}
                                    {{-- <th scope="col" class="d-table-cell d-lg-none">Date</th> --}}
                                    {{-- Mobile View --}}


                                    <th scope="col" class="d-lg-table-cell list-date-col">Date</th>
                                    <th scope="col" class=" list-class-col">Class</th>
                                    <th scope="col" class="d-none d-lg-table-cell list-course-col">Course</th>
                                    <th scope="col" class="d-none d-lg-table-cell list-student-col">Student</th>
                                    <th scope="col" class=" list-fees-col">Fees</th>
                                    <th scope="col" class=" list-due-col">Due</th>
                                    <th scope="col" class=" text-center list-type-col">Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($paymentHistory as $payment)
                                <tr data-bs-toggle="modal" data-bs-target="#exampleModal">

                                    {{-- Mobile View --}}
                                    <td class="d-table-cell d-lg-none text-nowrap align-middle">
                                        {{-- <p>01-01-2023</p> --}}
                                        <p>{{ date('Y-m-d' , strtotime($payment->created_at)) }}</p>
                                        <p>{{$payment->student->name}}</p>
                                    </td>
                                    {{-- Laptop View --}}
                                    <td class="d-none d-lg-table-cell align-middle">{{ date('Y-m-d' , strtotime($payment->created_at)) }}</td>
                                    <td class="align-middle">{{$payment->classitem->name}}</td>
                                    <td class="d-none d-lg-table-cell align-middle">{{$payment->classitem->course->name}}</td>
                                    <td class="d-none d-lg-table-cell align-middle">{{$payment->student->name}}</td>
                                    <td class=" align-middle">{{number_format(floatval($payment->fees))}}</td>
                                    <td class=" align-middle">{{number_format(floatval($payment->due_amount))}}</td>
                                    <td class=" align-middle">

                                        @if ($payment->payment_type=="paid")
                                            <div class="bg-success pay-status d-flex justify-content-center align-items-center rounded">
                                                paid
                                            </div>
                                        @else
                                            <div class="bg-danger pay-status d-flex justify-content-center align-items-center rounded">
                                                unpaid
                                            </div>
                                        @endif

                                    </td>
                                </tr>
                                @empty
                                <td colspan="7" class="text-center">No search data</td>
                                @endforelse
                                {{-- <tr data-bs-toggle="modal" data-bs-target="#exampleModal"> --}}
                                    {{-- Mobile View --}}
                                    {{-- <td class="d-table-cell d-lg-none text-nowrap align-middle">
                                        <p>01-01-2023</p>
                                        <p>Kyaw Kyaw</p>
                                    </td> --}}
                                    {{-- Laptop View --}}
                                    {{-- <td class="d-none d-lg-table-cell align-middle">01-01-2023</td>
                                    <td class="align-middle">Class A</td>
                                    <td class="d-none d-lg-table-cell align-middle">Python</td>
                                    <td class="d-none d-lg-table-cell align-middle">Kyaw Kyaw</td>
                                    <td class=" align-middle">150000</td>
                                    <td class=" align-middle">50000</td>
                                    <td class=" align-middle">
                                        <div
                                            class="bg-danger pay-status d-flex justify-content-center align-items-center rounded">
                                            Unpaid
                                        </div>
                                    </td> --}}
                                {{-- </tr> --}}

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-3 d-none d-md-block" id="exampleModal2">
            <div class="card" style="height: 100%">
                <div class="card-body position-relative filter-card">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="mdi mdi-file-find h3 me-1"></i>
                        <p class="  fs-4 mb-2 text-center">Payment Filter</p>
                    </div>
                    <form action="">
                        <div class=" mb-3">
                            <label for="">Student</label>
                            <select class="select2  form-select shadow-none" style="width: 100%; height:36px;">
                                <option>Select Student</option>
                                {{-- @foreach($studentoption as $students)
                                    <option value="{{$students->id}}" {{ $students->id == $selectedStudent->id ? 'selected' : '' }}>
                                        {{$students->name}}
                                    </option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Course</label>
                            <select class="select2  form-select shadow-none">
                                <option>Select Course</option>
                                {{-- @foreach($courseoption as $courses)
                                    <option value="{{$courses->id}}">{{$courses->name}}</option>
                                @endforeach --}}
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="">Class</label>
                            <select class="select2  form-select shadow-none">
                                <option>Select Class</option>
                                {{-- @foreach($classitems as $classitem)
                                    <option value="{{$classitem->id}}">{{$classitem->name}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="position-absolute filterbtn">
                                <button class="btn btn-secondary cnl-btn me-2" type="submit">Cancel</button>
                                <button class="btn btn-primary sub-btn " type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Payment For Web Foundation (Batch 01)</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Student Name - Kyaw Kyaw</h6>

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr style="border-bottom: 2px solid black">
                                <th scope="col">Transfer Date</th>
                                <th scope="col">Fees</th>
                                <th scope="col">Paid</th>
                                <th scope="col">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="col-3">01-01-2023</td>
                                <td class="col-3">Class A</td>
                                <td class="col-3">Python</td>
                                <td class="col-3">Cash</td>
                            </tr>
                            <tr>
                                <td class="col-3">01-01-2023</td>
                                <td class="col-3">Class A</td>
                                <td class="col-3">Python</td>
                                <td class="col-3">Debit Card</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-6">
                            <div class="mt-3 mb-3">
                                <label for="amount mb-0">
                                    <p class="small-header mb-0">Amount</p>
                                </label>
                                <input type="text" class="form-control w-75" id="amount"
                                    placeholder="Enter Amount">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-3 mb-3">
                                <label for="">Type</label>
                                <div class="input-group w-75">
                                    <select class="form-select" id="inputGroupSelect04"
                                        aria-label="Example select with button addon">
                                        <option selected>Choose Type</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 mb-3 d-flex">
                        <div class="" style="margin-right: 10px;">
                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                id="flexRadioDefault1" checked>
                        </div>
                        <div>
                            <label class="form-check-label mb-0" for="flexRadioDefault1">
                                <p class="small-header mb-0" style="padding-top: 3px;">Print out the slip</p>
                            </label>
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Play</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for right side bar --}}
    {{-- <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Payment Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body  position-relative">
                    <form action="{{route('student.index')}}" method="get">
                        <div class=" mb-3">
                            <label for="">Course</label>
                            <select class="select2  form-select shadow-none" style="width: 100%; height:36px;" name="studentByCourse">
                                <option value = "">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}" {{ $course->id == request('studentByCourse') ? 'selected' : '' }}>
                                        {{$course->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Class</label>
                            <select required class="select2  form-select shadow-none" style="width: 100%; height:36px;" name="studentByClass">
                                <option value = "">Select Class</option>
                                @foreach($classitems as $class)
                                    <option value="{{$class->id}}" {{ $class->id == request('studentByClass') ? 'selected' : '' }} >
                                        {{$class->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-center align-items-center ">
                            <div class="">
                                <a href="{{route('student.index')}}" class="btn btn-secondary cnl-btn me-2" type="submit">Cancel</a>
                                <button class="btn btn-primary sub-btn " type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div> --}}
@endpush
