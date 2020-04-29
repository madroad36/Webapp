<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Register\UserStoreRequest;
use App\Mail\AdminRegistration;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user, $setting;
    public function __construct(UserRepository $user, SettingRepository $setting)
    {
        $this->user = $user;
        $this->setting = $setting;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function index(){

        return view('auth.register');
    }
//    protected function validator(array $data)
//    {
//        return Validator::make($data, [
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
//            'password' => 'required|string|min:6|confirmed',
//        ]);
//    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function store(UserStoreRequest $request)
    {

        $setting = $this->setting->where('slug','to-email')->first();
        $user = $this->user->latestFirst();
        $data = $request->except('_token');
        $data['password'] = bcrypt($request->password);
        $data['batch_number'] = $this->batch($user);
        $data['is_active'] =(isset($request['is_active'])) ? 1 : 0;
        if($this->user->create($data)){
            $user = $this->user->latestFirst();
            Mail::to($setting->value)->send(new AdminRegistration($data,$setting,$user));
            return view('auth.login')->with('login-success', 'Register Successfully ');
        }
        return redirect()->back()->with('errors', 'Register Successfully ');

    }

    public function batch($user){
        if (empty($user->batch_number)) {
            return  'USR-01';
        } else {
            return  ++$user->batch_number;
        }
    }
}
