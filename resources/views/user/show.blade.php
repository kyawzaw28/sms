@extends('layout.template')
@section('content')
<style>
  a{
    display: inline-block;
  }
  .w-40{
    width: 40%;
  }
  .custom-font {
    font-size: 18px;
  }
  .border-top{
    border-top: 1px;
    border-bottom: 0;
    border-left: 0;
    border-right: 0;
  }
  .border-bottom{
    border-top: 0;
    border-bottom: 1px;
    border-left: 0;
    border-right: 0;
  }
</style>



<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex ">
      <div class="">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="#">Users</a></li>
            <li class="breadcrumb-item active " aria-current="page">Create</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<div class="row  px-3">
<div class="col-md-12">
  <div class="card rounded-3 " style="height: 600px">
    <div class="card-body">
      <form method="post" action="{{route('user.update', $user->id)}}">
        {{-- @csrf
        @method('put')
        <div class="row col-md-4">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="name" class="form-control" id="name" placeholder="Name" name="name" value="{{$user->name}}">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{$user->email}}">
          </div>
          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-select" name="role">
              <option id = "role" selected>Select Role</option>
              @foreach($roleoptions as $roledata)
              <option value="{{$roledata->id}}" {{$user->role_id == $roledata->id ? 'selected' : '' }}>{{$roledata->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class = "mt-5 text-center create-filterbtn">
          <a href="{{route('user.index')}}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div> --}}

        {{-- pyin --}}
        <div class="list-group px-5">

          <a href="{{route('cusername' , auth()->user()->id )}}"  class="list-group-item list-group-item-action py-3 d-flex justify-content-between border-top border-bottom" name ="name" >
            <div class="d-flex w-40 justify-content-between align-items-center">
              <div>Name</div>
              <div class="custom-font w-50 text-align-left"><b>{{$user->name}}</b></div>
            </div>    
            <div class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
              </svg>
            </div>
          </a>

          <a href="{{route('cuseremail' , auth()->user()->id )}}" type="button" class="list-group-item list-group-item-action py-3 d-flex justify-content-between border-bottom" name ="email" >
            <div class="d-flex w-40 justify-content-between align-items-center">
              <div>Email</div>
              <div class="custom-font w-50 text-align-left"><b>{{$user->email}}</b></div>
            </div>    
            <div class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
              </svg>
            </div>
          </a>

          <a href="{{route('cuserpassword', auth()->user()->id)}}" type="button" class="list-group-item list-group-item-action py-3  d-flex justify-content-between border-bottom" name ="password" >
            <div class="d-flex w-40 justify-content-between align-items-center">
              <div>Password</div>
              <div class="custom-font w-50 text-align-left"><b>********</b></div>
            </div>    
            <div class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
              </svg>
            </div>
          </a>

        </div>
        {{-- pyin --}}

      </form>
    </div>
  </div>
</div>
@endsection


