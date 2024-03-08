<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
    .custom-border-bottom {
      /* display: flex; */
      width: 95%;
      border-bottom: 3px solid gray;
      margin: 0 auto;
    }

    .footer{
      height: 200px;
    }
    .w-65{
      width: 65%;
    }
    .w-35{
      width: 35%;
    }
    </style>
</head>
<body>
  <script>
    window.print();
  </script>

{{-- First --}}
  <div class="p-5 bg-primary">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-6 d-flex">
        <b class="logo-icon">
          <!-- <img src="http://localhost:8000/admin/assets/images/[removal.ai]_535d621a-bef4-4b84-a129-576bf5f0ac1f-o-technique200.png" alt="homepage" class="light-logo"> -->
          <h3 class="text-white text-center" >Invoice</h3>
        </b>
      </div>
      <div class="col-6 flex-column justify-content-end text-white ">
          <h3 class="d-flex justify-content-end">O technique</h3>

          <div class="d-flex justify-content-end py-5">
            <h5 class="text-end w-75">
              No(313),7th Floor,Corner of Banyardala Road & 145 Street, Ahyoegone Qtr,Tamwe Township
            </h5>
          </div>
          <h5 class="d-flex justify-content-end">09 40934 9911</h5>


      </div>
    </div>
  </div>
{{-- First --}}

{{-- Second --}}
  <div class=" d-flex p-5">
    {{-- left --}}
    <div class="col-7">

      <div class="row p-2">
        <div class="col-4">Student ID</div>
        <div class="col-1">-</div>
        <div class="col-7">SID-{{$student->id}}</div>
        {{-- <div class="col-7">SID - 0007</div> --}}
      </div>
      <div class="row p-2">
        <div class="col-4">Name</div>
        <div class="col-1">-</div>
        <div class="col-7">{{$student->name}}</div>
        {{-- <div class="col-7">Toot Pi</div> --}}
      </div>
      <div class="row p-2">
        <div class="col-4">Class Name</div>
        <div class="col-1">-</div>
        <div class="col-7"><b>{{$classitem->course->name}}({{$classitem->name}})</b></div>
        {{-- <div class="col-7"><b>Laravel</b></div> --}}
      </div>     
    </div>
    {{-- left --}}

    {{-- right --}}
    <div class="col-5 d-flex flex-column ">
      <div class="row p-2 ">
        <div class="col-8 text-end">Invoice No</div>
        <div class="col-1 text-end">-</div>
        <div class="col-3 text-end">InvID_{{$payment->id}}</div>
        {{-- <div class="col-3 text-end">InvID_123</div> --}}

      </div>
      <div class="row p-2 ">
        <div class="col-8 text-end">Invoice Date</div>
        <div class="col-1 text-end">-</div>
        <div class="col-3 text-end">{{$payment->updated_at->format('d/m/Y')}}</div>
        {{-- <div class="col-3 text-end">23.2.2700</div> --}}
      </div>
     
      <div class="row p-2 ">
        <div class="col-8 text-end">Class Price</div>
        <div class="col-1 text-end">-</div>
        <div class="col-3 text-end"><b>{{number_format(floatval($classitem->price))}}</b></div>
        {{-- <div class="col-3 text-end"><b>20000</b></div> --}}
      </div>
    </div>
    {{-- right --}}
  </div>
{{-- Second --}}

{{-- Third --}}
<div class="d-flex custom-border-bottom">
  

</div>
{{-- Third --}}

{{-- Fourth --}}
<div class="p-4">
  <table class="table">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Date</th>
        <th scope="col">Current Paid</th>
        <th scope="col">Total Paid</th>
        <th scope="col">Due Amount</th>
        <th scope="col">Type</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row"></th>
        <td>{{$payment->created_at->format('d/m/Y')}}</td>
        {{-- <td>22.22.22</td> --}}
        <td>{{number_format(floatval($current_paid))}}</td>
        {{-- <td>100000</td> --}}
        <td>{{number_format(floatval($payment->fees - $payment->due_amount))}}</td>
        {{-- <td>400000</td> --}}
        <td>{{number_format(floatval($payment->due_amount))}}</td>
        {{-- <td>500000</td> --}}
        <td>{{($payment->payment_method)}}</td>
        {{-- <td>Bank Transfer</td> --}}
 

      </tr>
    </tbody>
  </table>
</div>
{{-- Fouth --}}



{{-- Fourth --}}

{{-- Five --}}
<div class="d-flex footer">
  <div class="w-100 bg-primary p-5">
    <h5 class="text-white"></h5>
  </div>

    
  </div>
</div>
{{-- Five --}}

</body>
</html>