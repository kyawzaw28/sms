@extends('layout.template')

@section('custom')
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
@endsection

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex ">

                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item "><a href="{{ route('student.index') }}">Students</a></li>
                            <li class="breadcrumb-item active " aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row  px-3 max-height">
        <div class="col-md-12 table-container">
            <div class="card rounded-3 ">
                <div class="card-body">
                    <form target="_blank" action="{{ route('student.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group  margin-right">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name">
                                    @error('name')
                                        <div class=" invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group margin-right">
                                    <label for="name">Address</label>
                                    <textarea name="address" class="form-control form-text @error('address') is-invalid @enderror" id="address" cols="30" rows="5"
                                        placeholder="Address">{{old('address')}}</textarea>
                                        @error('address')
                                            <div class=" invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    {{-- <input type="text" class="form-control" id="name" placeholder="Address"> --}}
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group margin-right">
                                    <label for="startdate">Email</label>
                                    <input type="email" name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" id="enddate" placeholder="Email">
                                    @error('email')
                                            <div class=" invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group margin-right">
                                    <label for="name">Phone</label>
                                    <input type="number" name="phone" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror" id="name" placeholder="Phone number">
                                    @error('phone')
                                            <div class=" invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <p class=" h4 my-2">Enrollment (Optional)</p>

                        <div class="row pt-2">
                            <div class="col-md-6">
                                <div class="form-group margin-right">
                                    <label for="course">Course Name</label>
                                    <select name="course_id" class="form-select slectopt" id="course">
                                        <option value="-1" selected>Select course </option>
                                        @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{$course->name}}</option>
                                        @endforeach
                                        <option value="2">Japanese N5</option>
                                    </select>
                                </div>
                                <div class="form-group margin-right">
                                    <label for="amount">Amount</label>
                                    <input type="number" name="due_amount" class="form-control" id="amount" placeholder="Amount">
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group margin-right">
                                    <label for="class">Class</label>
                                    <select name="classitem_id" class="form-select slectopt" id="class">
                                        <option value="-1" selected>Select class</option>
                                        @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{$class->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group margin-right">
                                    <label for="class">Payment Method</label>
                                    <select name="payment_method" class="form-select slectopt" id="class">
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="bank transfer">Bank Transfer</option>
                                    </select>
                                </div>
                                <div class="form-group margin-right mt-5">
                                    <input name="slip" class=" form-check-input" type="checkbox" name="flexRadioDefault"
                                        id="flexRadioDefault1">
                                    <label class="form-check-label mb-0" for="flexRadioDefault1">
                                        <p class="small-header mb-0">Print out the slip</p>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="create-edit-btn-bottom">
                        <div class=" text-center form-create-btn">
                            <a href="{{ route('student.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
