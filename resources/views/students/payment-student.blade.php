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
                            <li class="breadcrumb-item active" aria-current="page">Payments by <span
                                    class="fw-bold">{{ $selectedStudent->name }}</span></li>
                        </ol>
                    </nav>
                </div>
            </div>

            {{-- <div class="col-lg-3 col-md-3 col-sm-12 ">
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
            </div> --}}
        </div>
    </div>

    <div class="row  px-3 max-height">

        {{-- <div class="col-9 col-sm-12"> --}}
        <div class=" col-sm-12  table-container">
            <div class="card rounded-3 ">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2 mb-lg-0">
                        <div class="d-flex gap-2 justify-content-center align-items-center">
                            <a href="{{ url()->previous() }}" class="text-black">
                                <i class="mdi mdi-chevron-left h4"></i>
                            </a>
                            <p class="mb-0 fw-bolder">Total - {{ count($payments) }}</p>
                        </div>
                        {{-- <p class="mb-0 fw-bolder">Total - 10</p> --}}
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
                                    <th scope="col" class=" list-fees-col">Fees</th>
                                    <th scope="col" class=" list-due-col">Due</th>
                                    <th scope="col" class=" text-center list-type-col">Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                    <tr onclick="showPayments({{ $payment->classitem_id }}, {{ $payment->student_id }})"
                                        class="history" data-className="{{ $payment->classitem->name }}"
                                        data-studentName="{{ $payment->student->name }}" data-bs-toggle="modal"
                                        data-bs-target="#exampleModelOne">

                                        {{-- Mobile View --}}
                                        <td class="d-table-cell d-lg-none text-nowrap align-middle">
                                            {{-- <p>01-01-2023</p> --}}
                                            <p>{{ date('Y-m-d', strtotime($payment->created_at)) }}</p>
                                            <p>{{ $payment->student->name }}</p>
                                        </td>
                                        <td class="fees d-none">
                                            {{ $payment->fees }}
                                        </td>
                                        <td class="paid d-none">
                                            {{ $payment->due_amount }}
                                        </td>
                                        {{-- Laptop View --}}
                                        <td class="d-none d-lg-table-cell align-middle">
                                            {{ date('Y-m-d', strtotime($payment->created_at)) }}</td>
                                        <td class="align-middle">{{ $payment->classitem->name }}</td>
                                        <td class="d-none d-lg-table-cell align-middle">
                                            {{ $payment->classitem->course->name }}
                                        </td>
                                        <td class=" align-middle">{{ number_format(floatval($payment->fees)) }}</td>
                                        <td class=" align-middle">{{ number_format(floatval($payment->due_amount)) }}</td>
                                        <td class=" align-middle">

                                            @if ($payment->payment_type == 'paid')
                                                <div
                                                    class="text-success fw-bold pay-status d-flex justify-content-center align-items-center rounded">
                                                    paid
                                                </div>
                                            @else
                                                <div
                                                    class="text-danger fw-bold pay-status d-flex justify-content-center align-items-center rounded">
                                                    unpaid
                                                </div>
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="7" class="text-center">No search data</td>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{-- <div class="col-3 d-none d-md-block" id="exampleModal2">
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
                                @foreach ($studentoption as $students)
                                    <option value="{{$students->id}}"
    {{ $students->id == $selectedStudent->id ? 'selected' : '' }}>
    {{$students->name}}
    </option>
    @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="">Course</label>
    <select class="select2  form-select shadow-none">
        <option>Select Course</option>
        @foreach ($courseoption as $courses)
        <option value="{{$courses->id}}">{{$courses->name}}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="">Class</label>
    <select class="select2  form-select shadow-none">
        <option>Select Class</option>
        @foreach ($classitems as $classitem)
        <option value="{{$classitem->id}}">{{$classitem->name}}</option>
        @endforeach
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
</div> --}}
    </div>
@endsection

@push('scripts')
    <!-- Modal -->
    <div class="modal fade hide" id="exampleModelOne" tabindex="-1" aria-labelledby="exampleModelOneLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModelOneLabel">Modal title</h5>
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
                    <form action="">
                        <div class=" mb-3">
                            <label for="">Student</label>
                            <select class="select2  form-select shadow-none" style="width: 100%; height:36px;">
                                <option>Select Student</option>
                                @foreach ($studentoption as $students)
                                    <option value="{{$students->id}}"
{{ $students->id == $selectedStudent->id ? 'selected' : '' }}>
{{$students->name}}
</option>
@endforeach
</select>
</div>
<div class="mb-3">
    <label for="">Course</label>
    <select class="select2  form-select shadow-none">
        <option>Select Course</option>
        @foreach ($courseoption as $courses)
        <option value="{{$courses->id}}">{{$courses->name}}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="">Class</label>
    <select class="select2  form-select shadow-none">
        <option>Select Class</option>
        @foreach ($classitems as $classitem)
        <option value="{{$classitem->id}}">{{$classitem->name}}</option>
        @endforeach
    </select>
</div>
<div class="d-flex justify-content-center">
    <div class="">
        <button class="btn btn-secondary cnl-btn me-2" type="submit">Cancel</button>
        <button class="btn btn-primary sub-btn " type="submit">Submit</button>
    </div>
</div>
</form>
</div>
</div>
</div> --}}

    <script>
        let className;
        let studentName;
        let fees;
        let paid;
        $('.history').map(function() {
            $(this).on('click', function() {
                className = $(this).attr('data-className');
                studentName = $(this).attr('data-studentName');
                fees = Number($(this).children('.fees').text());
                paid = Number($(this).children('.paid').text());
                console.log(fees, paid);
            });
        });
        // Function to show the Bootstrap modal
        function showModal(response) {
            $('#exampleModelOneLabel').text(className);
            $('.studentName').text(studentName);
            response.map(function(el) {
                let text = el.created_at;
                $('.payHistory').map(function() {
                    $(this).append(`
                        <div class="payment-list-body">
                            <p class="payment-lists">${ text.slice(0, 10) }</p>
                            <p class="payment-lists">${el.fees}</p>
                            <p class="payment-lists">${el.due_amount}</p>
                            <p class="payment-lists">${el.payment_method}</p>
                        </div>
                    `);
                })
            });
            $('#exampleModelOne').modal('show');
        };
        var ENDPOINT = "{{ route('classitem.index') }}";

        function showPayments(classitemId, studentId) {
            $('#studentId').val(studentId);
            $('#classId').val(classitemId);
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
            $('.payHistory').empty();
            className = '';
            studentName = '';
            // console.log(allHistory);
        }

        function validate() {
            let amount = Number(document.myForm.due_amount.value);
            paid = Number(paid);
            fees = Number(fees);
            if (amount > fees || amount > paid) {
                // console.log(amount , paid);                             
                $('.amount-error').text('This amount is exceeded');
                return false;
            }
        };
    </script>
@endpush
