@extends('layout.template')

@section('custom')
    <link rel="stylesheet" href="{{ asset('css/scheduler.css') }}">
    <style>
      
        .page-wrapper{
               
                padding-top: 55px;
        }

        .dropdown-item:focus, .dropdown-item:hover {
            color: #5d5f61;
            background-color: #f8f9fa;
        }

        .dropdown-item.active {
            color: #fff;
            text-decoration: none;
            background-color: #4199ff;
        }

        
        
        @media screen and (min-width:768px) {
            .page-wrapper{
               
                padding-top: 73px !important;
            }

            .page-wrapper::-webkit-scrollbar{
                display: none;
            }
        }

    </style>
@endsection

@section('content')
    <input type="hidden" id="scheduler" value="{{ json_encode($data) }}" />
    {{-- dd({{$data}}) --}}
    <div class="page-breadcrumb-fixed">
        <div class="page-breadcrumb ">
            <div class="row">
                <div class="col-12  d-flex justify-content-between">
                    <div class="">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item "><a href="#">Class</a></li>
                                <li class="breadcrumb-item active " aria-current="page"></li>
                                
                            </ol>
                        </nav>
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        {{-- <div class="mx-auto">
                            <form action="{{ route('schdeuler.index') }}">
                                <div class="input-group">
                                    <input class="form-control border-end-0 border" placeholder="search" type="search"
                                        name="keyword" value="{{ request('keyword') }}" id="example-search-input">
                                    <span class="input-group-append">
                                        <button
                                            class="btn btn-outline-secondary bg-white hover-none border-start-0 border-bottom-0 border ms-n5"
                                            type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div> --}}
                        <div class="d-flex justify-content-center align-items-center bg-light shadow-sm ">
                            <form action="{{ route('schedular.preMonth', date_format(current($monthArr), 'Y-M-d')) }}"
                                method="GET" id="nextMonth">
                                <button class="btn btn-light "><i class=" mdi mdi-arrow-left"></i></button>
                                <input hidden name="keyword" value="{{ request('keyword') }}">
                            </form>
                            <div class=" fw-bold mx-3">{{ date_format(current($monthArr), 'Y-M') }} ~
                                {{ date_format(end($monthArr), 'Y-M') }}</div>
                            <form action="{{ route('schedular.nextMonth', date_format(end($monthArr), 'Y-M-d')) }}"
                                method="GET" id="nextMonth">
                                <button class="btn btn-light "><i class=" mdi mdi-arrow-right"></i></button>
                                <input hidden name="keyword" value="{{ request('keyword') }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- <div class="row  px-3">
            <div class="col-6 col-md-2 mb-2 position-relative all-room  ">
                <div style="width: auto">
                    <a class="btn all-room-ph w-100 dropdown-toggle " href="#" role="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="d-flex justify-content-between align-items-center">
                            <p>Total Rooms - {{ count($roomsForSelect) }}</p>
                            <i class="mdi mdi-chevron-down "></i>
                        </div>
                    </a>
                    <ul class="dropdown-menu room-dropdown w-100"  aria-labelledby="dropdownMenuButton1">
                        commentbyamy
                        <li class="w-100">
                            <a href="{{ route('schdeuler.index') }}" class="link btn btn-light w-100">
                                <p>All room</p>
                            </a>
                        </li>
                        commentbyamy
                        @foreach ($roomsForSelect as $room)
                            <li class="">
                                <form class="d-flex">
                                    <input hidden type="search" name="keyword" value="{{ $room->name }}">
                                    <button class="dropdown-item"> {{ $room->name }}
                                    </button>
                                </form>

                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <!-- Button trigger modal -->
            <button type="button "
                class="col-2 btn  btn-primary room-create d-flex justify-content-center align-items-center gap-1"
                data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="mdi mdi-plus-circle  mb-0"></i>
                <p class="">Create Room</p>
            </button>


        </div> --}}
    </div>

    <!-- Create Room Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('room.store') }}" method="POST">
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="room">Room name</label>
                            <input type="text" name="name" value="" class="form-control " id="room"
                                placeholder="Room 01">

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


    @error('name')
    <div class="modal fade " id="errorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('room.store') }}" method="POST">
                    <div class="modal-body">

                        @csrf
                        <div class="form-group">
                            <label for="room">Room name</label>
                            <input type="text" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" id="room"
                                placeholder="Room 01">
                            @error('name')
                                <div class=" invalid-feedback">{{ $message }}</div>
                            @enderror
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
    @enderror


   @foreach ($rooms->take(1) as $room)
   <div class="row px-3 scheduler " style="">
    <div class="col-12 d-block d-md-none ">
        <div class="room-row-ph">
            <p class=" fs-4 fw-bolder h4  text-center p-2"> {{ $room->name }} </p>
        </div>
    </div>

    <div class="col-2 d-none d-lg-block ">
        <div class="roomclassgrid">
        <div class="position-relative all-room" style="z-index:2;">
            <div style="width: auto">
                <a class="btn all-room-ph w-100 dropdown-toggle " href="#" role="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="d-flex justify-content-between align-items-center">
                        <p>Total Rooms - {{ count($roomsForSelect) }}</p>
                        <i class="mdi mdi-chevron-down "></i>
                    </div>
                </a>
                <ul class="dropdown-menu room-dropdown w-100"  aria-labelledby="dropdownMenuButton1">
                    {{-- commentbyamy
                    <li class="w-100">
                        <a href="{{ route('schdeuler.index') }}" class="link btn btn-light w-100">
                            <p>All room</p>
                        </a>
                    </li>
                    commentbyamy --}}
                    @foreach ($roomsForSelect as $r)
                        <li class="">
                            <form class="d-flex">
                                <input hidden type="search" name="keyword" value="{{ $r->name }}">
                                <button class="dropdown-item"> {{ $r->name }}
                                </button>
                            </form>

                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="card">            
            <div class="card-body position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="  fs-4 fw-bolder h4  text-center">{{ $room->name }}</p>
                    <div class="btn-group control-btn dropup ">
                        <button type="button"
                            class="btn table-btn-sm btn-outline-dark border border-0 dropdown-toggle room-control"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </button>

                        <ul class="dropdown-menu mb-1">
                            <div class="d-flex ">
                                <li>

                                    <button type="button "
                                        class="btn table-btn-sm btn-outline-primary border border-0"
                                        data-bs-toggle="modal" data-bs-target="#EditRoom">
                                        <i class="mdi mdi-pencil h5"></i>
                                    </button>


                                </li>
                                <li>
                                    <form action="{{ route('room.destroy', $room->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="btn table-btn-sm btn-outline-danger border border-0">
                                            <i class="mdi mdi-delete h5 "></i>
                                        </button>
                                    </form>

                                </li>

                            </div>
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">

                    <!--Edit Room Modal -->
                    <div class="modal fade" id="EditRoom" tabindex="-1" aria-labelledby="EditRoomLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="EditRoomLabel">
                                        Edit Room Name
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('room.update', $room->id) }}" method="POST">
                                    <div class="modal-body">

                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <label for="room">Room name</label>
                                            <input type="text" name="name" class="form-control"
                                                id="room" placeholder="Room 01">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <hr>
                <p class="my-2 fw-bold">Class Lists</p>
                <ul class=" list-group ">
                    @forelse ($room->classitems->take(5) as $classitem)
                        {{-- <a href="{{ route('classitem.show', $classitem->id) }}"
                            class=" list-group-item list-group-item-action">
                            {{ Str::limit($classitem->name, 20, '...') }}</a> --}}
                            <a href="{{ URL::to('/preMonth/'.date('Y-m', strtotime('+5 months', strtotime($classitem->start_date)))).'-01?keyword='.$classitem->room->name }}"
                                class=" list-group-item list-group-item-action">
                                {{ Str::limit($classitem->name, 20, '...') }}</a>
                    @empty
                        <li class=" list-group-item list-group-item-action text-black-50">No Class</li>
                    @endforelse
                </ul>
                <div class="d-flex justify-content-center align-items-center  ">
                    <div class="filterbtn">
                        <a href="{{ route('classitem.create') }}" class="btn btn-outline-primary sub-btn "
                            type="submit">Add Class</a>
                    </div>
                </div>

            </div>
            
        </div>
        <div>
        <button type="button "
        class=" col-12 btn  btn-primary d-flex justify-content-center align-items-center gap-1 createroombtn"
        data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="mdi mdi-plus-circle  mb-0"></i>
        <p class="">Create Room</p>
    </button>
