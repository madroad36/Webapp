<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceOrderRequest\OrderStoreRequest;
use App\Models\Cart;
use App\Repositories\LocationRepository;
use App\Repositories\PlaceRepository;
use App\Repositories\ServiceOrderRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\ServiecRequestRepository;
use App\Repositories\WorkingHourRepository;
use App\Repositories\UserTypeRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\Service\ServiceOrder;
use DateTime;
use DateTimeZone;
use App\Events\Service\ServiceFinished;
use App\Repositories\SettingRepository;


class ServiceRequestController extends Controller
{


    protected $servicerequest, $service,$location,$address, $working, $serviceOrder, $userType,$setting;

    public function __construct(ServiecRequestRepository $servicerequest,
                                ServiceRepository $service,
                                LocationRepository $location,
                                PlaceRepository $address,
                                WorkingHourRepository $working,
                                ServiceOrderRepository $serviceOrder,
                                UserTypeRepository $userType,
                                SettingRepository $setting
    )
    {
        $this->servicerequest = $servicerequest;
        $this->service = $service;
        $this->location = $location;
        $this->address = $address;
        $this->working = $working;
        $this->serviceOrder = $serviceOrder;
        $this->userType= $userType;
        $this->setting = $setting;
    }

    public function index(){

           
        $services = $this->servicerequest->where('order_by',Auth::user()->id)->orderBy('updated_at','desc')->paginate(10);
       
        $totalnumber = $this->servicerequest->where('id',$services['service_id'])->count();

        return view('service.view')->withServices($services);
    }


    public function store(Request $request,$id)
    {
            $service = $this->service->find($id);
            $data['order_by'] = Auth::user()->id;
            $data['service_id'] =  $service ->id;
             $servicerequest = $this->servicerequest->firstOrCreate($data);
             $serviceorder = $this->servicerequest->where('service_id',$service->id)->where('order_by',Auth::user()->id)->first();
            
             if(!empty($serviceorder)){
               
                 $this->servicerequest->update($serviceorder->id,['updated_at' => Carbon::now()]);
 
             }
             

                $orderDetails = Session::get('order_details');
                $order['request_id'] = $servicerequest->id;
                $order['date'] = $orderDetails['pereffered_date'];
                $order['description'] = $orderDetails['description'];
                if($request->location)
                {    
                $order['location'] = strtolower($request->location);
                }
                else
                {
                $order['location'] = strtolower($orderDetails['location']);
                }
                if($request->contact)
                {    
                    $order['contact'] = strtolower($request->contact);
                }
                else
                {
                    $order['contact'] = strtolower($orderDetails['contact']);
                }
                if($this->serviceOrder->create($order)){
                    Session::forget('order_details');
                    \Cache::forget('order_details');
                    $serviceOrders = $this->serviceOrder->latestFirst();
                    $usertype = $this->userType->where('name','admin')->first();
                    $serviceOrder['receiver_id'] =$usertype->user->id;
                    $serviceOrder['message']=$service->title.' has been order';
                    event (new ServiceOrder($serviceOrder));
                    if($request->ajax()) {
                        return response()->json(['login'=>true,'contact'=>$serviceOrders->contact],200);
                    }

                    return redirect()->to('/servicerequest')->with('service-order','Order has been place we will contact you soon ');
                }



        return response()->json(['success'=>false],422);


    }

     public function details(OrderStoreRequest $request)
    {
        $order = $request->session()->put('order_details',[
            'location'=>$request->location,
            'contact'=>$request->contact,
            'description'=>$request->description,
            'pereffered_date'=>$request->pereffered_date
        ]);
        \Cache::put('order_details',[
            'location'=>$request->location,
            'contact'=>$request->contact,
            'description'=>$request->description,
            'pereffered_date'=>$request->pereffered_date
        ]);
        if(!empty(Auth::user())){
            return redirect()->to('/service_request/store/'.$request->id)->with('success','Order Registered Successfully.');
        }
        return response()->json(['success'=>true],200)->with('error','Please Login.');
    }

    public function destroy($id)
    {
        $service = $this->servicerequest->find($id);
        if($this->servicerequest->destroy($service->id)){

            return redirect('servicerequest/')->with('success', 'Order Has been Deleted Succcessfully');


        }
        return redirect('servicerequest/')->with('success', 'Order canot be Deleted Succcessfully');
    }

