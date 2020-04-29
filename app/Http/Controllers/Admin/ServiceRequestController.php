<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ServiceOrderRepository;
use App\Repositories\TechnicianRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ServiecRequestRepository;
use Mail;
use App\Mail\ServiceAssignTechnician;
use App\Repositories\SettingRepository;
use Gate;

class ServiceRequestController extends Controller
{
    protected $servicerequest,$serviceOrder, $technician, $setting;

    public function __construct(ServiecRequestRepository $serviceRequest, 
    ServiceOrderRepository $serviceOrder,TechnicianRepository $technician,
    SettingRepository $setting)      
    {
        $this->servicerequest = $serviceRequest;
        $this->serviceOrder = $serviceOrder;
        $this->technician = $technician;
        $this->setting = $setting;

    }

    public function index()
    {
        return view('layouts.backend.servicerequest.view');
    }

    public function getdata(){

        $services = $this->serviceOrder->orderBy('updated_at','desc')->get();

        return \DataTables::of($services)
            ->addColumn('action', function ($services) {
                return ' <a href="'.asset("admin/servicerequest/show/$services->id").'"  id="view-service" class="btn btn-xs btn-success btn-icon btn-rounded "  title="View-Service"
                                   data-toggle="tooltip" data-target="#technician" ><i class="fa fa-eye" aria-hidden="true"></i></a>
            
                                 <a href="#" data-id="'.$services->id.'" data-type="'.$services->service->service->category_id.'" id="assign-technician" class="btn btn-xs btn-warning btn-icon btn-rounded "  title="Assign-Technician"
                                   data-toggle="modal" data-target="#technician" ><i class="fa fa-plus" aria-hidden="true"></i></a>
                                  ';

            })
            ->addColumn('title',function($services){

                return  $services->service->service->title;
            })
//            ->addColumn('category',function($services){
//
//                return  $services->service->category->name;
//            })
//            ->addColumn('subcategory',function($services){
//                return  $services->service->subcategory->title;
//            })
//
            ->addColumn('order_by',function($services){

                return  $services->service->owner->name;
            })
            ->addColumn('technician',function($services){

                if(empty($services->technician_id)){
                    return '<strong>Not Assign</strong>';
                }
                return  $services->technician->name;
            })

            ->addColumn('status', function ($services) {
                if($services->is_active == '1')
                    return  '<a href="#"  value="is_active" data-type="'.$services->id.'" class="btn btn-xs btn-success published checkout"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($services->is_active == '0')   return  '<a href="#"  value="is_active" data-type="'.$services->id.'"  class="btn btn-xs btn-success unpublished checkout" title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


            })
//            ->addColumn('paid', function ($services) {
//                if($services->paid == '1')
//                    return  '<a href="#"  value="paid" data-type="'.$services->id.'" id="change-status" class="btn btn-xs btn-success published checkout"  title="change-status"
//                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';
//
//                if($services->paid == '0')   return  '<a href="#"  value="paid" data-type="'.$services->id.'"  class="btn btn-xs btn-success unpublished checkout" title="change-status"
//                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';
//
//
//            })
            ->removeColumn('id')
            ->rawColumns(['action','order_by','title','status','technician','order_by'])
            ->addIndexColumn()
            ->make(true);
    }
    public function changeStatus(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $service = $this->serviceOrder->find($request->get('id'));

        if ($service->is_active == 0) {
            $status = '1';
            $message = 'service with title "' . $service->service->title . '" is active.';
        } else {
            $status = '0';
            $message = 'service with title "' . $service->service->title . '" is deactive.';
        }

        $this->serviceOrder->changeStatus($service->id, $status);
        $this->serviceOrder->update($service->id, array('is_active' => $status));
        $updated = $this->serviceOrder->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'service' => $updated], 200);
    }

    public function assignTechnician(Request $request)
    {

        if(!Gate::allows('isAdmin')){
            return redirect()->back()->with('warning','Unauthorized.');
        }
            
        $service = $this->serviceOrder->findorfail($request->id);
        $technician = $this->technician->where('technician_id',$request->technician_id)->first();
 

        if($this->serviceOrder->update($service->id,['technician_id'=>$technician->technician_id])){
            $services = $this->serviceOrder->find($request->id);
            $companyemail = $this->setting->where('slug', 'to-email')->first();
            $companyname = $this->setting->where('title', 'Company Name')->first();
            Mail::to($technician->user->email)->send(new ServiceAssignTechnician( $services ,$technician,$companyname,$companyemail,));

            return redirect('admin/servicerequest')->with('successs','Technician added successfully');
        }
        return redirect('admin/servicerequest')->with('errors','Something went wrong');
    }

    public function show($id)
    {


        $order = $this->serviceOrder->find($id);

        $servicerequest = $this->servicerequest->where('service_id',$order->serviceRequest->service_id)->first();


        return view('layouts.backend.servicerequest.show')->withServicerequest($servicerequest)->withOrder($order);
    }
}
