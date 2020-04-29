<?php

namespace App\Http\Controllers;

use App\Events\Product\ProductCreated;
use App\Events\Property\PropertyCreated;
use App\Http\Requests\Frontend\Property\PropertyStoreRequest;
use App\Models\Category;
use App\Models\Property;
use App\Repositories\AminitiesRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\PlaceRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PropertyAminitesRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\SettingRepository;
use App\Repositories\SubcategoryRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserTypeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Auth;
use Mail;
use Response;
use Session;
use App\Mail\AdminProperty;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $user, $property, $propertyImage, $category,
    $service, $product, $place, $location,$userType,
    $aminites, $propertySubcategory, $setting, $propertyAminites;

    public function __construct(PropertyRepository $property,
        CategoryRepository $category,
        ServiceRepository $service,
        ProductRepository $product,
        PlaceRepository $place,
        LocationRepository $location,
        SubcategoryRepository $propertySubcategory,
        UserRepository $user,
        AminitiesRepository $aminities,
        SettingRepository $setting,
        PropertyAminitesRepository $propertyAminites,
        UserTypeRepository $userType
    )
    {
        $this->property = $property;
        $this->category = $category;
        $this->service = $service;
        $this->product = $product;
        $this->place = $place;
        $this->location = $location;
        $this->propertySubcategory = $propertySubcategory;
        $this->user = $user;
        $this->aminites = $aminities;
        $this->setting = $setting;
        $this->propertyAminites = $propertyAminites;
        $this->upload_path = DIRECTORY_SEPARATOR . 'property' . DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
        $this->userType = $userType;


    }

    public function index(Request $request, $slug)
    {
        if ($request->ajax()) {
            $slug = isset($request->slug) ? $request->slug : $slug;
            $pagenumber = isset($request->item) ? (int)$request->item : '8';
            $category = $this->category->where('slug', $slug)->first();
            $properties = $this->property->where('category_id', $category->id)->where('is_active', '1')->where('sold', '!=', '1')->paginate($pagenumber);
            return view('property.pagelist')->withProperties($properties)->withCategory($category);

        }
        $loactions = $this->location->where('is_active', '1')->get();
        $products = $this->product->where('paid', '1')->where('is_active', '1')->latest()->take(8)->get();
        $services = $this->service->where('is_active', '1')->paginate(8);
        $category = $this->category->where('slug', $slug)->first();
        $categories = $this->category->where('is_active', '1')->get();
        $properties = $this->property->where('category_id', $category->id)->where('is_active', '1')->where('sold', '!=', '1')->paginate(6);
        return view('property.index')->withLocations($loactions)->withProperties($properties)->withCategory($category)->withServices($services)->withProducts($products)->withCategories($categories);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aminites = $this->aminites->where('is_active', '1')->get();
        $categories = $this->category->where('is_active', '1')->orderBy('created_at', 'desc')->get();
        $locations = $this->location->where('is_active', '1')->orderBy('created_at', 'desc')->get();
        $brokers = $this->user->where('broker', '1')->where('is_active', '1')->orderBy('created_at', 'desc')->get();
        return view('profile.property.create')->withCategories($categories)
        ->withLocations($locations)->withBrokers($brokers)->withAminites($aminites);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $property = $this->property->where('slug', $slug)->first();

        $propertyList = $this->property->where('is_active', '1')->where('paid', '0')->where('category_id', $property->category_id)->where('id', '!=', $property->id)->latest()->take(12)->get();
        $similarLocation = $this->property->where('is_active', '1')->where('paid', '0')->where('location_id', $property->location_id)->where('id', '!=', $property->id)->latest()->take(12)->get();
        $services = $this->service->where('is_active', '1')->paginate(6);

        return view('property.show')->withServices($services)->withProperty($property)->withPropertyList($propertyList)->withSimilarLocation($similarLocation);

    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {

        $property = $this->property->where('slug', $slug)->first();
        $aminites = $this->aminites->where('is_active', '1')->get();
        $categories = $this->category->where('is_active', '1')->orderBy('created_at', 'desc')->get();
        $locations = $this->location->where('is_active', '1')->orderBy('created_at', 'desc')->get();
        $brokers = $this->user->where('broker', '1')->where('is_active', '1')->orderBy('created_at', 'desc')->get();
//        return view('profile.property.edit')->withProperty($property);
        return view('profile.property.edit')->withProperty($property);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
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
    }
    return response()->json(['success'=>false,'error'=>'cannot complete the operation'],422);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = $this->property->find($id);


        if($this->property->destroy($property->id))
        {

            $message = 'Property Delete Successfully';
            $properties = $this->property->where('created_by', Auth::user()->id)->orderBy('created_at','desc')->paginate('12');

            return view('profile.property.tablist')->withProperties($properties);

        }
//        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);
    }

    public function getsearch(Request $request)
    {
        $property = $this->property->where('title', $request->title)->first();
        return redirect()->route('property.show', [$property->slug]);
    }

    public function search(Request $request)
    {   
        $recently = $this->property->where('is_active', '1')->where('sold', '!=', '1')->latest()->take(25)->get();
        $query = $recently; 
        if (!empty($request->category)) 
        {
            $category = $this->category->where('name',$request->category)->first();
            if($category){
                $query = $query->where('category_id', $category->id);
            }  
            else
            {
                $query = collect([]);
            }

        }

        // if (!empty($request->category_id)) {
        //     $query = $query->where('category_id', $request->category_id);
        //     $category = $this->category->where('id',$request->category_id)->first();
        // }

        //City Bata Aako data Search Garna
        if (!empty($request->city)) 
        {
            $search = strtolower($request->city);
            $location= $this->location->where('name','like', '%'.$search.'%')->first();
            if($location)
            {
                $query = $query->where('location_id', $location->id)->where('is_active',1);
            }
            
            // elseif(count($location) > 0)
            // {
            //     foreach($location as $location){
            //         $query = $query->where('location_id', $location->id)->where('is_active',1);
            //     }
            // }
            else
            {
                $query = collect([]);
            }
        }

        //Address Bata Aako data Search Garna
        if (!empty($request->address)) 
        {
            $search = strtolower($request->address);
            $place = $this->place->where('name','like', '%'.$search.'%')->first();
            if($place)
            {
                $query = $query->where('place_id', $place->id)->where('is_active',1);
            }
            else
            {
              $query = collect([]);
          }
      }
      
        // if (!empty($request->subcategory_id)) {
        //     $query = $query->where('subcategory_id', $request->subcategory_id);
        // }

      if (!empty($request->subcategory)) 
      {
        $subcategory = $this->propertySubcategory->where('title',$request->subcategory)->pluck('id');
        $query= $query->where('category_id',$category->id)->whereIn('subcategory_id',$subcategory);
    }

    if($request->has('lowest')) {
        $properties1= Property::where('category_id',$category->id)->where('is_active', '1')->where('sold',0)->orderBy('price','asc')->get();
        $properties = $properties1->sortBy('price');
        return view('property.search')->withProperties($properties)->withRecently($recently)->withCategory($category);
    }

    if($request->has('higest')) {
        $propertieslist = Property::where('category_id',$category->id)->where('is_active', '1')->where('sold',0)->orderBy('price','desc')->get();
        $properties = $propertieslist->sortByDesc('price');
        return view('property.search')->withProperties($properties)->withRecently($recently)->withCategory($category);
    }

    if (!empty($request->lowest_price) && !empty($request->higest_price)) {
        $query = $this->property->where('is_active', '1')->where('sold', '!=', '1')->latest()->take(25)->whereBetween('price', array((int)$request->lowest_price, (int)$request->higest_price))->get();
    }

    if (!empty($request->lowest_price) && empty($request->higest_price)) {
        $query = $query->where('price', '>=', (int)$request->lowest_price);
    }

    if (!empty($request->higest_price) && empty($request->lowest_price)) {
        $query = $query->where('price', '<=', (int)$request->higest_price);
    } 
    $propertieslist = $query->where('is_active', '1');
    $properties = $propertieslist->unique();
    return view('property.search')->withProperties($properties)->withRecently($recently)->withCategory($category);

}

