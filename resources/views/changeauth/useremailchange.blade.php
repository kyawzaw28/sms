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

      <form action="{{route('uuseremail' , $user->id)}}" method="POST" class="p-5">
        @csrf
        @method('put')
        <h1 class="">Email</h1>

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
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" value="{{$user->email}}">
            <label for="floatingInput">Email</label>
          </div>
          @error('email')
            <span class="text-danger">{{$message}}</span><br>
          @enderror
          
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>

     
    </div>
  </div>
</div>
@endsection


