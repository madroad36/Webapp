<?php


namespace App\Http\ViewComposers\Frontend;

use App\Repositories\UserTypeRepository;
use Illuminate\View\View;

class RegisterComposer {


    protected $userType;


    public  function __construct(UserTypeRepository $userType)
    {
        $this->userType = $userType;
    }


    public function compose(View $view){
        $userTypes = $this->userType->orderBy('created_at','desc')->where('name','!=','admin')->get();
        $view->withUserTypes($userTypes);
    }
}