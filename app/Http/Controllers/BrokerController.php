<?php

namespace App\Http\Controllers;

use App\Http\Requests\Broker\BrokerStoreRequest;
use App\Http\Requests\Broker\UpdateRequest;
use App\Repositories\BrokerRepository;
use App\Repositories\PropertyRepository;
use Illuminate\Http\Request;
use Auth;
use App\Repositories\UserTypeRepository;
use App\Repositories\SettingRepository;
use App\Events\User\UserBroker;
use Illuminate\Support\Facades\Storage;

class BrokerController extends Controller
{
    protected $property, $broker,$userType,$setting;
    public function __construct(PropertyRepository $property,BrokerRepository $broker,UserTypeRepository$userType,SettingRepository $setting )
    {
        $this->property = $property;
        $this->broker=$broker;
        $this->setting = $setting;
        $this->userType =$userType;
        $this->upload_path = DIRECTORY_SEPARATOR . 'broker' . DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');


    }

    public function index(){
        $properties = $this->property->where('broker_id', Auth::user()->id)->orderBy('created_at','desc')->paginate('12');

        return view('profile.property.broker')->withProperties($properties );
    }

    public function store(BrokerStoreRequest $request){
        $data = $request->except('_token', 'citizen', 'certificate');
        $broker = $this->broker->where('broker_id',Auth::user()->id)->first();
       if(empty($broker)) {
           if ($request->file('citizen')) {
               $image = $request->file('citizen');
               $fileName = time() . $image->getClientOriginalName();
               $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
               $data['citizen'] = 'broker/' . $fileName;

           }
           if ($request->file('certificate')) {
               $image = $request->file('certificate');
               $fileName = time() . $image->getClientOriginalName();
               $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
               $data['certificate'] = 'broker/' . $fileName;

           }
           $data['is_active'] = (isset($request['is_active'])) ? 1 : 0;
           $data['broker_id'] = Auth::user()->id;
           if ($this->broker->create($data)) {
            $usertype = $this->userType->where('name','admin')->first();
            $newuser['receiver_id'] =$usertype->user->id;
            $newuser['message']= Auth::user()->name.'has send broker request';
            event (new UserBroker($newuser));
               return response()->json(['success' => true], 200);
           }
       }else{
           return response()->json(['success' => true], 200);
       }
        return response()->json(['errors'=>true],422);

    }

    public function edit($slug){
        dd($slug);
    }public function update(UpdateRequest $request){
    $data = $request->except('_token', 'citizen', 'certificate');
    $broker = $this->broker->where('broker_id',Auth::user()->id)->first();
    if ($request->file('citizen')) {
        $image = $request->file('citizen');
        $fileName = time() . $image->getClientOriginalName();
        $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
        $data['citizen'] = 'broker/' . $fileName;

    }
    if ($request->file('certificate')) {
        $image = $request->file('certificate');
        $fileName = time() . $image->getClientOriginalName();
        $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
        $data['certificate'] = 'broker/' . $fileName;

    }
    if ($this->broker->update($broker->id,$data)) {
        return response()->json(['success' => true], 200);
    }
        return response()->json(['errors'=>true],422);
    }

    public function get_broker_property(){
        $id = Auth::user()->id;
        $propertys = $this->property->where('broker_id',$id)->orderBy('created_at','desc')->get();
        return \DataTables::of($propertys)
            ->addColumn('action', function ($propertys) {
                return  '<a href="' . asset("property/edit/$propertys->slug") . '" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-property"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
                <a href="' . asset("property_owner/property_image/create/$propertys->id") . '" class="btn btn-xs btn-info btn-icon btn-rounded"  title="Add-Property-Image" data-toggle="tooltip" > <i class="fa fa-image"></i></a>';



            })

            ->addColumn('category',function($propertys){

                return  $propertys->category->name;
            })
            ->addColumn('subcategory',function($propertys) {
                if (!empty($propertys->subcategory_id)){
                    return $propertys->subcategory->title;
                }
                else{
                    return '---';
                }


            })
            ->addColumn('location',function($propertys){

                return  $propertys->location->name;
            })
            ->addColumn('place',function($propertys){

                return  $propertys->place->name;
            })

            ->addColumn('sold', function ($propertys) {
                if ($propertys->sold == '1') {
                    return'<i class="fa fa-check" aria-hidden="true"></i>';
                }
                if ($propertys->sold == '0') {
                    return'<i class="fa fa-minus" aria-hidden="true"></i>';
                }



            })
            ->addColumn('status', function ($propertys) {
                if ($propertys->is_active == '1') {
                    return'<i class="fa fa-check" aria-hidden="true"></i>';
                }
                if ($propertys->is_active == '0') {
                    return'<i class="fa fa-minus" aria-hidden="true"></i>';
                }



            })


            ->addColumn('broker_name', function ($propertys) {
                if(!empty($propertys->broker_id)){

                    return  $propertys->brokers->name;
                }
                else{
                    return  ' -';

                }


            })
            ->addColumn('paid', function ($propertys) {
                if ($propertys->paid == '1') {
                    return'<i class="fa fa-check" aria-hidden="true"></i>';
                }
                if ($propertys->paid == '0') {
                    return'<i class="fa fa-minus" aria-hidden="true"></i>';
                }

            })
            ->removeColumn('id')
            ->rawColumns(['action','status','category','subcategory','sold','place','broker_name'])
            ->addIndexColumn()
            ->make(true);
    }


}