</div>
</div>
    </div>
    <div class="col-12 col-lg-10 p-auto card-over-container">
        <div class="card rounded-3 ">
            <div class="card-body">

                <div class="scheduler-container">

                    <div class="grid-container">
                        <div class="day-type">Weekdays</div>
                        <div class="d-flex months">
                            <div class=""
                                style="width:100%; border-right: 1px solid #a9aeb3; border-bottom: 1px solid #a9aeb3;height: 40px;">
                            </div>
                            @foreach ($monthArr as $month)
                                <div class="month-row fs-4 fw-bolder text-end py-0" style="">
                                    {{ $month->format('M') }} </div>
                            @endforeach
                        </div>
                        <div class="times">
                            @foreach ($timeArr as $time)
                                <div class="d-flex">
                                    <div class="time-row">
                                        {{ $time }}
                                    </div>
                                    @foreach ($monthArr as $month)
                                        {{-- @dump($month->between("01-10-2023", "31-01-2024")) --}}
                                        {{-- {{$month->format('d-m-Y')}} --}}
                                        <div class=" fs-4 fw-bolder text-end py-0 sch-inner">

                                            @foreach ($room->classitems as $classitem)
                                                @if ($classitem->type === 'weekdays')
                                                    @php
                                                        $start_date1 = new DateTime($classitem->start_date);
                                                        $end_date1 = new DateTime($classitem->end_date);
                                                        $difference = date_diff($start_date1, $end_date1);
                                                        $monthdif = $difference->m;

                                                        $timedif = date('H', strtotime($classitem->end_time)) - date('H', strtotime($classitem->start_time));
                                                        $tablemonth = date('m', strtotime($month)) + 1;
                                                        $tablehour = date('H', strtotime($time)) + 1;

                                                    @endphp
                                                    {{-- @for ($i = 0; $i <= $monthdif; $i++) --}}
                                                    @php
                                                        $tablemonth--;
                                                        $monthstring = sprintf('%02d', $tablemonth);
                                                        $tablehour = '';
                                                        $tablehour = date('H', strtotime($time)) + 1;

                                                    @endphp
                                                    {{-- @dump($monthdif) --}}
                                                    @for ($k = 0; $k <= $timedif; $k++)
                                                        @php
                                                            $tablehour--;
                                                            $hourstring = sprintf('%02d', $tablehour);
                                                        @endphp
                                                        @if (
                                                            $month->between(Carbon\Carbon::parse($classitem->start_date)->format('Y-m'),
                                                                Carbon\Carbon::parse($classitem->end_date)->format('Y-m')) && $hourstring === date('H', strtotime($classitem->start_time)))
                                
                                                            <a href="{{ route('classitem.show' , $classitem->id) }}" class="active-classitem"
                                                                style=" background-color: {{ $classitem->container_color }}; border: 1px solid {{ $classitem->container_color }}; border-right: 1px solid {{ $classitem->container_color }}; border-bottom: 1px solid {{ $classitem->container_color }};"
                                                                
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="{{ $classitem->name }}"
                                                                >

                                                                @if ($k == round(($timedif-1)/2) && $month->format('m') == date('m', strtotime($classitem->start_date)))
                                                                    
                                                                        {{ $classitem->code }}              {{-- @push('scripts')
                                                                    <script>
                                                                        let activeColor = "@php echo $classitem->container_color @endphp";
                                                                        $('.active-classitem').parent().css('border-right', activeColor);
                                                                    </script>
                                                                @endpush --}}
                                                                @endif


                                                            </a>

                                                        @endif
                                                        {{-- @endfor --}}
                                                    @endfor
                                                @endif
                                            @endforeach

                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <div>
                            <div colspan="8">
                                <div class="p-0 week-line"></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid-container">
                        <div class="day-type">Weekend</div>
                        <div class="months"></div>
                        <div class="times">
                            @foreach ($timeArr as $time)
                                <div class="d-flex">

                                    <div class="time-row">
                                        {{ $time }}
                                    </div>

                                    @foreach ($monthArr as $month)
                                        <div class=" fs-4 fw-bolder text-end py-0 sch-inner">

                                            @foreach ($room->classitems as $classitem)
                                                @if ($classitem->type === 'weekend')
                                                    @php
                                                        $start_date1 = new DateTime($classitem->start_date);
                                                        $end_date1 = new DateTime($classitem->end_date);
                                                        $difference = date_diff($start_date1, $end_date1);
                                                        $monthdif = $difference->m;

                                                        $timedif = date('H', strtotime($classitem->end_time)) - date('H', strtotime($classitem->start_time));
                                                        $tablemonth = date('m', strtotime($month)) + 1;
                                                        $tablehour = date('H', strtotime($time)) + 1;

                                                    @endphp
                                                    {{-- @for ($i = 0; $i <= $monthdif; $i++) --}}
                                                    @php
                                                        $tablemonth--;
                                                        $monthstring = sprintf('%02d', $tablemonth);
                                                        $tablehour = '';
                                                        $tablehour = date('H', strtotime($time)) + 1;

                                                    @endphp
                                                    {{-- @dump($monthdif) --}}
                                                    @for ($k = 0; $k <= $timedif; $k++)
                                                        @php
                                                            $tablehour--;
                                                            $hourstring = sprintf('%02d', $tablehour);
                                                        @endphp
                                                        @if (
                                                            $month->between(Carbon\Carbon::parse($classitem->start_date)->format('Y-m'),
                                                                Carbon\Carbon::parse($classitem->end_date)->format('Y-m')) && $hourstring === date('H', strtotime($classitem->start_time)))
                                                            <a href="{{route('classitem.show' , $classitem->id )}}" id="asdf" class="active-classitem"
                                                                style=" background-color: {{ $classitem->container_color }}; border: 1px solid {{ $classitem->container_color }}; border-right: 1px solid {{ $classitem->container_color }}; border-bottom: 1px solid {{ $classitem->container_color }};"
                                                                data-toggle="tooltip" data-placement="bottom"  
                                                                        title="{{ $classitem->name }}">

                                                                @if ($k == round(($timedif-1)/2) && $month->format('m') == date('m', strtotime($classitem->start_date)))

                                                                        {{ $classitem->code }}

                                                                    {{-- @push('scripts')
                                                                    <script>
                                                                        // let activeColor = "@php echo $classitem->container_color @endphp";
                                                                        $('.active-classitem').parent().css('border-right', activeColor);
                                                                    </script>
                                                                    @endpush --}}
                                                                @endif


                                                            </a>
                                                        @endif
                                                        {{-- @endfor --}}
                                                    @endfor
                                                @endif
                                            @endforeach

                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center d-lg-none">
        <div class="">
            <a href="{{ route('classitem.create') }}" class="btn btn-primary  mt-1"
                type="submit ">Add Class</a>
        </div>
    </div>


</div>
   @endforeach

   
@endsection

@push('scripts')

<script>

let activeColor = "@php
                        if($room->classitem !== null){
                            echo $classitem->container_color;
                        }else{
                            echo "transparent";
                        }

                    @endphp";
$('.active-classitem').parent().css('border-right', activeColor);

    $(document).ready(function(){
        $("#errorModal").modal('show');
    });
</script>
@endpush