public function autocomplete(Request $request)
{
    $search = $request->get('term');
    $data = $this->property->where('title', 'LIKE', '%' . $search . '%')->get();
    return response()->json($data);
}

public function getplace(Request $request)
{
    $place = $this->place->where('location_id', $request->location_id)->get();
    return response()->json(['success' => true, 'place' => $place], 200);
}

public function homepagesearch(Request $request)
{
    $recently = $this->property->where('is_active', '1')->where('sold', '!=', '1')->latest()->take(25)->get();
    $query = $recently;
    if (!empty($request->location_id)) {
        $query = $query->where('location_id', $request->location_id);
    }

    if (!empty($request->category_id)) {
        $query = $query->where('category_id', $request->category_id);
        $category = $this->category->where('id',$request->category_id)->first();
    }

    if (empty($request->category_id)) 
    {
        $category = Category::inRandomOrder()->first();
    }

    if (!empty($request->place_id))
    {
        $query = $query->where('place_id', $request->place_id);
    }

    if (!empty($request->subcategory_id))
    {
        $query = $query->where('subcategory_id', $request->subcategory_id);
    }

    $propertieslist = $query->where('is_active', '1');
    $properties = $propertieslist->unique();
    return view('property.search')->withProperties($properties)->withRecently($recently)->withCategory($category);
}


}
