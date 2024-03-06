@forelse($lecturers as $user)
<tr>
    <td class="align-middle">
        <p class="d-none d-md-block">{{$user->name}}</p>
        <div class="d-block d-md-none">
            <p>{{$user->name}}</p>
        </div>
    </td>
    <td class="align-middle">
        <p class="d-none d-md-block">{{$user->email}}</p>
        <div class="d-block d-md-none">
            <p>{{$user->email}}</p>
        </div>
    </td>

    <td class="text-end">
        <div class="d-none d-md-block">
            <a href="{{ route('user.edit', 1) }}" class="btn table-btn-sm btn-primary">
                <i class="mdi mdi-pencil h5"></i>
            </a>
            {{-- <a href="" class="btn table-btn-sm btn-danger">
                <i class="mdi mdi-delete h5 text-white"></i>
            </a> --}}
            <form action="{{route('user.destroy', $user->id)}}" method="post" class="d-inline">
                @csrf
                <input name="_method" type="hidden" value="delete">
                <button type="submit" class="btn table-btn-sm btn-danger del-btn alertbox">
                    <i class="mdi mdi-delete h5 text-white"></i>
                </button>
            </form>
        </div>
        <div class="btn-group dropup d-block d-md-none control-btn">
            <button type="button" class="btn table-btn-sm btn-outline-dark border border-0 dropdown-toggle"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-dots-vertical h4"></i>
            </button>

            <ul class="dropdown-menu mb-1">
                <div class="d-flex justify-content-around">
                    <li>
                        <a href="{{ route('user.edit', 1) }}" class="btn table-btn-sm btn-outline-primary border border-0">
                            <i class="mdi mdi-pencil h5"></i>
                        </a>
                    </li>
                    <li>
                        {{-- <a href="" class="btn table-btn-sm btn-outline-danger border border-0">
                            <i class="mdi mdi-delete h5 "></i>
                        </a> --}}
                        <form action="{{route('user.destroy', $user->id)}}" method="post" class="d-inline">
                            @csrf
                            <input name="_method" type="hidden" value="delete">
                            <a href="" class="btn table-btn-sm btn-outline-danger border border-0 alertbox">
                                <i class="mdi mdi-delete h5 "></i>
                            </a>
                        </form>
                    </li>                                               
                </div>
            </ul>
        </div>
    
        </td>
        </div>

</tr>
@empty
<tr>
  <td colspan="3" class="text-center">Data is Empty</td>
</tr>
@endforelse