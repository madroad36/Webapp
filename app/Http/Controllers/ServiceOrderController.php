<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceOrderRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\ServiecRequestRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceOrderController extends Controller
{
    protected $servicerequest, $service,$serviceOrder;

    public function __construct(ServiecRequestRepository $servicerequest,
                                ServiceRepository $service,
                                ServiceOrderRepository $serviceOrder
    )
    {
        $this->servicerequest = $servicerequest;
        $this->service = $service;
        $this->serviceOrder = $serviceOrder;
    }

    public function show($id){


        $servicerequest = $this->servicerequest->find($id);


        $orders = $this->serviceOrder->where('request_id',$servicerequest->id)->orderBy('created_at','desc')->get();
       

        return view('service.order')->withServicerequest($servicerequest)->withOrders($orders);
    }
    public function assign($id){
        
            
        $servicerequest = $this->serviceOrder->find($id);
       
        return view('service.assign')->withServicerequest($servicerequest);
    }

}
