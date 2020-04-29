<?php

namespace App\Http\Controllers\Admin;

use App\Mail\PropetyAssignBroker;
use App\Repositories\AminitiesRepository;
use App\Repositories\PropertyAminitesRepository;
use App\Repositories\BrokerRepository;
use App\Repositories\PlaceRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use App\Http\Requests\Property\PropertyStoreRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\SubcategoryRepository;
use App\Repositories\UserTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Storage;
use Auth;
use Gate;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $property, $category, $location,$user, $subcategory, $userType, $place,$broker,$setting,$aminities;

    public function __construct(PropertyRepository $property,LocationRepository $location,
       CategoryRepository $category, SubcategoryRepository $subcategory,
       UserTypeRepository $userType, UserRepository $user, PlaceRepository $place,
       BrokerRepository $broker, SettingRepository $setting, AminitiesRepository $aminities,
       PropertyAminitesRepository $propertyAminites)
    {
        $this->property=$property;
        $this->category = $category;
        $this->location = $location;
        $this->subcategory = $subcategory;
        $this->userType= $userType;
        $this->user =$user;
        $this->place = $place;
        $this->broker = $broker;
        $this->setting = $setting;
        $this->aminities =$aminities;
        $this->propertyAminites = $propertyAminites;
        $this->upload_path = DIRECTORY_SEPARATOR.'property'.DIRECTORY_SEPARATOR;
        $this->file_upload = DIRECTORY_SEPARATOR.'owner-image'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');



    }

    public function index()
    {

        $subcategories = $this->subcategory->where('is_active','1')->get();
        $categories = $this->category->where('is_active','1')->orderBy('created_at','desc')->get();
        $locations = $this->location->where('is_active','1')->orderBy('created_at','desc')->get();
        $aminites = $this->aminities->where('is_active', '1')->get();
        return view('layouts.backend.property.view')->withCategories($categories)
        ->withLocations($locations)
        ->withSubcategories($subcategories )
        ->withAminites($aminites);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $subcategories = $this->subcategory->where('is_active','1')->get();
        $categories = $this->category->where('is_active','1')->orderBy('created_at','desc')->get();
        $locations = $this->location->where('is_active','1')->orderBy('created_at','desc')->get();
        $aminites = $this->aminities->where('is_active', '1')->get();   
        return view('layouts.backend.property.edit')
        ->withCategories($categories)
        ->withLocations($locations)
        ->withSubcategories($subcategories )
        ->withAminites($aminites);

    }

    
    public function store(PropertyStoreRequest $request)
    {
       $data = $request->except('_token', 'image', 'owner_image', 'property_image');
       if ($request->file('image')) {
        $image = $request->file('image');
        $fileName = time() . $image->getClientOriginalName();
        $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
        $data['thumbnail'] = 'property/' . $fileName;

    }
    if ($request->file('owner_image')) {
        $image = $request->file('owner_image');
        $fileName = time() . $image->getClientOriginalName();
        $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
        $data['owner_image'] = 'property/' . $fileName;

    }
    if ($request->file('property_image')) {
        $image = $request->file('property_image');
        $fileName = time() . $image->getClientOriginalName();
        $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
        $data['property_image'] = 'property/' . $fileName;

    }
    if ($request->file('property_paper')) {
        $image = $request->file('property_paper');
        $fileName = time() . $image->getClientOriginalName();
        $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
        $data['property_paper'] = 'property/' . $fileName;

    }

    $location =$this->location->firstOrCreate(['name'=>strtolower($request->city)]);
    $address =$this->place->firstOrCreate(['name'=>strtolower($request->address),'location_id'=>$location->id]);
    $data['location_id']=$location->id;
    $data['place_id']= $address->id;
    $data['overview'] = strtolower($request->short_description);
    $data['created_by'] = Auth::user()->id;
    $data['broker'] = (isset($request['broker'])) ? 1 : 0;
    $data['paid'] = (isset($request['paid'])) ? 1 : 0;
    $data['sold'] = (isset($request['sold'])) ? 1 : 0;
    $data['is_active'] = (isset($request['is_active'])) ? 1 : 0;
    $data['service_charge'] ='0';
    $data['feature'] ='0';
    if ($this->property->create($data)) {
        $property = $this->property->latestFirst();
        if ($request->has('aminites')) {
            $aminite = $request->aminites;
            $property_aminities = [];

            foreach ($aminite as $key => $value) {
                $property_aminities [] = [
                    'property_id' => $property->id,
                    'aminities_id' => $key,
                    'is_active' => (isset($value) ? 1 : 0)
                ];
            }

            $this->propertyAminites->insert($property_aminities);
        }

        $admin = $this->setting->where('is_active', 1)->first();
        $companyemail = $admin->email;
        $companyname = $admin->company;

        $usertype = $this->userType->where('name','admin')->first();
        $property['receiver_id'] =$usertype->user->id;
        $property['message'] = 'New Property is Added';

        event(new PropertyCreated($property));
        if(isset($admin)){
            Mail::to($admin->email)->send(new AdminProperty($property, $companyname, $companyemail));
        }
        return response()->json(['success'=>true,'property'=>$property],200);
    }
    return response()->json(['success'=>false,'error'=>'cannot complete the operation'],422);

}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $property = $this->property->find($id);
        $subcategories = $this->subcategory->where('is_active','1')->orderBy('created_at','desc')->get();
        $categories = $this->category->where('is_active','1')->orderBy('created_at','desc')->get();
        $locations = $this->location->where('is_active','1')->orderBy('created_at','desc')->get();
        $aminites = $this->aminities->where('is_active', '1')->get();
        return view('layouts.backend.property.edit')
        ->withCategories($categories)
        ->withProperty($property)
        ->withLocations($locations)
        ->withSubcategories($subcategories)
        ->withAminites($aminites);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $property = $this->property->find($id);
        $data = $request->except('_token', 'image', 'owner_image', 'property_image');
        if ($request->file('image')) {
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
            $data['thumbnail'] = 'property/' . $fileName;

        }
        if ($request->file('owner_image')) {
            $image = $request->file('owner_image');
            $fileName = time() . $image->getClientOriginalName();
            $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
            $data['owner_image'] = 'property/' . $fileName;

        }
        if ($request->file('property_image')) {
            $image = $request->file('property_image');
            $fileName = time() . $image->getClientOriginalName();
            $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
            $data['property_image'] = 'property/' . $fileName;

        }
        if ($request->file('property_paper')) {
            $image = $request->file('property_paper');
            $fileName = time() . $image->getClientOriginalName();
            $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
            $data['property_paper'] = 'property/' . $fileName;

        }
        $location =$this->location->firstOrCreate(['name'=>$request->city]);
        $address =$this->place->firstOrCreate(['name'=>$request->address,'location_id'=>$location->id]);
        $data['location_id']=$location->id;
        $data['place_id']= $address->id;
        $data['overview'] = $request->short_description;
        $data['created_by'] = Auth::user()->id;
        $data['broker'] = (isset($request['broker'])) ? 1 : 0;
        $data['paid'] = (isset($request['paid'])) ? 1 : 0;
        $data['sold'] = (isset($request['sold'])) ? 1 : 0;
        $data['is_active'] = (isset($request['is_active'])) ? 1 : 0;
        $data['service_charge'] ='0';
        if ($this->property->update($property->id,$data)) {

            if ($request->has('aminites')) {

                $aminite = $request->aminites;
                $aminite = $request->aminites;
                $this->propertyAminites->where('property_id',$property->id)->delete();
                $property_aminities = [];

                foreach ($aminite as $key => $value) {
                    $property_aminities [] = [
                        'property_id' => $property->id,
                        'aminities_id' => $key,
                        'is_active' => (isset($value) ? 1 : 0)
                    ];
                }

                $this->propertyAminites->insert($property_aminities);
            }



            return response()->json(['success'=>true,'property'=>$property,'images'=>$property->image],200);
//            return redirect('/property_image/show/'.$property->slug)->with('success', 'property add successfull'.'<br>'.' wating for approval');
        }
        return response()->json(['success'=>false,'error'=>'cannot complete the operation'],422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $property = $this->property->find($id);

        if($this->property->destroy($property->id)){

            $message = 'Property Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);

    }
    public function changeStatus(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $property = $this->property->find($request->get('id'));
        if ($property->is_active == 0) {
            $status = '1';
            $message = 'property with title "' . $property->title . '" is published.';
        } else {
            $status = '0';
            $message = 'property with title "' . $property->title . '" is unpublished.';
        }

        $this->property->changeStatus($property->id, $status);
        $this->property->update($property->id, array('is_active' => $status));
        $updated = $this->property->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'property' => $updated], 200);
    }

    public function sold(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $property = $this->property->find($request->get('id'));
        if ($property->sold == 0) {
            $status = '1';
            $message = 'property with title "' . $property->title . '" is sold.';
        } else {
            $status = '0';
            $message = 'property with title "' . $property->title . '" is unsold.';
        }

        $this->property->changeStatus($property->id, $status);
        $this->property->update($property->id, array('sold' => $status));
        $updated = $this->property->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'property' => $updated], 200);
    }

    public function paid(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $property = $this->property->find($request->get('id'));
        if ($property->paid == 0) {
            $status = '1';
            $message = 'property with title "' . $property->title . '" is paid.';
        } else {
            $status = '0';
            $message = 'property with title "' . $property->title . '" is unpaid.';
        }

        $this->property->changeStatus($property->id, $status);
        $this->property->update($property->id, array('paid' => $status));
        $updated = $this->property->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'property' => $updated], 200);
    }

    public function getdata(){

        $propertys = $this->property->orderBy('created_at','desc')->get();

        return \DataTables::of($propertys)
        ->addColumn('action', function ($propertys) {
            return '<a href="javascript:void(0)" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-property"
            id="admin-edit-property"  data-type="'.asset("admin/property/edit/$propertys->id").'"   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
            <button type="button" data-type="'.$propertys->id.'" id="add-broker" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-plus" aria-hidden="true"></i>
            </button>
            <a href="'.asset("admin/property_image/create/$propertys->id").'" class="btn btn-xs btn-info btn-icon btn-rounded"  title="Add-Property-Image"
            data-toggle="tooltip" > <i class="fa fa-image"></i></a>

            <a href="#"  data-type="'.$propertys->id.'" id="delete-property" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-property"
            data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
            ';
        })
        ->addColumn('created_by',function($propertys){

            return  $propertys->user->name;
        })
        ->addColumn('category',function($propertys){

            return  $propertys->category->name .'<br>'.$propertys->subcategory->title;;
        })
//            ->addColumn('place',function($propertys){
//                    if(empty($propertys->place)){
//                        return '--';
//                    }
//                return  $propertys->place->name;
//            })
//            ->addColumn('subcategory',function($propertys) {
//                if (!empty($propertys->subcategory_id)){
//                    return $propertys->subcategory->title;
//            }
//            else{
//                return '---';
//            }
//
//
//            })
        ->addColumn('location',function($propertys){

            return  $propertys->location->name .'<br>'.$propertys->place->name;
        })
        ->addColumn('status', function ($propertys) {
            if($propertys->is_active == '1')
                return  '<a href="#"  data-type="'.$propertys->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
            data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

            if($propertys->is_active == '0')   return  '<a href="#"  data-type="'.$propertys->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
            data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';
        })

        ->addColumn('sold', function ($propertys) {
            if($propertys->sold == '1')
                return  '<a href="#"  data-type="'.$propertys->id.'" id="item-sold" class="btn btn-xs btn-info published"  title="change-status"
            data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

            if($propertys->sold == '0')   return  '<a href="#"  data-type="'.$propertys->id.'" id="item-sold" class="btn btn-xs btn-info unpublished" "  title="change-status"
            data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';
        })

        ->addColumn('broker', function ($propertys) {
            if($propertys->broker == '1'){

                return  'Yes';
            }
            if($propertys->broker== '0')  {
              return  'No';

          }


      })
        ->addColumn('broker_name', function ($propertys) {
            if(!empty($propertys->broker_id)){

                return  $propertys->brokers->name;
            }
            else{
                return  ' <i class="fa fa-minus" aria-hidden="true"></i>';

            }


        })
        ->addColumn('paid', function ($propertys) {
            if($propertys->paid == '1')
                return  '<a href="#"  data-type="'.$propertys->id.'" id="item-paid" class="btn btn-xs btn-warning published"  title="Paid"
            data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

            if($propertys->paid == '0')   return  '<a href="#"  data-type="'.$propertys->id.'" id="item-paid" class="btn btn-xs btn-warning unpublished" "  title="Unpaid"
            data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';
        })
        ->removeColumn('id')
        ->rawColumns(['action','created_by','status','category','sold','paid','broker','broker_name','location'])
        ->addIndexColumn()
        ->make(true);
    }

    public function getsubcategory(Request $request)
    {
     if(!Gate::allows('isAdmin')){
        abort(404,"Permission Denied.");
    }
    $sucategory = $this->subcategory->where('category_id',$request->category_id)->where('is_active','1')->get();

    if($sucategory->isEmpty()){
        return response()->json(array('success'=>false));
    }
    return response()->json(array('success'=>true,'sucategory'=>  $sucategory));
}

