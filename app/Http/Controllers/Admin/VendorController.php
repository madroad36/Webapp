<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\VendorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
    protected  $vendor;
    
    public  function __construct(VendorRepository $vendor)
    {
        $this->vendor = $vendor;
    }
    public function index(){
        return view('layouts.backend.vendor.index');
    }
    public function changeStatus(Request $request)
    {
        $vendor = $this->vendor->find($request->get('id'));
        if ($vendor->is_active == 0) {
            $status = '1';
            $message = 'vendor with name "' . $vendor->user->name . '" is active.';
        } else {
            $status = '0';
            $message = 'vendor with name "' . $vendor->user->name . '" is unactive.';
        }

        $this->vendor->changeStatus($vendor->id, $status);
        $this->vendor->update($vendor->id, array('is_active' => $status));
        $updated = $this->vendor->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function getdata(){

        $vendors = $this->vendor->orderBy('created_at','desc')->get();
        return \DataTables::of($vendors)

            ->addColumn('contact',function($vendors){
                return $vendors->user->contact;
            })
            ->addColumn('pan_vat_image',function($vendors) {

                return '<img style="width:100px; height:100px" src="' . asset('storage/' . $vendors->pan_vat_image) . '">';
            })
            ->addColumn('status', function ($vendors) {
                if($vendors->is_active == '1')
                    return  '<a href="#"  data-type="'.$vendors->id.'" id="change-status" class="btn btn-xs btn-success published"  title="service"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($vendors->is_active == '0')   return  '<a href="#"  data-type="'.$vendors->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="service"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


            })
            ->removeColumn('id')
            ->rawColumns(['name','status','contact','pan_vat_image'])
            ->addIndexColumn()
            ->make(true);
    }
}
