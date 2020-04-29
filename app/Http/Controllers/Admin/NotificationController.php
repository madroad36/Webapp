<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\NotificationRepository;
use Auth;

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
    public function changeStatus(Request $request){
        $notification = $this->notification->find($request->get('id'));
        if ($notification->is_active == 0) {
            $status = '1';
            $this->notification->changeStatus($notification->id, $status);
            $this->notification->update($notification->id, array('is_active' => $status));
            $updated = $this->notification->find($request->get('id'));
        }

        return response()->json(['status' => 'ok'], 200);

    }

}
