<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\TechnicianRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TechnicianController extends Controller
{
    protected $technician;
    
    public function __construct(TechnicianRepository $technician)
    {
        $this->technician = $technician;
    }
    public function index(){
        return view('layouts.backend.technician.index');
    }
    public function changeStatus(Request $request)
    {
        $technician = $this->technician->find($request->get('id'));
        if ($technician->is_active == 0) {
            $status = '1';
            $message = 'technician with name "' . $technician->user->name . '" is active.';
        } else {
            $status = '0';
            $message = 'technician with name "' . $technician->user->name . '" is unactive.';
        }

        $this->technician->changeStatus($technician->id, $status);
        $this->technician->update($technician->id, array('is_active' => $status));
        $updated = $this->technician->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function getdata(){

        $technicians = $this->technician->orderBy('created_at','desc')->get();
        return \DataTables::of($technicians)

            ->addColumn('name',function($technicians){
                return $technicians->user->name;
            })
            ->addColumn('contact',function($technicians){
                return $technicians->user->contact;
            })
            ->addColumn('category',function($technicians){
                return $technicians->category->name;
            })
            ->addColumn('citizen',function($technicians) {

                return '<img style="width:100px; height:100px" src="' . asset('storage/' . $technicians->citizen) . '">';
            })
            ->addColumn('status', function ($technicians) {
                if($technicians->is_active == '1')
                    return  '<a href="#"  data-type="'.$technicians->id.'" id="change-status" class="btn btn-xs btn-success published"  title="service"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($technicians->is_active == '0')   return  '<a href="#"  data-type="'.$technicians->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="service"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


            })
            ->removeColumn('id')
            ->rawColumns(['name','status','contact','citizen','category'])
            ->addIndexColumn()
            ->make(true);
    }
}
