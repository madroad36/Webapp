<?php

namespace App\Http\Controllers\Auth;

use App\Mail\ForgetPassword;
use App\Repositories\AdminPasswordRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


class AdminPasswordController extends Controller
{


    protected $password , $user;

    public function __construct(AdminPasswordRepository $password,UserRepository $user){

        $this->password = $password;
        $this->user = $user;
    }

    public function passwordreset()
    {
        return view('auth.passwords.email');
    }

    public function sendlink(Request $request)
    {
        $user = $this->user->where('email', $request->email)->get();
        if(count($user)>0)
        {
            $data = $request->except('_token');
            $data['token'] = str_random(60);
            $data['created_at']= Carbon::now();
            $token = $this->password->create($data);
            Mail::to($token->email)->send(new ForgetPassword($token));
            return redirect()->back()->with('success','please check your email');
        }
        else
        {
            return redirect()->back()->with('error','No Match Found');
        }
    }

    public  function getlink($token)
    {
        return view('auth.passwords.reset')->withToken($token);
    }

    public function storepassword(Request $request)
    {
        $token = $this->password->where('token',$request->token)->first();
        $user = $this->user->where('email',$request->email)->first();
        if(!empty($token))
        {
            $this->user->update($user->id,['password'=>bcrypt($request->password)]);
            return redirect('admin/login')->with('success','Password has been changed successfully');
        }
        else{
            return redirect()->back()->with('errors','token has been expired');
        }

    }


}
