<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\PwdResetRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userdata = User::orderBy('id', 'desc')->paginate(15);
        $roles = Role::all();

        if($request->has('usersearch')){
            $userdata = User::where('name', 'like', '%' . $request->usersearch . '%')
            ->orWhere('email','like','%'.$request->usersearch.'%')
            ->orWhereHas('role', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->usersearch . '%');
            })
            ->paginate(15)->withQueryString();
        } else if($request->has('userrolefilter')){
            $userdata = User::where('role_id',$request->userrolefilter)->paginate(15)->withQueryString();
        }

        if ($request->ajax()) {
            $view = view('user.data', compact('userdata'))->render();

            return response()->json(['html' => $view]);
        }

        return view('user.index', compact(['userdata','roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roleoptions = Role::all();
        return view('user.create', compact('roleoptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
        ]);

        return redirect()->route('user.index')->with('message','Data Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
       
        return view('user.show' , compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roleoptions = Role::all();
        return view('user.edit', compact(['user', 'roleoptions']));
    }
// pyin
    public function changeUsername(User $user){
        if(Auth::user()->id == $user->id){
            return view('changeauth.usernamechange',compact('user'));
        }else{
            return abort(404);
        }   
    }
    public function updateUserName(Request $request , User $user){
        // return $user;
        $request->validate([
            'name'=>'required'
        ]);

        $user->name = $request->name;
        $user->update();
        return redirect()->route('user.show' , $user->id )->with('message','Data updated Successfully');
        
    }

    public function changeUserEmail(User $user){

        if(Auth::user()->id == $user->id){
            return view('changeauth.useremailchange',compact('user'));
        }else{
            return abort(404);
        }   
    }
    public function updateUserEmail(Request $request , User $user){
        $request->validate([
            'email'=>'required'
        ]);


        $user->email = $request->email;
        $user->update();
        return redirect()->route('user.show' , $user->id )->with('message','Data updated Successfully');
        
    }
    public function changeUserPassword(Request $request, User $user){
       
        if(Auth::user()->id == $user->id){
            return view('changeauth.userpasswordchange',compact('user'));
        }else{
            return abort(404);
        }   
    }
    public function updateUserPassword(Request $request, User $user){

        $request->validate([
            'current_password'=>'required',
            'new_password'=>'required|confirmed'
        ]) ;
        
        if(!Hash::check($request->current_password,$user->password)){
            return back()->with("error","Old password doesn't match");
        }

        $user->password = Hash::make($request->new_password);
        $user->update();
        return back()->with("status","Password change successfully");
        
    }
// 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // User::update([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'role_id' => $request->role,
        // ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->update();

        return redirect()->back()->with('message','Data updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('del', 'User is deleted');
    }

    public function login(LoginUserRequest $request)
    {
        $credentials=$request->only('email','password');
        if(Auth::attempt($credentials)){
            return redirect()->intended(route('schdeuler.index'));
        }

        return redirect()->route('auth.login')->with('err','Username or password incorrect');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('auth.login');
    }
    public function forgetpwdview()
    {
        return view('auth.reset-password');
    }

    public function forgetpwd(Request $request)
    {
        $request->validate([
            'email' => "required|email|exists:users",
        ]);
        $token = Str::random(64);
        $email = $request->email;

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send("auth.forget-password",["token" => $token], function($message) use ($request){
            $message->to($request->email);
            $message->Subject("Reset Password");
        });

        return redirect()->back()->with('message',"Please check your inbox to reset password");
    }

    public function resetpwd($token)
    {
        return view("auth.new-pwd", compact('token'));
    }

    public function postresetpwd(PwdResetRequest $request)
    {
        $updatePassword = DB::table('password_resets')
        ->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();

        if(!$updatePassword){
            return redirect()->to(route('user.resetpwd'))->with("err","Invalid");
        }

        User::where("email", $request->email)
            ->update(["password"=>Hash::make($request->password)]);

        DB::table("password_resets")->where(["email" => $request->email])->delete();

        return redirect()->to(route("user.login"))->with('message',"Password reset success");
    }

    public function adminsearch(Request $request){
        $output="";
        $userdata = User::orderBy('id', 'desc')->paginate(11);

        if($request->has('usersearch')){
            $userdata = User::where('name', 'like', '%' . $request->usersearch . '%')
            ->orWhere('email','like','%'.$request->usersearch.'%')
            ->orWhereHas('role', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->usersearch . '%');
            })
            ->paginate(15)->withQueryString();
        } else if($request->has('userrolefilter')){
            $userdata = User::where('role_id',$request->userrolefilter)->paginate(15)->withQueryString();
        }

        if(count($userdata)>0){
            foreach($userdata as $user)
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
