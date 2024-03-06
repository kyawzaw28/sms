@forelse ($latestPayments as $payment)

<tr onclick="showPayments(event, {{ $payment->classitem_id }}, {{ $payment->student_id }})" class="history" data-className="{{$payment->classitem->name}}" data-studentName="{{$payment->student->name}}" data-bs-toggle="modal" data-bs-target="#exampleModal">



    {{-- Mobile View --}}
    <td class="d-table-cell d-lg-none text-nowrap align-middle">
        {{-- <p>01-01-2023</p> --}}
        <p>{{$payment->created_at->format('Y-m-d')}}</p>
        <p> {{$payment->student->name}}</p>
    </td>
    <td class="fees d-none">
         {{ $payment->fees }}
    </td>
    <td class="paid d-none">
        {{$payment->due_amount}}
   </td>

    {{-- Laptop View --}}
    <td class="d-none d-lg-table-cell align-middle">{{$payment->created_at->format('Y-m-d')}}</td>
    <td class="align-middle">{{Str::limit($payment->classitem->name, 20)}} </td>
    <td class="d-none d-lg-table-cell align-middle">
        {{Str::limit($payment->classitem->course->name, 15)}}</td>
    <td class="d-none d-lg-table-cell align-middle">
        {{Str::limit($payment->student->name, 15)}}</td>
    <td class=" align-middle ">{{number_format(floatval($payment->fees))}}</td>
    <td class=" align-middle ">{{number_format(floatval($payment->due_amount))}}</td>
    <td class=" align-middle">

        @if ($payment->payment_type=="paid")
            <div class="text-success fw-bold pay-status d-flex justify-content-center align-items-center rounded">
                paid
            </div>
        @else
            <div class="text-danger fw-bold pay-status d-flex justify-content-center align-items-center rounded">
                unpaid
            </div>
        @endif

    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center text-back">Data is Empty</td>
  </tr>
@endforelse