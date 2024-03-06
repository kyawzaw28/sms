<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Http\Requests\StoreLecturerRequest;
use App\Http\Requests\UpdateLecturerRequest;
use App\Models\User;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lecturers = User::where('role_id' , 2)->paginate(15);

        if ($request->ajax()) {
            $view = view('setting.lecturer.data', compact('lecturers'))->render();

            return response()->json(['html' => $view]);
        }

        return view('setting.lecturer.index' , compact('lecturers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLecturerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLecturerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function show(Lecturer $lecturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function edit(Lecturer $lecturer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLecturerRequest  $request
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLecturerRequest $request, Lecturer $lecturer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lecturer $lecturer)
    {
        //
    }

    public function lecturersearch(Request $request)
    {
        $output="";
        // $lecturerdata = User::where('role_id' , 2)->paginate(15);

        if($request->has('lecturersearch')){
            $lecturerdata = User::where('name', 'like', '%' . $request->lecturersearch . '%')
           ->orWhere('email','like','%'.$request->lecturersearch.'%')
            // ->orWhereHas('role', function ($query) use ($request) {
            //     $query->where('name', 'like', '%' . $request->usersearch . '%');
            // })
            ->paginate(15)->withQueryString();
        } else if($request->has('userrolefilter')){
            $lecturerdata = User::where('role_id',$request->userrolefilter)->paginate(15)->withQueryString();
        }

        if(count($lecturerdata)>0){
            foreach($lecturerdata as $user)
            {
        
                $output .= '
                <tr>
                <td class="align-middle">
    <p class="d-none d-md-block">' . $user->name . '</p>
    <div class="d-block d-md-none">
        <p>' . $user->name . '</p>
    </div>
</td>
<td class="align-middle">
    <p class="d-none d-md-block">' . $user->email . '</p>
    <div class="d-block d-md-none">
        <p>' . $user->email . '</p>
    </div>
</td>
<td class="text-end">
    <div class="d-none d-md-block">
        <a href="' . route('user.edit', 1) . '" class="btn table-btn-sm btn-primary">
            <i class="mdi mdi-pencil h5"></i>
        </a>
        <form action="' . route('user.destroy', $user->id) . '" method="post" class="d-inline">
        <input type="hidden" name="_token" value="' . csrf_token() . '">
        <input type="hidden" name="_method" value="delete">
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
                    <a href="' . route('user.edit', 1) . '" class="btn table-btn-sm btn-outline-primary border border-0">
                        <i class="mdi mdi-pencil h5"></i>
                    </a>
                </li>
                <li>
                    <form action="' . route('user.destroy', $user->id) . '" method="post" class="d-inline">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="delete">
                        <a href="" class="btn table-btn-sm btn-outline-danger border border-0 alertbox">
                            <i class="mdi mdi-delete h5 "></i>
                        </a>
                    </form>
                </li>                                               
            </div>
        </ul>
    </div>
</td>
                </tr>';
        }
        } 
        else 
        {
            $output .= '<tr>
            <td colspan="3" class="text-center text-danger">Data not found</td>
        </tr>';
        }
        
        
        
        // return response($output);
        // if ($request->ajax()) {
        //     $view = view('classitem.data', compact('searchdata'))->render();
        
        //     $data =  response()->json(['html' => $view]);
        // }
        
        return response()->json($output);
    }
}
