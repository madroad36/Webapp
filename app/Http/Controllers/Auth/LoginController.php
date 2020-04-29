<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Cache;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home'; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        // dd('hello');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])
    ){
            if(Auth::check()) {
                if (Auth::user()->backend == 1) {
                    $user = Auth::user();
                    session(['user_id' => $user->id]);
                    session(['user_name' => $user->name]);
                    session(['user_email' => $user->email]);

                    self::afterlogin($user);
                    return redirect('/auth/home')->with('success', 'Successfully Login');
                } else {
                    if(!empty($request->url)){

                        return redirect($request->url);
                    }
                    return redirect('/view/profile/')->with('success', 'Successfully login');
                }
            }
            return redirect()->route('/login');

        }
        return redirect('/login')->with('error', 'Invalid Email address or Password');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        Session::flush();
        $request->session()->regenerate();
        Session::flash('succ_message', 'Logged out Successfully');
        Cache::flush();
        $this->performLogout($request);
        return redirect('/')->with('success','Logout Successfully');
    }

    public function afterlogin($request)
    {
        $roles = collect();
        $permissions = collect();

        foreach($request->roles as $role){
            $permissions->push($role->permission);

            $roles->push($role->id);
        }

        $access_permissions =[];


        foreach($permissions->flatten(1)  as $index=>$permission){

            $access_permissions [] = $permission->slug;
        }
        $access_permissions = array_unique($access_permissions);
        Session()->put('access_permissions',$access_permissions);
        Session()->put('roles', $roles->toArray());
        return true;
    }
}
