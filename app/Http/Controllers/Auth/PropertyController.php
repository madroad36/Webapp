<?php

namespace App\Http\Controllers\Auth;

use App\Mail\AdminProperty;
use App\Repositories\PlaceRepository;
use App\Repositories\UserRepository;
use App\Http\Requests\Property\PropertyStoreRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\SubcategoryRepository;
use App\Repositories\UserTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Repositories\SettingRepository;
use Auth;
use Mail;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $property, $category, $location,$user, $subcategory, $userType, $place;

    public function __construct(PropertyRepository $property,LocationRepository $location,
                                CategoryRepository $category, SubcategoryRepository $subcategory,
                                UserTypeRepository $userType, UserRepository $user, PlaceRepository $place,
                                SettingRepository $setting)
    {
        $this->property=$property;
        $this->category = $category;
        $this->location = $location;
        $this->subcategory = $subcategory;
        $this->userType= $userType;
        $this->user =$user;
        $this->place=$place;
        $this->setting = $setting;
        $this->upload_path = DIRECTORY_SEPARATOR.'property'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');


    }

    public function index()
    {
        return view('user.property.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subcategories = $this->subcategory->where('is_active','1')->get();
        $categories = $this->category->where('is_active','1')->orderBy('created_at','desc')->get();
        $locations = $this->location->where('is_active','1')->orderBy('created_at','desc')->get();

        return view('user.property.create')->withCategories($categories)
            ->withLocations($locations)
            ->withSubcategories($subcategories );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyStoreRequest $request)
    {
        $data = $request->except('_token','image','owner_image');
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['thumbnail'] = 'property/'.$fileName;

        }
        if($request->file('owner_image')){
            $image= $request->file('owner_image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['property_image'] = 'owner-image/'.$fileName;

        }
        $data['overview']= $request->short_description;
        $data['created_by'] = Auth::user()->id;
        $data['broker'] =(isset($request['broker'])) ? 1 : 0;
        $data['paid'] =(isset($request['paid'])) ? 1 : 0;
        $data['sold'] =(isset($request['sold'])) ? 1 : 0;
        $data['is_active'] =(isset($request['is_active'])) ? 1 : 0;
        if($this->property->create($data)){
            $property = $this->property->latestFirst();
            $admin = $this->setting->where('title' ,'Email')->first();
            $companyemail =  $this->setting->where('slug' ,'to-email')->first();
            $companyname =  $this->setting->where('title' ,'Company Name')->first();
            Mail::to($admin->value)->send(new AdminProperty($property,$companyname,$companyemail));
            return redirect('auth/property')->with('success','property is created successfully');
        }
        return redirect()->back()->with('success','property cannnot be created successfully');

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
        $property = $this->property->find($id);
        $subcategories = $this->subcategory->where('is_active','1')->orderBy('created_at','desc')->get();
        $categories = $this->category->where('is_active','1')->orderBy('created_at','desc')->get();
        $locations = $this->location->where('is_active','1')->orderBy('created_at','desc')->get();

        return view('user.property.edit')
            ->withCategories($categories)
            ->withProperty($property)
            ->withLocations($locations)
            ->withSubcategories($subcategories);
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
        $data = $request->except('_token','image','owner_image');
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['thumbnail'] = 'property/'.$fileName;

        }
        if($request->file('owner_image')){

            $image= $request->file('owner_image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));

            $data['property_image'] = 'property/'.$fileName;

        }
        $data['broker'] =(isset($request['broker'])) ? 1 : 0;
        if($data['broker'] == '0'){
            $data['broker_id'] = Null;
        }
        $data['paid'] =(isset($request['paid'])) ? 1 : 0;
        $data['sold'] =(isset($request['sold'])) ? 1 : 0;
        $data['is_active'] =(isset($request['is_active'])) ? 1 : 0;

        $data['overview']= $request->short_description;
        $data['created_by'] = Auth::user()->id;
        if($this->property->update($property->id,$data)){
            return redirect('auth/property')->with('success','property is updated successfully');
        }
        return redirect()->back()->with('success','property cannnot be updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = $this->property->find($id);

        if($this->property->destroy($property->id)){

            $message = 'Property Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);

    }

    public function changeStatus(Request $request)
    {
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
                $data ='';
                if(auth()->user()->can('edit-property')) {
                    $data .= '<a href="' . asset("auth/property/edit/$propertys->id") . '" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-property"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>';
                }
                if(auth()->user()->can('add-property-broker')) {
                    $data .= '&nbsp;  <button type="button" data-type="' . $propertys->id . '" id="add-broker" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus" aria-hidden="true"></i></button>';
                }
                if(auth()->user()->can('add-property-image')) {
                    $data .= '&nbsp;<a href="' . asset("auth/property_image/create/$propertys->id") . '" class="btn btn-xs btn-info btn-icon btn-rounded"  title="Add-Property-Image" data-toggle="tooltip" > <i class="fa fa-image"></i></a>';
                }
                if(auth()->user()->can('delete-property')) {
                    $data .= '&nbsp<a href="#"  data-type="' . $propertys->id . '" id="delete-property" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-property"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }
                return $data;

            })
            ->addColumn('created_by',function($propertys){

                return  $propertys->user->name;
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
            ->addColumn('status', function ($propertys) {
                if(auth()->user()->can('changestatus-property')) {
                    if ($propertys->is_active == '1')
                        return '<a href="#"  data-type="' . $propertys->id . '" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                    if ($propertys->is_active == '0') return '<a href="#"  data-type="' . $propertys->id . '" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';

                }
            })
            ->addColumn('sold', function ($propertys) {
                if(auth()->user()->can('add-property-broker')) {
                    if ($propertys->sold == '1')
                        return '<a href="#"  data-type="' . $propertys->id . '" id="item-sold" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                    if ($propertys->sold == '0') return '<a href="#"  data-type="' . $propertys->id . '" id="item-sold" class="btn btn-xs btn-success unpublished" "  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';

                }
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
                if(auth()->user()->can('add-property-paid')) {
                    if ($propertys->paid == '1')
                        return '<a href="#"  data-type="' . $propertys->id . '" id="item-paid" class="btn btn-xs btn-success published"  title="Paid"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                    if ($propertys->paid == '0') return '<a href="#"  data-type="' . $propertys->id . '" id="item-paid" class="btn btn-xs btn-success unpublished" "  title="Unpaid"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';
                }

            })
            ->removeColumn('id')
            ->rawColumns(['action','created_by','status','category','subcategory','sold','paid','broker','broker_name'])
            ->addIndexColumn()
            ->make(true);
    }

    public function getsubcategory(Request $request){
        $sucategory = $this->subcategory->where('category_id',$request->category_id)->where('is_active','1')->get();

        if($sucategory->isEmpty()){
            return response()->json(array('success'=>false));
        }
        return response()->json(array('success'=>true,'sucategory'=>  $sucategory));
    }
    public function getplace(Request $request){
        $place = $this->place->where('location_id',$request->location_id)->get();
        if($place->isEmpty()){
            return response()->json(array('errors'=>false),422);
        }
        return response()->json(array('success'=>true,'place'=>  $place),200);
    }
    public function getusertype(){

        $usertype = $this->userType->orderBy('created_at','desc')->where('name','!=','admin')->get();
        return response()->json(['success'=>true,'usertype'=>$usertype]);
    }

    public function getuser(Request $request){

        $users = $this->user->where('usertype_id', $request->usertype_id)->where('is_active','1')->get();
        return response()->json(['success'=>true,'users'=>$users]);

    }

    public function assignUsertype(Request $request)
    {
        $property = $this->property->find($request->id);
        $this->property->update($property->id, array('broker_id' => $request->broker_id,'broker'=>'1'));
        return redirect('auth/property')->with('success','Broker Added Successfully');

    }
}
