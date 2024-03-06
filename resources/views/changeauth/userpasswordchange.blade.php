@extends('layout.template')
@section('content')
<style>

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

<h1>Password</h1>
      <form action="{{route('uuserpassword' , $user->id)}}" method="POST" class="p-5">
        @csrf
        @method('put')
        
          @if(session('status'))
            <div class="alert alert-success" role="alert">
              {{session('status')}}
            </div>
          @elseif(session('error'))
            <div class="alert alert-danger" role="alert">
              {{session('error')}}
            </div>
          @endif

          <div class="form-floating mb-3 ">
            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" id="" placeholder="*******">
            <label for="floatingInput">Current Password</label>
          </div>
          @error('current_password')
            <span class="text-danger">{{$message}}</span>
          @enderror

        


          <div class="form-floating mb-3">
            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">New Password</label>
          </div>
          @error('new_password')
          <span class="text-danger">{{$message}}</span>
          @enderror

          <div class="form-floating mb-3">
            <input type="password" name="new_password_confirmation" class="form-control " id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Re-type New Password</label>
          </div>
          
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
@endsection


