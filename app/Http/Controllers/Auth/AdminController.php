<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Repositories\UserRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\ProductRepository;
use App\Repositories\AdvertisementRepository;
use App\Repositories\ServiceRepository;
use Gate;

class AdminController extends Controller
{

    use AuthenticatesUsers;

    protected $user;

    public function  __construct(UserRepository $user, PropertyRepository $property, ProductRepository $product, ServiceRepository $service,AdvertisementRepository $ads)
    {
         $this->user = $user;
         $this->property = $property;
         $this->product = $product;
         $this->service = $service;
         $this->ads = $ads;
    }

    public function showLoginForm()
    {
        return view('auth.admin');
    }

    public function dashboard()
    {   
        if(Gate::allows('isUser')){
            abort(404,"");
        }
        $data['users'] = $this->user->all(); 
        $data['property'] = $this->property->all();
        $data['product'] = $this->product->all();
        $data['service'] = $this->service->all();
        $data['ads'] = $this->ads->all();
        return view('layouts.backend.dashboard', compact('data'));
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email:users',
            'password' => 'required',
        ]);
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password])
        ){
           return redirect('admin/dashboard')->with('success','Login Successfully');
        }
        Session::flash('warning','Invalid Email address or Password');
        return redirect('/admin/login');
    }

    public function logout(Request $request){
        Auth::logout();
        Session::flush();
        return redirect('admin/login')->with('success','Logout Successfully');
    }
}