    public function assignService(){
        

        $services = $this->serviceOrder->where('technician_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(10);
        
        return view('profile.service.view')->withServices($services);
    }

    public function requestTime(Request $request){

        $service = $this->serviceOrder->find($request->id);

        $data  = Carbon::now()->format('g:i A');

        if($request->type =='start'){

            if(!empty($service->end) && !empty($service->duration)){

               $this->addwork($service);
                $time['start'] =$data;
                $time['count'] = null;
                $time['end'] = null;
                $time['duration'] = null;
                $this->serviceOrder->update($service->id, $time);
            }
                $this->serviceOrder->update($service->id, ['start'=> $data]);
                $order = $this->serviceOrder->find($request->id);
        }
        if($request->type =='end'){

            $this->serviceOrder->update($service->id, ['end' =>$data]);
            $service = $this->serviceOrder->find($request->id);

            $this->addwork($service);
            $time['start'] =null;
            $time['count'] = null;
            $time['end'] = null;
            $time['duration'] = null;
            $this->serviceOrder->update($service->id, $time);
            $order = $this->serviceOrder->find($request->id);
        }
        if($request->type =='pause'){

            $this->serviceOrder->update($service->id,['end'=> $data]);
            $order = $this->serviceOrder->find($request->id);
        }
        if($request->type =='finished'){
            $order = $this->serviceOrder->find($request->id);

            $sum = strtotime('00:00:00');
            $sum2=0;

            if($order->service->service->rate_type == 'per-day'){
                $value['duration'] = 'per-day';
            }else{
                foreach($order->WorkingHour as $key=>$task){
                    $sum1=strtotime($task->duration)-$sum;
                    $sum2 = $sum2+$sum1;
                }

                $value['duration']= date('H:i:s', $sum+$sum2);
            }
            $hms = explode(":", date('H:i:s', $sum+$sum2));
            if($order->service->service->rate_type == 'half-hour' ){
                $totaltime =  ($hms[0]*60) + ($hms[1]) + ($hms[2]/60);
                $value['amount'] =round($totaltime,3)/30*$order->service->service->rate;
            }else if($order->service->service->rate_type == 'hourly' ){
                $totaltime = $hms[0] + ($hms[1]/60) + ($hms[2]/3600);
                $value['amount'] =round($totaltime * $order->service->service->rate,2);
            }else {
                $value['amount']=$order->service->service->rate;
            }
            $value['is_active'] =1;

            $this->serviceOrder->update($service->id,$value);
            $order = $this->serviceOrder->find($request->id);

            $this->servicenotification($order);
        }
        $servicerequest = $this->serviceOrder->find($request->id);
       

        return view('service.time')->withServicerequest($servicerequest);

    }
    public function requesFinished(Request $request){
      
       
            $order = $this->serviceOrder->find($request->id);

            $value['duration'] = 'per-day';
            $value['amount'] = $order->service->service->rate;
            $value['is_active'] =1;
            $this->serviceOrder->update( $order->id,$value);
            $order = $this->serviceOrder->find($request->id);
             $this->servicenotification($order);
             $servicerequest =  $this->serviceOrder->find($request->id);
        
        

        return view('service.time')->withServicerequest($servicerequest);
    }

    public function count(Request $request){


        $data = Carbon::now()->format('H:i:s');

        $service = $this->serviceOrder->find($request->id);


        if(!empty($service->start) && empty($service->end)){
            $this->serviceOrder->update($service->id,['count'=> $data]);
            $service = $this->serviceOrder->find($request->id);

            $start = Carbon::parse($service->start);
            $end = Carbon::parse($service->count);
            $seconds = $end->diffInSeconds($start);
            $time =gmdate('H:i:s', $seconds);
            $this->serviceOrder->update($service->id,['duration'=> $time]);
            $service = $this->serviceOrder->find($request->id);

            return response()->json(['success'=>true,'type'=>'pause','pause'=>$service->duration]);
        }

        $service = $this->serviceOrder->find($request->id);


        return response()->json(['success'=>true,'type'=>'pause','pause'=>$service->duration]);

    }


    public function addwork($service){

        $hms = explode(":", date('H:i:s', strtotime($service->duration)));
        if($service->service->service->rate_type == 'half-hour' ){
            $totaltime =  ($hms[0]*60) + ($hms[1]) + ($hms[2]/60);
            $working =round($totaltime,3)/30*$service->service->service->rate;
        }else if($service->service->service->rate_type == 'hourly' ){
            $totaltime = $hms[0] + ($hms[1]/60) + ($hms[2]/3600);

            $working =round($totaltime * $service->service->service->rate,2);
        }else {
            $working=$service->service->rate;
        }

        $data =[
            'request_id'=>$service->id,
            'start' => $service->start,
        'end' => $service->end,
        'duration' => $service->duration,
            'amount' =>$working
        ];


        $this->working->create($data);
    }

    public function servicenotification($order){
        $usertype = $this->userType->where('name','admin')->first();
        $service['receiver_id'] =$usertype->user->id;
        $service['message']=$order->service->service->title.' is finished';

            event(new ServiceOrder($service));
    }


}
