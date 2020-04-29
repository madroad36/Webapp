<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\BrokerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrokerController extends Controller
{
    protected $broker;

    public function __construct(BrokerRepository $broker)
    {
        $this->broker=$broker;
    }
    public function index(){
        return view('layouts.backend.broker.index');
    }
    public function changeStatus(Request $request)
    {
        $broker = $this->broker->find($request->get('id'));
        if ($broker->is_active == 0) {
            $status = '1';
            $message = 'broker with name "' . $broker->user->name . '" is active.';
        } else {
            $status = '0';
            $message = 'broker with name "' . $broker->user->name . '" is unactive.';
        }

        $this->broker->changeStatus($broker->id, $status);
        $this->broker->update($broker->id, array('is_active' => $status));
        $updated = $this->broker->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function getdata(){

        $brokers = $this->broker->orderBy('created_at','desc')->get();
        return \DataTables::of($brokers)
            ->addColumn('name',function($brokers){
            return $brokers->user->name;
        })
            ->addColumn('contact',function($brokers){
                return $brokers->user->contact;
            })
            ->addColumn('citizen',function($brokers) {

                return '<img style="width:100px; height:100px" src="' . asset('storage/' . $brokers->citizen) . '">';
            })
                ->addColumn('status', function ($brokers) {
                if($brokers->is_active == '1')
                    return  '<a href="#"  data-type="'.$brokers->id.'" id="change-status" class="btn btn-xs btn-success published"  title="service"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($brokers->is_active == '0')   return  '<a href="#"  data-type="'.$brokers->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="service"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


            })
            ->removeColumn('id')
            ->rawColumns(['name','status','contact','citizen'])
            ->addIndexColumn()
            ->make(true);
    }
}
