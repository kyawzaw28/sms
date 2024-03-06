@extends('layout.template')
@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex ">
        <div class="">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="#">Class</a></li>
                <li class="breadcrumb-item active " aria-current="page">List</li>
            </ol>
            </nav>
        </div>
        </div>
    </div>
</div>
<div class="row  px-3" style="height: 100%; padding-bottom: 50px">
    <div class="col-9">
        <div class="card rounded-3 " style="height: 100%">
            <div class="card-body">
               
        <div class="d-flex justify-content-between">
            <p class="mb-0 fw-bolder">Total - 10</p>
            <div class="">
              <a href="{{ route('classitem.create') }}" class="btn plus-btn btn-secondary">
              <i class="mdi mdi-plus h5"></i>
              </a>
            </div>
          </div>
          <table class="table table-striped">
            <thead>
              <tr style="border-bottom: 2px solid black">
                <th scope="col">Name</th>
                <th scope="col">Course</th>
                <th scope="col">Lecturer</th>
                <th scope="col" class="text-center">Payment</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-center">Control</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class = "align-middle">Basic to Pro</td>
                <td class = "align-middle">Web Development</td>
                <td class = "align-middle">Breden Wagner</td>
                <td class="text-center">
                  <a href="" class="btn table-btn-sm btn-primary">
                  <i class="mdi mdi-credit-card-multiple h5"></i>
                  </a>
                </td>
                <td>
                  <div class="bg-success pay-status d-flex justify-content-center align-items-center rounded">
                    paid
                  </div>
                </td>
                <td class="text-end">
                  <a href="{{ route('classitem.edit' , 1) }}" class="btn table-btn-sm btn-primary">
                  <i class="mdi mdi-pencil h5"></i>
                  </a>
                  <a href="" class="btn table-btn-sm btn-danger">
                  <i class="mdi mdi-delete h5 text-white"></i>
                  </a>
                  <a href="{{ route('classitem.show' , 'detail') }}" class="btn table-btn-sm btn-dark">
                  <i class="mdi mdi-dots-vertical h4"></i>
                  </a>
                </td>
              </tr>
              <tr>
                <td class = "align-middle">Basic Basic Basic </td>
                <td class = "align-middle">Japanese N5</td>
                <td class = "align-middle">Breden Wagner</td>
                <td class="text-center">
                  <a href="" class="btn table-btn-sm btn-primary">
                  <i class="mdi mdi-credit-card-multiple h5"></i>
                  </a>
                </td>
                <td>
                  <div class="bg-danger pay-status d-flex justify-content-center align-items-center rounded">
                    unpaid
                  </div>
                </td>
                <td class="text-end">
                  <a href="{{ route('classitem.edit' , 1) }}" class="btn table-btn-sm btn-primary">
                  <i class="mdi mdi-pencil h5"></i>
                  </a>
                  <a href="" class="btn table-btn-sm btn-danger">
                  <i class="mdi mdi-delete h5 text-white"></i>
                  </a>
                  <a href="{{ route('classitem.show' , 'detail') }}" class="btn table-btn-sm btn-dark">
                  <i class="mdi mdi-dots-vertical h4"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card" style="height: 100%">
            <div class="card-body position-relative">
                <p class="  fs-4 mb-2 text-center">Class Filter</p>
                <form action="">
                  <div class=" mb-3">
                    <label for="">Course</label>
                    <select class="select2  form-select shadow-none" style="width: 100%; height:36px;">
                      <option>Select Course</option>
                      <option value="CA">California</option>
                      <option value="NV">Nevada</option>
                      <option value="OR">Oregon</option>
                      <option value="WA">Washington</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="">Student</label>
                    <select class="select2  form-select shadow-none">
                      <option>Select Class</option>
                      <option value="CA">California</option>
                      <option value="NV">Nevada</option>
                      <option value="OR">Oregon</option>
                      <option value="WA">Washington</option>
                    </select>
                  </div>
                  <div class="d-flex justify-content-center">
                    <div class="position-absolute filterbtn">
                      <button class="btn btn-secondary me-2" type="submit">Cancel</button>
                      <button class="btn btn-primary " type="submit">Submit</button>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection