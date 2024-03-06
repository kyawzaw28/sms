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
                            <li class="breadcrumb-item asdf"><a href="#">Admins</a></li>
                            <li class="breadcrumb-item active " aria-current="page">List</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <form class="col-md-3" method="get" action="{{route('user.index')}}">
                <div class="mx-auto">
                    <div class="ui search">
                        <div class="ui icon input w-100">
                            <input class="form-control border-end-0 border" placeholder="search user" type="search"
                                value="{{request('usersearch')}}" id="usersearch" name="usersearch">
                                <i class="search icon"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- filter button -->


    <!-- end filter button -->
    <!-- responsive table -->
    {{-- <div class="row  px-3 max-height d-xs-block d-sm-none">
        <div class="col-12 col-md-9 table-container">
            <div class="card rounded-3 d-sm-block d-md-none">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2 mb-lg-0">
                        <p class="mb-0 fw-bolder">Total - {{$userdata->total()}}</p>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <a href="{{ route('user.create') }}" class="btn plus-btn btn-outline-secondary">
                                <i class="mdi mdi-plus h5"></i>
                            </a>
                            <!-- Button trigger modal -->
                            <div class="d-flex justify-content-end  d-xs-block d-md-none filter-btn">
                                <button type="button" class="btn plus-btn btn-outline-secondary d-flex "
                                    data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    <i class="mdi mdi-filter-outline h5 mb-0"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr style="border-bottom: 2px solid black">
                                <th scope="col">
                                   <p class="d-none d-lg-block">Name</p>

                                </th>
                                <th scope="col">Email</th>
                                <th scope="col" class="text-end">Control</th>
                            </tr>
                        </thead>
                        <tbody class="original">
                            @foreach($userdata as $user)
                            <tr data-bs-toggle="collapse" href="#collapseExample2">
                                <th scope="col">
                                    <p class="d-none d-lg-block">Name</p>
                                    <div class="d-block d-lg-none">
                                        <p>{{$user->name}}</p>

                                    </div>
                                 </th>
                                <td class="align-middle">{{$user->email}}</td>
                                <td class="text-end align-middle">
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn table-btn-sm btn-primary">
                                        <i class="mdi mdi-pencil h5"></i>
                                    </a>
                                    <form action="{{route('user.destroy' , $user->id)}}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <btn  class="btn table-btn-sm btn-danger alertbox">
                                            <i class="mdi mdi-delete h5 text-white"></i>
                                        </btn>
                                    </form>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                        <tbody class="find" id="data-wrapper2">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- end responsive -->
    


    <div class="row  px-3 max-height">
        <div class="col-12  table-container">
            <div class="card rounded-3 ">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2 mb-lg-0 py-2">
                        <p class="mb-0 fw-bolder">Total - {{$userdata->total()}}</p>
                        <div class="">
                            <a href="{{ route('user.create') }}" class="btn plus-btn btn-outline-secondary">
                                <i class="mdi mdi-plus h5"></i>
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead >
                                <tr class="table-header" style="border-bottom: 2px solid black">
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                    
                                    <th scope="col" class="text-end">Control</th>
                                </tr>
                            </thead>
                            <tbody class="original" id="data-wrapper">
                               @include('user.data')
                            </tbody>
                            <tbody class="find" id="data-wrapper2">
                            </tbody>
                            @if(count($userdata)>=15)
                              <tr>
                                <td colspan="6" class="text-center">
                                    <button class="btn btn-secondary load-more-data"><i class="fa fa-refresh"></i> Load More Data...</button>
                                </td>
                              </tr>
                              @endif
                              <tr>
                                <td colspan="6" class="text-center">
                                    <button class="btn btn-secondary load-more-data2" style="display: none;"><i class="fa fa-refresh"></i> Load More Data...</button>
                                </td>
                              </tr>
                        </table>
                    </div>
                    {{-- @if(session()->has('message'))
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
                    @endif --}}

                   
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
              
            </div>
        </div>

    </div>
@endsection
@section('dataloader')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
@push('scripts')
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Admin Filter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body  position-relative">
                    <form action="">
                        <div class="mb-3">
                            <label for="">Role</label>
                            <select class="select2  form-select shadow-none">
                                <option>Select Role</option>
                                @foreach($roles as $roledata)
                                <option value="{{$roledata->id}}" {{$roledata->id == request('userrolefilter') ? 'selected' : ''}}>{{$roledata->name}}</option>
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
         @if(session('message'))
        new Noty({
                type: 'success',
                layout: 'bottomLeft',
                theme: 'nest',
                text:  'User create successfully',
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
                text:  'User delete successfully',
                timeout: '2000',
                progressBar: true,
                closeWith: ['click'],
                killer: true,

                }).show();

    @endif

    //load data with button
    var ENDPOINT = "{{ route('user.index') }}";
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

    var ENDPOINT2 = "{{ route('admin.search') }}";
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
        var usersearch = $("#usersearch").val();

        let query = `?usersearch=${usersearch}`;
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
    </script>
@endpush
