@extends('layout.template')
@section('content')
<style>
  /* a{
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
  } */
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
      {{-- <form method="post" action="{{route('user.update', $user->id)}}">
        @csrf
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
        </div>


      </form> --}}
      <form action="{{route('uusername' , $user->id)}}" method="POST" class="p-5">
        @csrf
        @method('put')
        <h1 class="">Name</h1>
          {{-- @if(session('status'))
            <div class="alert alert-success" role="alert">
              {{session('status')}}
            </div>
          @elseif(session('error'))
            <div class="alert alert-danger" role="alert">
              {{session('error')}}
            </div>
          @endif --}}

          <div class="form-floating mb-3">
            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" name="name" value="{{$user->name}}">
            <label for="floatingInput">Name</label>
          </div>
          @error('name')
            <span class="text-danger">{{$message}}</span><br>
          @enderror
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
     
    </div>
  </div>
</div>
@endsection


