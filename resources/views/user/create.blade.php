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
@endsection
@section('content')
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
<div class="row  px-3 max-height">
<div class="col-md-12 table-container">
  <div class="card rounded-3 ">
    <div class="card-body">
      {{-- @if(session()->has('message'))
                    <div class="alert alert-success success-alt mt-2">
                      {{session()->get('message')}}
                      <button type="button" class="close success-msg" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                    </div>
                    @endif --}}

                    {{-- @if(session()->has('message'))
                    <script>
import Noty from 'noty';

const noty = new Noty({
    type: 'success',
    message: 'Your file has been uploaded successfully.',
});

noty.show();

                    </script>
                @endif --}}
      <form action="{{route('user.store')}}" method="post">
        @csrf
        <div class="row col-md-4">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="name" class="form-control" id="name" placeholder="Name" name="name">
            <span class="text-danger">@error ('name') {{$message}} @enderror</span>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Email" name="email">
            <span class="text-danger">@error ('email') {{$message}} @enderror</span>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="password" name="password">
            <span class="text-danger">@error ('password') {{$message}} @enderror</span>
          </div>
          <div class="form-group">
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" class="form-control" id="confirmpassword" placeholder="Confirm Password" name="confirm_password">
            <span class="text-danger">@error ('confirm_password') {{$message}} @enderror</span>
          </div>
          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-select" name="role">
              <option id = "role" value="">Select Role</option>
              @foreach($roleoptions as $roles)
              <option value="{{$roles->id}}">{{$roles->name}}</option>
              @endforeach
            </select>
            <span class="text-danger">@error ('role') {{$message}} @enderror</span>
          </div>
        </div>
        <div class = "mt-5 text-center create-filterbtn">
          <a href="{{route('user.index')}}" class="btn btn-secondary ss">Cancel</a>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

