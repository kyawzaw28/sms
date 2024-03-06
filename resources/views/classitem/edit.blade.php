@extends('layout.template')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <!-- <h4 class="page-title">Classes / Class Create</h4> -->
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('classitem')}}">Class</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
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
        <form method="POST" action="{{route('classitem.update', $classitem->id)}}">
          @csrf
          @method('put')
          <input type="text" value="{{ $classitem->id }}" name="classitem_id" hidden >
          <div class = "row testcalendar">
            <div class="col-sm-4">
              <div class="form-group test">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Class name" name="name" value="{{$classitem->name}}">
                <span class="text-danger">@error('name') {{$message}} @enderror</span>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group test">
                <label for="startdate">Start Date</label>
                <input type="date" class="form-control" id="enddate" placeholder="Start date" name="startdate" value="{{$classitem->start_date}}">
                <span class="text-danger">@error('start_date') {{$message}} @enderror</span>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group test">
                <label for="enddate">End Date</label>
                <input type="date" class="form-control" id="enddate" placeholder="End date" name="enddate" value="{{$classitem->end_date}}">
                <span class="text-danger">@error('end_date') {{$message}} @enderror</span>
              </div>
            </div>
            <div class="col-sm-4 mt-3">
              <div class="form-group test">
              <label for="course">Course Name</label>
                <select class="form-select slectopt" id="course" name="course">
                  <option value="">Select course name</option>
                  @foreach($courseoption as $course)
                  <option value="{{$course->id}}" {{$classitem->course_id == $course->id ? 'selected' : '' }}>{{$course->name}}</option>
                  @endforeach
                </select>
                <span class="text-danger">@error('course') {{$message}} @enderror</span>
              </div>
            </div>
            <div class="col-sm-4 mt-3">
              <div class="form-group test">
                <label for="starttime">Start Time</label>
                <!-- <input type="time" class="form-control" id="starttime" value="19:00"> -->
                <input type="text" placeholder="--:--" onfocus="(this.type='time')" class="form-control" id="starttime" name="starttime" value="{{$classitem->start_time}}">
                <span class="text-danger">@error('starttime') {{$message}} @enderror</span>
              </div>
            </div>
            <div class="col-sm-4 mt-3">
              <div class="form-group test">
                <label for="endtime">End Time</label>
                <input type="text" placeholder="--:--" onfocus="(this.type='time')" class="form-control" id="endtime" class="starttime" name="endtime" value="{{$classitem->end_time}}">
                <span class="text-danger">@error('endtime') {{$message}} @enderror</span>
              </div>
            </div>
            {{-- <div class="col-sm-4 mt-3">
              <div class="form-group test">
              <label for="lecturer">Lecturer</label>
                <select class="form-select slectopt" id="lecturer" name="lecturer">
                  <option value="">Select Lecturer name</option>
                  @foreach($lectureroption as $lecturer)
                  <option value="{{$lecturer->id}}" {{ $classitem->users->contains($lecturer->id) ? 'selected' : '' }}>{{$lecturer->name}}</option>
                  @endforeach
                </select>
                <span class="text-danger">@error('lecturer') {{$message}} @enderror</span>
              </div>
            </div> --}}
            <div class="col-sm-4 mt-3">
              <div class="form-group test">
                <label for="lecturer" class="d-block">Lecturer</label>
                {{-- <div class = "multisel-day"> --}}
                <select class="js-example-basic-multiple form-select" name="lecturers[]" multiple="multiple" id="lecturer">
                  @foreach($lectureroption as $lecturer)
                  <option value="{{$lecturer->id}}" {{in_array($lecturer->id, $classitem->users->pluck('id')->toArray()) ? 'selected' : ''  }}>{{$lecturer->name}}</option>
                  @endforeach
                </select>
                <span class="text-danger">@error('days') {{$message}} @enderror</span>
                {{-- </div> --}}
              </div>
            </div>
            <div class="col-sm-4 mt-3">
              <div class="form-group test">
              <label for="room">Room</label>
                <select class="form-select slectopt" id="room" name="room">
                  <option value="">Select Room name</option>
                  @foreach($roomoption as $room)
                  <option value="{{$room->id}}" {{$classitem->room_id == $room->id ? 'selected' : '' }}>{{$room->name}}</option>
                  @endforeach
                </select>
                <span class="text-danger">@error('room') {{$message}} @enderror</span>
              </div>
            </div>
            <div class="col-sm-4 mt-3">
              <div class="form-group test">
                <label for="day" class="d-block">Day</label>
                {{-- <div class = "multisel-day"> --}}
                <select class="js-example-basic-multiple form-select" name="days[]" multiple="multiple" id="day">
                  <option value="Monday" {{in_array('Monday', explode(', ',$classitem->day)) ? 'selected' : '' }}>Monday</option>
                  <option value="Tuesday" {{in_array('Tuesday',explode(', ',$classitem->day)) ? 'selected' : '' }}>Tuesday</option>
                  <option value="Wednesday" {{in_array('Wednesday', explode(', ',$classitem->day)) ? 'selected' : '' }}>Wednesday</option>
                  <option value="Thursday" {{in_array('Thursday', explode(', ',$classitem->day)) ? 'selected' : '' }}>Thursday</option>
                  <option value="Friday" {{in_array('Friday', explode(', ',$classitem->day)) ? 'selected' : '' }}>Friday</option>
                  <option value="Saturday" {{in_array('Saturday', explode(', ',$classitem->day)) ? 'selected' : '' }}>Saturday</option>
                  <option value="Sunday" {{in_array('Sunday', explode(', ',$classitem->day)) ? 'selected' : '' }}>Sunday</option>
                </select>
                <span class="text-danger">@error('days') {{$message}} @enderror</span>
                {{-- </div> --}}
              </div>
            </div>
            <div class="col-sm-4 mt-3">
              <div class="form-group test">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" placeholder="Price" name="price" value="{{$classitem->price}}">
                <span class="text-danger">@error('price') {{$message}} @enderror</span>
              </div>
            </div>
            <div class="col-sm-4 mt-3">
              <div class="form-group test">
                <label for="maxstudent">Maximun Student</label>
                <input type="number" class="form-control" id="maxstudent" placeholder="Student limit" name="maxstudent" value="{{$classitem->max_student}}">
                <span class="text-danger">@error('maxstudent') {{$message}} @enderror</span>
              </div>
            </div>
            <div class="col-sm-4 mt-3">
              <div class="form-group test">
              <label for="type">Type</label>
                <select class="form-select slectopt" id="type" name="daytype">
                  <option value="">Select type</option>
                  <option value="weekdays" {{$classitem->type == 'weekdays' ? 'selected' : '' }}>Weekday</option>
                  <option value="weekend" {{$classitem->type == 'weekend' ? 'selected' : ''}}>Weekend</option>
                </select>
                <span class="text-danger">@error('daytype') {{$message}} @enderror</span>
              </div>
            </div>
            <div class="col-sm-4 mt-3">
              <div class="form-group test">
                <label for="hex">Set Color</label>
                <div class="d-flex">
                <input type="text" placeholder="#958D8D" class="form-control" id="hex">
                <input type="color"  id="color" class = "class-colorpicker" name="color" value="{{$classitem->container_color}}">                
                </div>
                <span class="text-danger">@error('color') {{$message}} @enderror</span>
              </div>
            </div>
            <div class="col-sm-4 mt-3">
              <div class="form-group test">
                <label for="shortcode">Short Code</label>
                <input type="text" class="form-control" id="shortcode" placeholder="Short Code" name="shortcode" value="{{$classitem->code}}">
                <span class="text-danger">@error('shortcode') {{$message}} @enderror</span>
              </div>
            </div>
            {{-- <div class="col-sm-4 mt-3">
              <div class="form-group test">
              <label for="room">Room Name</label>
                <select class="form-select slectopt" id="room" name="room">
                  <option selected>Select room name</option>
                  <option value="1">Room One</option>
                  <option value="2">Room Two</option>
                  <option value="3">Room Three</option>
                </select>
              </div>
            </div> --}}
      </div>

      <div class="create-edit-btn-bottom">
        <div class=" text-center form-create-btn">
      <button type="submit" class="btn btn-secondary">Cancel</button>
      <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
      </div>
    </div>
</div>


@endsection
