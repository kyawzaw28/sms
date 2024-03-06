@forelse($classitem as $classdata)
@can('view', $classdata)
<tr>
    <td class="align-middle">
        <p class="d-none d-md-block text-cut">{{Str::limit($classdata->name,20)}}</p>
        <div class="d-block d-md-none">
            <p>{{$classdata->name}} </p>
            <p class=" text-black-50 text-cut">{{Str::limit($classdata->users->pluck('name')->implode(', '),20)}} </p>
        </div>
    </td>
    <td class="align-middle">{{Str::limit($classdata->course->name,20)}}</td>
    <td class="d-none d-md-table-cell align-middle" >{{Str::limit($classdata->users->pluck('name')->implode(', '),20)}} </td>
    @can('viewAny', $classdata)
    @php $isUnpaid = false; @endphp
    @foreach($classdata->payments as $payment)
    @if($payment->payment_type === 'unpaid')
    @php $isUnpaid = true; @endphp @break
    @endif
    @endforeach
    @if($isUnpaid)
    <td class="">
        <div
            class="text-danger fw-bold pay-status d-flex justify-content-start align-items-center rounded">
            unpaid
        </div>
    </td>
    @else
    <td class="">
        <div class="text-success fw-bold pay-status d-flex justify-content-start align-items-center rounded">
            paid
        </div>
    </td>
    @endif
    <td class="d-none d-md-table-cell align-middle text-center pe-1">
        <a href="{{ route('classitem.classPayment' , $classdata->id ) }}" class="btn table-btn-sm btn-primary">
            <i class="mdi mdi-credit-card-multiple h5"></i>
        </a>
    </td>
    @endcan
    <td class="text-end align-middle text-nowrap">
        <div class="d-none d-md-block control-btns">
            @can('viewAny', $classdata)
            <a href="{{ route('classitem.edit', $classdata) }}" class="btn table-btn-sm btn-primary">
                <i class="mdi mdi-pencil h5"></i>
            </a>
            @endcan
            <a href="{{ route('classitem.show', $classdata) }}"
                class="btn table-btn-sm btn-primary">
                <i class="mdi mdi-information-outline h5"></i>
            </a>
            {{-- <a href="" class="btn table-btn-sm btn-danger">
                <i class="mdi mdi-delete h5 text-white"></i>
            </a> --}}

            @can('viewAny',$classdata)
            <form action="{{route('classitem.destroy', $classdata->id)}}" method="post" class="d-inline">
            @csrf
            <input name="_method" type="hidden" value="delete">
            <button type="submit" class="btn table-btn-sm btn-danger del-btn alertbox">
                <i class="mdi mdi-delete h5 text-white"></i>
            </button>
            </form>
            @endcan

        </div>

        <div class="btn-group dropup d-block d-md-none control-btn">
            <button type="button" class="btn table-btn-sm btn-outline-dark border border-0 dropdown-toggle"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-dots-vertical h4"></i>
            </button>

            <ul class="dropdown-menu mb-1">
                <div class="d-flex justify-content-around">
                    <li>
                        <a href="{{ route('classitem.edit', $classdata) }}" class="btn table-btn-sm btn-outline-primary border border-0">
                            <i class="mdi mdi-pencil h5"></i>
                        </a>
                    </li>
                    <li>
                        {{-- <a href="" class="btn table-btn-sm btn-outline-danger border border-0">
                            <i class="mdi mdi-delete h5 "></i>
                        </a> --}}
                        <form action="{{route('classitem.destroy', $classdata->id)}}" method="post" class="d-inline">
                            @csrf
                            <input name="_method" type="hidden" value="delete">
                        <a href="" class="btn table-btn-sm btn-outline-danger border border-0 alertbox">
                            <i class="mdi mdi-delete h5 "></i>
                        </a>
                            </form>
                    </li>
                    <li>
                        <a href="{{ route('classitem.show', 'detail') }}" class="btn table-btn-sm btn-outline-secondary border border-0">
                            <i class="mdi mdi-information-outline h4"></i>
                        </a>
                    </li>
                </div>
            </ul>
        </div>
    </td>
</tr>
@endcan
@empty
<tr>
    <td colspan="6" class="text-center ">Data is Empty</td>
  </tr>
@endforelse


