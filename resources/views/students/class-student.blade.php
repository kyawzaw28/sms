@extends('layout.template')

@section('custom')
<style>
    @media screen and (max-width:460px){
    #main-wrapper{
        position: fixed !important;
    }

    .max-height{
        padding-bottom: 70px !important;
    }
}
</style>
@endsection

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-sm-9 col-xs-12 d-flex ">
                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item asdf"><a href="{{route('student.index')}}">Students</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Class related by <span class="fw-bold">{{ $selectedStudent->name }}</span></li>
                        </ol>
                    </nav>
                </div>
            </div>
            {{-- <div class="col-md-3">
                <div class="mx-auto">
                    <div class="input-group">
                        <input class="form-control border-end-0 border" placeholder="search class" type="search"
                            value="" id="example-search-input">
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


    <div class="row  px-3 max-height  d-sm-flex">
        <div class="col-12  class-table">
            <div class="card rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2 mb-lg-0">
                        <div class="d-flex gap-2 justify-content-center align-items-center">
                            <a href="{{ URL::route('student.index') }}" class="text-black">
                                <i class="mdi mdi-chevron-left h4"></i>
                            </a>
                            <p class="mb-0 fw-bolder">Total - {{ count($classitems) }}</p>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="{{ route('classitem.create') }}" class="btn d-flex me-2 justify-content-center align-items-center plus-btn btn-outline-secondary ">
                                <i class="mdi mdi-plus h5 mb-0"></i>
                            </a>
                            <div class="d-flex justify-content-end  d-xs-block d-md-none ">
                                <button type="button" class="btn plus-btn btn-outline-secondary d-flex " data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    <i class="mdi mdi-filter-outline h5 mb-0"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @if(session()->has('message'))
                    <div class="alert alert-success success-alt mt-2">
                      {{session()->get('message')}}
                      <button type="button" class="close success-msg" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                    </div>
                    @endif
                    @if(session()->has('del'))
                    <div class="alert alert-success success-alt mt-2">
                      {{session()->get('del')}}
                      <button type="button" class="close success-msg" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                    </div>
                    @endif
                    <table class="table table-striped">
                        <thead>
                            <tr style="border-bottom: 2px solid black">
                                <th scope="col" class="list-lecturer-col" >
                                    <p class="d-none d-md-block">Name</p>
                                    <p class="d-block d-md-none">Class & Lecturer</p>
                                </th>
                                <th scope="col" class="list-course-col">Course</th>
                                <th class="d-none d-md-table-cell list-lecturer-col" scope="col">Lecturer</th>
                                <th scope="col" class="list-status-col">Status</th>
                                <th scope="col" class="text-end list-control-col" class="">
                                    <p class=" d-none d-md-block">Control</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classitems as $classdata)
                            <tr>
                                <td class="align-middle">
                                    <p class="d-none d-md-block text-cut">{{Str::limit($classdata->name,30)}}</p>
                                    <div class="d-block d-md-none">
                                        <p>{{$classdata->name}} </p>
                                        <p class=" text-black-50 text-cut">{{Str::limit($classdata->users->pluck('name')->implode(', '),20)}} </p>
                                    </div>
                                </td>
                                <td class="align-middle">{{Str::limit($classdata->course->name,20)}}</td>
                                <td class="d-none d-md-table-cell align-middle" >{{Str::limit($classdata->users->pluck('name')->implode(', '),20)}} </td>
                                @php $isUnpaid = false; @endphp
                                @foreach($classdata->payments as $payment)
                                @if($payment->payment_type === 'unpaid')
                                @php $isUnpaid = true; @endphp @break
                                @endif
                                @endforeach
                                @if($isUnpaid)
                                <td class=" align-middle">
                                    <div
                                        class="text-danger fw-bold pay-status  ">
                                        unpaid
                                    </div>
                                </td>
                                @else
                                <td class="">
                                    <div class="text-success fw-bold pay-status  ">
                                        paid
                                    </div>
                                </td>
                                @endif
                                {{-- <td class="d-none d-md-table-cell align-middle text-center">
                                    <form action="{{ route( 'payment.allhistory' ) }}" method="POST">
                                        <button " class="btn table-btn-sm btn-primary">
                                            @csrf
                                            @method('post')
                                            <i class="mdi mdi-credit-card-multiple h5"></i>
                                            <input type="text" name="student_id" value="{{ $selectedStudent->id }}" hidden>
                                            <input type="text" name="classitem_id" value="{{ $classdata->id }}" hidden>

                                        </button>
                                    </form>
                                </td> --}}
                                <td class="text-end align-middle text-nowrap">
                                    <div class="d-none d-md-block control-btns">
                                        {{-- <a href="{{ route('classitem.edit', $classdata) }}" class="btn table-btn-sm btn-primary">
                                            <i class="mdi mdi-pencil h5"></i>
                                        </a> --}}

                                        <a href="{{ route('classitem.show',  [ $classdata->id , 'ss' => $selectedStudent->id] ) }}"
                                            class="btn table-btn-sm btn-primary">
                                            <i class="mdi mdi-information-outline h5"></i>

                                        </a>
                                        {{-- <a href="" class="btn table-btn-sm btn-danger">
                                            <i class="mdi mdi-delete h5 text-white"></i>
                                        </a> --}}
                                        <form action="{{route('classitem.destroy', $classdata->id)}}" method="post" class="d-inline">
                                        @csrf
                                        <input name="_method" type="hidden" value="delete">
                                        <button type="submit" class="btn table-btn-sm btn-danger del-btn alertbox">
                                            <i class="mdi mdi-delete h5 text-white"></i>
                                        </button>
                                        </form>


                                    </div>

                                    <div class="btn-group dropup d-block d-md-none control-btn">
                                        <button type="button" class="btn table-btn-sm btn-outline-dark border border-0 dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical h4"></i>
                                        </button>

                                        <ul class="dropdown-menu mb-1">
                                            <div class="d-flex justify-content-around">
                                                {{-- <li>
                                                    <a href="{{ route('classitem.edit', 1) }}" class="btn table-btn-sm btn-outline-primary border border-0">
                                                        <i class="mdi mdi-pencil h5"></i>
                                                    </a>
                                                </li> --}}
                                                <li>
                                                    <a href="" class="btn table-btn-sm btn-outline-danger border border-0">
                                                        <i class="mdi mdi-delete h5 "></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('classitem.show', 'detail') }}" class="btn table-btn-sm btn-outline-secondary border border-0">
                                                        <i class="mdi mdi-information-outline h4"></i>
                                                    </a>
                                                </li>
                                            </div>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <td colspan="6" class="text-center">No search data</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end me-3">
                {{-- {{$classitem->links()}} --}}
            </div>
            </div>

        </div>
        {{-- <div class="col-3 d-none d-md-block class-filter-container">
            <div class="card">
                <div class="card-body position-relative filter-card">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="mdi mdi-file-find h3 me-1"></i>
                        <p class="  fs-4 mb-2 text-center">Class Filter</p>
                    </div>
                    <form action="">
                        <div class=" mb-3">
                            <label for="">Course</label>
                            <select class="select2  form-select shadow-none" style="width: 100%; height:36px;">
                                <option value = "">Select Course</option>
                                @foreach($courseoption as $courses)
                                    <option value="{{$courses->id}}">{{$courses->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Student</label>
                            <select class="select2  form-select shadow-none">
                                <option>Select Class</option>
                                @foreach($studentoption as $students)
                                    <option value="{{$students->id}}" {{ $students->id == $selectedStudent->id ? 'selected' : '' }}>
                                        {{$students->name}}
                                    </option>
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
    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Class Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body  position-relative">
                    <form action="{{route('student.index')}}" method="get">

                        <div class=" mb-3">
                            <label for="">Course</label>
                            <select class="select2  form-select shadow-none" style="width: 100%; height:36px;">
                                <option value = "">Select Course</option>
                                @foreach($courseoption as $courses)
                                    <option value="{{$courses->id}}">{{$courses->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Student</label>
                            <select class="select2  form-select shadow-none">
                                <option>Select Class</option>
                                @foreach($studentoption as $students)
                                    <option value="{{$students->id}}" {{ $students->id == $selectedStudent->id ? 'selected' : '' }}>
                                        {{$students->name}}
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
    </div>
@endpush
