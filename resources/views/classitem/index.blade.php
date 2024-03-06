@extends('layout.template')

@section('custom')
<style>
    @media screen and (max-width:460px){
    #main-wrapper{
        position: fixed !important;
    }

    .max-height{
        padding-bottom: 100px !important;
    }
}
</style>
@endsection
@section('ajaxcsrf')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-sm-9 col-xs-12 d-flex ">
                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item asdf"><a href="#">Class</a></li>
                            <li class="breadcrumb-item active " aria-current="page">List</li>
                                <li class="breadcrumb-item active seachby" aria-current="page" style="display:none;">Search by <span
                                        class="text-primary" id="liveText"></span></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <form class="col-md-3" action="{{route('classitem.index')}}" method="get">
                <div class="mx-auto">
                    <div class="ui search">
                        <div class="ui icon input w-100">
                            <input class="form-control border-end-0 border" placeholder="search class" type="search"
                            value="{{ request('classitemsearch') }}" id="classitemsearch" name="classitemsearch">
                            {{-- @if (request('coursesearchclassitem') || request('studentsearchclassitem'))
                            <input hidden name="coursesearchclassitem" value="{{ request('coursesearchclassitem') }}">
                            <input hidden name="studentsearchclassitem" value="{{ request('studentsearchclassitem') }}">
                            @endif --}}
    
                            <i class="search icon"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row  px-3 max-height  d-sm-flex">
        <div class="col-12 col-md-9 table-container">
            <div class="card rounded-3">
                <div class="card-body ">
                    <div class="d-flex justify-content-between align-items-center mb-2 mb-lg-0 my-2">
                        <p class="mb-0 fw-bolder">Total - {{$classitem->total()}}</p>
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

                    <div class="table-responsive">
                        <table class="table table-striped highscro">
                            <thead>
                                <tr class="table-header" style="border-bottom: 2px solid black">
                                    <th scope="col" class="list-lecturer-col" >
                                        <p class="d-none d-md-block">Name</p>
                                        <p class="d-block d-md-none">Class & Lecturer</p>
                                    </th>
                                    <th scope="col" class="list-course-col">Course</th>
                                    <th class="d-none d-md-table-cell list-lecturer-col" scope="col">Lecturer</th>
                                    @can('viewAny', \App\Models\Classitem::class)
                                    <th scope="col" class="list-status-col">Status</th>
                                    <th class="d-none d-md-table-cell list-payment-col text-center" scope="col" >Payment</th>
                                    @endcan
                                    <th scope="col" class="text-center list-control-col" class="">
                                        <p class="d-none d-lg-block">Control</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="original" id="data-wrapper">
                                @include('classitem.data')
                                </div>
                              </tbody>
                              <tbody class="find" id="data-wrapper2">
                            </tbody>
                            @if(count($classitem)>=15)
                              <tr>
                                <td colspan="6" class="text-center">
                                    <button class="btn btn-secondary load-more-data"><i class="fa fa-refresh"></i> More Data...</button>
                                </td>
                              </tr>
                              @endif
                              <tr>
                                <td colspan="6" class="text-center">
                                    <button class="btn btn-secondary load-more-data2" style="display: none;"><i class="fa fa-refresh"></i>More Data...</button>
                                </td>
                              </tr>
                        </table>
                    </div>
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
                </div>
                <div class="d-flex justify-content-end me-3">
                {{-- {{$classitem->links()}} --}}
            </div>
            </div>

        </div>
        <div class="col-3 d-none d-md-block class-filter-container">
            <div class="card">
                <div class="card-body position-relative filter-card">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="mdi mdi-filter-outline h3 me-1"></i>
                        <p class="  fs-4 mb-2 text-center">Class Filter</p>
                    </div>
                    <form action="{{route('classitem.index')}}" method="get">
                        <div class=" mb-3">
                            <label for="">Course</label>
                            <select id="coursesearchclassitem" class="ui dropdown w-100 shadow-none" style="width: 100%; height:36px;" name="coursesearchclassitem">
                                <option value = "-1">Select Course</option>
                                @foreach($courseoption as $courses)
                                    <option value="{{$courses->id}}" {{ $courses->id == request('coursesearchclassitem') ? 'selected' : '' }}>{{$courses->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" mb-3">
                            <label for="">Student</label>
                            <select id="studentsearchclassitem" class="ui dropdown w-100 shadow-none" style="width: 100%; height:36px;" name="studentsearchclassitem" id="studentsearchclassitem">
                                <option value = "-1">Select Student</option>
                                @foreach($studentoption as $students)
                                    <option value="{{$students->id}}" {{ $students->id == request('studentsearchclassitem') ? 'selected' : '' }}>{{$students->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="d-flex justify-content-center">
                            <div class="position-absolute filterbtn">
                                <a class="btn btn-secondary cnl-btn me-2" href="{{route('classitem.index')}}">Cancel</a>
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
    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Class Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body  position-relative">
                    <form target="_blank" action="{{route('classitem.index')}}" method="get">
                        <div class=" mb-3">
                            <label for="">Course</label>
                            <select class="ui dropdown w-100 shadow-none" style="width: 100%; height:36px;" name="coursesearchclassitem">
                                <option>Select Course</option>
                                @foreach($courseoption as $courses)
                                    <option value="{{$courses->name}}">{{$courses->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Student</label>
                            <select class="ui dropdown w-100 shadow-none" name="studentsearchclassitem">
                                <option>Select Class</option>
                            @foreach($studentoption as $students)
                                <option value="{{$students->id}}">{{$students->name}}</option>
                            @endforeach
                            </select>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>


    var ENDPOINT = "{{ route('classitem.index') }}";
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
                    $("#data-wrapper").append(response.html);


                if (response.html.includes('Data is Empty')) {
            $('.load-more-data').hide();
          }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }

    var ENDPOINT2 = "{{ route('classitem.search') }}";
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
        var classitemsearch = $("#classitemsearch").val();
        var coursesearchclassitem = $("#coursesearchclassitem").val();
        var studentsearchclassitem = $("#studentsearchclassitem").val();

        let query = `?classitemsearch=${classitemsearch}&coursesearchclassitem=${coursesearchclassitem}&studentsearchclassitem=${studentsearchclassitem}`;
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


                if (response.includes('Data is Empty')) {
            $('.load-more-data2').hide();
          }
            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
    }

// }



    //addToast
    @if(session('message'))
        new Noty({
                type: 'success',
                layout: 'bottomLeft',
                theme: 'nest',
                text:  'Classitem create successfully',
                timeout: '2000',
                progressBar: true,
                closeWith: ['click'],
                killer: true,

                }).show();

    @endif

    @if(session('del'))
        new Noty({
                type: 'success',
                layout: 'bottomLeft',
                theme: 'nest',
                text:  'Classitem delete successfully',
                timeout: '2000',
                progressBar: true,
                closeWith: ['click'],
                killer: true,

                }).show();

    @endif

    $('.ui.dropdown').dropdown();

    </script>

@endpush
