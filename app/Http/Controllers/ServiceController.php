<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\ServiceStoreRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\ServiceCategoryRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\ServiceSubCategoryRepository;
use App\Repositories\SubcategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $service, $property, $category,$location, $subcategory;

    public function __construct(ServiceRepository $service,PropertyRepository $property, ServiceCategoryRepository $category,LocationRepository $location, ServiceSubCategoryRepository $subcategory)
    {
        $this->service = $service;
        $this->property = $property;
        $this->category = $category;
        $this->location = $location;
        $this->subcategory = $subcategory;
        $this->upload_path = DIRECTORY_SEPARATOR.'service'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public'); 


    }

    public function index()
    {

        $categories = $this->category->where('is_active','1')->orderBy('created_at','desc')->paginate(8);
        $services = $this->service->where('is_active','1')->orderBy('created_at','desc')->paginate(8);
        return view('service.index')->withServices($services)->withCategories($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->category->where('is_active',1)->get();
        return view('profile.service.create')->withCategories($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceStoreRequest $request)
    {
        $data = $request->except('_token','image');
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['thumbnail'] = 'service/'.$fileName;

        }
        $data['is_active'] =(isset($request['is_active'])) ? 1 : 0;
        $data['created_by'] = Auth::user()->id;
        if($this->service->create($data)){
            return redirect('view/profile')->with('success','Service Created Successfully');
        }
        return redirect()->back()->with('errors','Service Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $categories = $this->category->where('is_active','1')->get();
        $servicelist = $this->service->where('is_active','1')->get();
        $service = $this->service->where('slug',$slug)->first();
        $locations = $this->location->where('is_active', '1')->orderBy('created_at', 'desc')->get();
        $category = $this->category->where('is_active',1)->where('id', $service->category_id)->first();
        return redirect()->route('category.show',$category->name)->withLocations($locations)->withService($service)->withServicelist($servicelist)->withCategories($categories);
         // return view('service.show')->withLocations($locations)->withService($service)->withServicelist($servicelist)->withCategories($categories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {

        $query = $this->service;

        // Category
        if(!empty($request->category) && empty($request->title))
        {
            $search = strtolower($request->category);
            $categories = $this->category->where('name','like','%'.$search.'%')->orderBy('created_at','desc')->paginate(8);
            $services = $this->service->where('is_active','1')->orderBy('created_at','desc')->paginate(8);
            return view('service.index')->withServices($services)->withCategories($categories);
        }

        // Title
        if(empty($request->category) && !empty($request->title))
        {
            $search = strtolower($request->title);
            $cat = $this->service->where('title','like','%'.$search.'%')->first();
            $category = $this->category->where('id',$cat->category_id)->first();
            $services = $this->service->where('title','like','%'.$search.'%')->paginate(8);
            return view('servicesubcategory.index')->withServices($services)->withCategory($category);
        }

        // If Both input arenot empty
        if(!empty($request->category) && !empty($request->title)) 
        {
            $category = $this->category->where('name',$request->category)->first();
            $services = $this->service->where('category_id', $category->id)->where('title',$request->title)->paginate(8);
            return view('servicesubcategory.index')->withServices($services)->withCategory($category);
        }

        //Both Cases Are Empty
        if(empty($request->category) && empty($request->title))
        {
            $services =[];
            $servicecategories = $this->category->where('is_active',1)->get();
            return view('service.search')->withServices($services)->withServicecategories($servicecategories);
        }

        $services = $query->get();
        $servicecategories = $this->category->where('is_active',1)->get();
        return view('service.search')->withServices($services)->withServicecategories($servicecategories);
    }


    public function servicecategory($slug)
    {
        $date = date("Y-m-d");
        $category = $this->category->where('slug',$slug)->first();
        $services= $this->service->where('category_id',$category->id)->orderBy('created_at','desc')->paginate(8);
        return view('servicesubcategory.index',compact('date'))->withServices($services)->withCategory($category);

    }

    public function homesearch(Request $request)
    {
        $query = $this->service;
        if(!empty($request->category_id) && empty($request->title))
        {
            $categories = $this->category->where('id',$request->category_id)->where('is_active',1)->orderBy('created_at','desc')->paginate(8);
            $services = $this->service->where('is_active','1')->orderBy('created_at','desc')->paginate(8);
            return view('service.index')->withServices($services)->withCategories($categories);
        }

        if(!empty($request->category_id) && !empty($request->title)) 
        {
            $search = strtolower($request->title);
            $category = $this->category->where('id',$request->category_id)->where('is_active',1)->first();
            $services = $this->service->where('category_id', $category->id)->where('is_active',1)->where('title','like','%'.$search.'%')->paginate(8);
            return redirect()->route('category.show',$category->name)->withServices($services)->withCategory($category);
        }

        if(empty($request->category) && !empty($request->title)) 
        {
            $search = strtolower($request->title);
            $cat = $this->service->where('title','like','%'.$search.'%')->first();
            $category = $this->category->where('id',$cat->category_id)->first();
            $services = $this->service->where('title','like','%'.$search.'%')->paginate(8);
            return redirect()->route('category.show')->withServices($services)->withCategory($category);
        }

        if(empty($request->category) && empty($request->title))
        {
            $services =[];
            $servicecategories = $this->category->where('is_active',1)->get();
            return view('service.search')->withServices($services)->withServicecategories($servicecategories);
        }

        $services = $query->get();
        $servicecategories = $this->category->where('is_active',1)->get();
        return view('service.search')->withServices($services)->withServicecategories($servicecategories);
    }
}
