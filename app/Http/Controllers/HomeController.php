<?php

namespace App\Http\Controllers;

use App\Http\Requests\Frontend\user\UserStoreRequest;
use App\Mail\AdminRegistration;
use App\Mail\AssignUser;
use App\Models\Category;
use App\Models\ProductCatergory;
use App\Models\Property;
use App\Repositories\CategoryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PropertyImageRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\PlaceRepository;
use App\Repositories\ServiceCategoryRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\UserTypeRepository;
use App\Repositories\SettingRepository;
use App\Repositories\SubcategoryRepository;
use App\Repositories\UserRepository;
use App\Repositories\AdvertisementRepository;
use App\Repositories\SliderRepository;
use Illuminate\Http\Request;
use App\Events\User\UserRegistration;
use Mail;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    protected $userType,$property, $propertyImage, $service,$serviceCategory, $product, $location,$propertyCategory, $subcategory,$productCategory, $user, $setting, $ads, $place, $slider;

    public  function __construct(PropertyRepository $property, ServiceRepository $service,
     ProductRepository $product, LocationRepository $location, CategoryRepository $propertyCategory,
     SubcategoryRepository $subcategory,ProductCategoryRepository $productCategory,
     UserRepository $user,SettingRepository $setting,ServiceCategoryRepository $serviceCategory,UserTypeRepository $userType, AdvertisementRepository $ads, PlaceRepository $place, SliderRepository $slider)
    {
        $this->property = $property;
        $this->service =$service;
        $this->product = $product;
        $this->location = $location;
        $this->place = $place;
        $this->propertyCategory = $propertyCategory;
        $this->subcategory = $subcategory;
        $this->productCategory = $productCategory;
        $this->user = $user;
        $this->setting = $setting;
        $this->userType =$userType;
        $this->serviceCategory = $serviceCategory;
        $this->ads = $ads;
        $this->slider = $slider;

    }

    public function index()
    {
        $categories = $this->propertyCategory->where('is_active','1')->orderBy('created_at','desc')->get();
        $locations = $this->location->where('is_active','1')->get();
        $places = $this->place->all();
        $subcategories = $this->subcategory->where('is_active','1')->get();
        $products = $this->product->where('paid','1')->where('is_active','1')->latest()->take(8)->get();
        $services = $this->service->where('is_active','1')->latest()->take(8)->get();

        $properties = $this->property->where('is_active', '1')->where('paid','1')->where('sold','!=','1')->latest()->take(8)->get();
        $servicesLists = $this->service->where('is_active','1')->orderBy('created_at','desc')->get();

        $productCategories = $this->productCategory->where('is_active','1')->orderBy('created_at','desc')->get();
        $servicecategories = $this->serviceCategory->where('is_active','1')->get();

        $setting = $this->setting->where('is_active',1)->first();

        $slider['property'] = $this->slider->where('status', 1)->where('section','properties')->pluck('image')->first();
        $slider['product'] = $this->slider->where('status', 1)->where('section','products')->pluck('image')->first();
        $slider['service'] = $this->slider->where('status', 1)->where('section','services')->pluck('image')->first();
        $slider['listing'] = $this->slider->where('status', 1)->where('section','listing')->pluck('image')->first();
        $slider['advertisement'] = $this->slider->where('status', 1)->where('section','advertisement')->pluck('image')->first();

        $ads = $this->ads->where('status',1)->limit(3)->pluck('image');
        return view('frontend.home',compact('subcategories','slider','setting'))
        ->withProperties($properties)
        ->withServices($services)
        ->withProducts($products )
        ->withLocations($locations)
        ->withPlaces($places)
        ->withCategories($categories)
        ->withServicesLists($servicesLists)
        ->withProductCategories($productCategories)
        ->withServicecategories($servicecategories)
        ->withAds($ads);
    }

    public function getsubcategory(Request $request){
        $subcategory = $this->subcategory->where('category_id',$request->category_id)->where('is_active','1')->get();
        
        if($subcategory->isEmpty()){
            return response()->json(array('success'=>false));
        }
        return response()->json(array('success'=>true,'subcategory'=>  $subcategory));
    }


    public function viewprofile(Request $request)
    {
        $user = $this->user->find(Auth::user()->id);
        return view('profile.index')->withUser($user);
    }

    protected function store(UserStoreRequest $request)
    {

        // $setting = $this->setting->where('slug','to-email')->first();
        $user = $this->user->latestFirst();
        $data = $request->except('_token');
        $data['password'] = bcrypt($request->password);
        $data['batch_number'] = $this->batch($user);
        $data['is_active'] =(isset($request['is_active'])) ? 1 : 0;
        if($this->user->create($data)){
            $user = $this->user->latestFirst();
            $usertype = $this->userType->where('name','admin')->first();
            $newuser['receiver_id'] =$usertype->user->id;
            $newuser['message']=' New user Register';
            event (new UserRegistration($newuser));
            // if(isset($setting)){
            //     Mail::to($setting->value)->send(new AdminRegistration($data,$setting,$user));
            // }
            if($request->ajax()){
                return response()->json(['success'=>true],200);
            }
            return redirect()->to('/login')->with('success', 'Register Successfully ');
        }
        return redirect()->back()->with('errors', 'Register Successfully ');
    }

    public function batch($user){
        if (empty($user->batch_number)) {
            return  'USR-01';
        } else {
            return  ++$user->batch_number;
        }
    }
    public function autocomplete(Request $request, $slug)
    {
        if($slug == '0'){
            $data['is_active'] = 0;
            $data['message'] = 'Please select the category';
            return response()->json($data,422);
        }
        $search = $request->get('term');
        if($slug == 'property'){
            $data = $this->property->where('title', 'LIKE', '%'. $search. '%')->get();
        }
        else if($slug == 'category'){
            $data = $this->category->where('title', 'LIKE', '%'. $search. '%')->get();
        }else {
            $data = $this->product->where('title', 'LIKE', '%'. $search. '%')->get();

        }
        return response()->json( $data);

    }

    public function search(Request $request){

       if(empty($request->category)){
        return redirect()->back();
    }
    if($request->category == 'property') 
    {
        $search = strtolower($request->title);
        $property = $this->property->where('title','like','%'.$search.'%')->where('is_active',1)->first();
        if(!empty($property)){
            return redirect()->route('property.show', [$property->slug]);
        }

        $category = Category::inRandomOrder()->first();

        return redirect()->to('property/'. $category->slug);

    }
    else if ($request->category == 'service')
    {
        $search = strtolower($request->title);
        $service = $this->service->where('title','like','%'.$search.'%')->where('is_active',1)->first();
                // dd($service);
        if(!empty($service)) {
            return redirect()->route('service.show', [$service->slug]);
        }
        $categories = $this->serviceCategory->where('is_active','1')->orderBy('created_at','desc')->paginate(8);
        $services = $this->service->where('is_active','1')->orderBy('created_at','desc')->paginate(8);
        return view('service.index')->withServices($services)->withCategories($categories);


    }else{
        $product = $this->product->where('title',$request->title)->first();
        if(!empty($product)) {
            return redirect()->route('product.show', [$product->slug]);
        }

        $category = ProductCatergory::inRandomOrder()->first();
        return redirect()->to('product/category/'.$category->slug);

    }
}

public function assign(Request $request){

    $data = $request->except('_token');
    $data['broker'] = isset($request->broker) ? 1:0;
    $data['vendor'] = isset($request->vendor) ? 1:0;
    $data['service'] = isset($request->service) ? 1:0;
    $user = Auth::user();
    $admin = $this->setting->where('title' ,'Email')->first();
    $companyemail =  $this->setting->where('slug' ,'to-email')->first();
    $companyname =  $this->setting->where('title' ,'Company Name')->first();

    Mail::to($admin->value)->send(new AssignUser($request,$companyname,$companyemail,$user));


    return redirect()->route('view.profile')->with('profile','We will contact you soon');

}

    public function contact()
    {
        return view('contact.index');
    }
}
