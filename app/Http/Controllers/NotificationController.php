<?php

namespace App\Http\Controllers;

use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notification;

    public function __construct(NotificationRepository $notification)
    {
        $this->notification = $notification;
    }

    public function index(){

        $count = $this->notification->where('is_active','0')->where('receiver_id',Auth::user()->id)->count();

        return response()->json(['success'=>true,'count'=>$count],200);
    }
}
