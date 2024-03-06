
@extends('layout.template')

@section('custom')
    <style>
        @media screen and (max-width:460px) {
            #main-wrapper {
                position: fixed !important;
            }

            .max-height {
                padding-bottom: 75px !important;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/course.css') }}">
@endsection



@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-sm-9 col-xs-12 d-flex ">
                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item asdf"><a href="#">Course</a></li>
                            <li class="breadcrumb-item active " aria-current="page">List</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <form class="col-md-3" method="get" action="{{route('course.index')}}">
                <div class="mx-auto">
                    <div class="input-group">
                        <input class="form-control border-end-0 border" placeholder="search user" type="search"
                            value="{{request('search')}}" id="example-search-input" name="search">
                        <span class="input-group-append">
                            <button class="btn btn-outline-secondary bg-white border-start-0 border-bottom-0 border ms-n5"
                                type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row  px-3 max-height">
        <div class="col-md-12">
            <div class="card rounded-3 position-relative">
                <div class="card-body ">
                    <div class="course-width">
                        <div class="course-row" id="courseRow">


                            @foreach ($courses as $course)
                                <div class="row-item mb-3 grid-container">
                                    {{-- <div class="course-btn me-2 d-inline-block text-center edit">

                                </div> --}}
                                    <a href="{{ route('course.edit' , $course->id) }}" class=" btn table-btn-sm btn-outline-primary border-0">
                                        <i class=" mdi  mdi-pencil-box-outline h3"></i>
                                    </a>
                                    <input type="text" class=" form-control d-inline-block course-name"
                                        value="{{ $course->name }}" disabled>
                                    {{-- <div class="course-btn ms-2 d-inline-block text-center del">

                                </div> --}}
                                <form action="{{route('course.destroy' , $course->id)}} " method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"  class=" btn table-btn-sm btn-outline-primary border-0">
                                        <i class=" mdi mdi-delete h3"></i>
                                    </button>
                                </form>
                                </div>
                            @endforeach

                            <form action="{{ route('course.store') }}" method="POST">
                                @csrf
                                <div class="row-item mb-3 grid-container">

                                    <button type="submit" class=" btn course-btn  btn-primary px-1 me-2">
                                        Add
                                    </button>

                                    <input type="text" name="name" class=" form-control d-inline-block"
                                        placeholder="Add new course">
                                    <button class=" btn course-btn btn-secondary px-1 ms-2 course-del">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class=" bg-light p-fixed">
                            <button id="addCourse"
                                class="btn btn-primary w-100  add-course d-flex justify-content-center align-items-center gap-2">
                                <i class="mdi mdi-plus-circle h3 mb-0"></i>
                                <p class="">Create new course</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    
@endsection
@push('scripts')
<script>
    $("#addCourse").click(function () {
    $("#courseRow").append(`
    <form action="{{ route('course.store') }}" method="POST">
        @csrf
        <div class="row-item mb-3 grid-container">

            <button type="submit" class=" btn course-btn  btn-primary px-1 me-2">
                Add
            </button>

            <input type="text" name="name" class=" form-control d-inline-block"
                placeholder="Add new course">
            <button class=" btn course-btn btn-secondary px-1 ms-2 course-del">
                Cancel
            </button>
        </div>
    </form>
    `);
});

$(".course-row").delegate(".course-del", "click", function () {
    $(this).parent().remove();
});
</script>
@endpush