public function getplace(Request $request)
{
 if(!Gate::allows('isAdmin')){
    abort(404,"Permission Denied.");
}
$place = $this->place->where('location_id',$request->location_id)->get();

if($place->isEmpty()){
    return response()->json(array('errors'=>false),422);
}
return response()->json(array('success'=>true,'place'=>  $place),200);
}

public function getusertype()
{
 if(!Gate::allows('isAdmin')){
    abort(404,"Permission Denied.");
}
$usertype = $this->broker->where('is_active','1')->orderBy('created_at','asc')->get();
$data = '';
foreach ($usertype as $broker){
    $data  .='<option selected="selected" value="'.$broker->id.'">'.$broker->user->name.'</option:selectedoption>';
}
return response()->json(['success'=>true,'usertype'=>$usertype,'data'=>$data]);
}

public function getuser(Request $request){
 if(!Gate::allows('isAdmin')){
    abort(404,"Permission Denied.");
}
$users = $this->user->where('usertype_id', $request->usertype_id)->where('is_active','1')->get();
return response()->json(['success'=>true,'users'=>$users]);

}

public function assignUsertype(Request $request)
{
 if(!Gate::allows('isAdmin')){
    abort(404,"Permission Denied.");
}
$broker = $this->broker->find($request->broker_id);
$property = $this->property->find($request->id);
$this->property->update($property->id, array('broker_id' => $broker->broker_id,'broker'=>'1'));
$companyemail = $this->setting->where('slug', 'to-email')->first();
$companyname = $this->setting->where('title', 'Company Name')->first();
Mail::to($broker->user->email)->send(new PropetyAssignBroker($property,$broker, $companyname, $companyemail));

return redirect('admin/property')->with('success','Broker Added Successfully');

}
}
