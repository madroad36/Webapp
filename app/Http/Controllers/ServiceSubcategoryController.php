<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceCategoryRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\ServiceSubCategoryRepository;
use Illuminate\Http\Request;

class ServiceSubcategoryController extends Controller
{
    protected $serviceSubcategory, $category, $service;

    public function  __construct(ServiceSubCategoryRepository $serviceSubcategory, ServiceCategoryRepository $category, ServiceRepository $service)
    {
        $this->serviceSubcategory = $serviceSubcategory;
        $this->category= $category;
        $this->service = $service;
    }

    public function show($slug){

        $subcategory = $this->serviceSubcategory->where('slug',$slug)->first();
        $categories = $this->category->where('is_active','1')->orderBy('created_at','desc')->get();
        $services = $this->service->where('subcategory_id',$subcategory->id)->orderBy('created_at','desc')->paginate(8);

        return view('servicesubcategory.show')->withSubcategory( $subcategory)->withServices( $services)->withCategories($categories);
    }

    public function getcategory(Request $request){
        $search = $request->get('term');

        $data = $this->category->where('name', 'LIKE', '%'. $search. '%')->get();


        return response()->json( $data);
    }
    public function getsubcategory(Request $request){
        $search = $request->get('term');
        $cat = $request->get('category');
        if(!empty( $cat))
        {
            $category = $this->category->where('name',$cat)->first();

            $data = $this->serviceSubcategory->where('category_id',$category->id)->where('title', 'LIKE', '%'. $search. '%')->get();

        }else {
            $data = $this->serviceSubcategory->where('title', 'LIKE', '%'. $search. '%')->get();

        }


        return response()->json( $data);
    }

    public function getTitle(Request $request){

        $search = $request->get('term');


        $data = $this->service;
        if(!empty($request->category)){

            $category = $this->category->where('name',$request->category)->first();
            $data = $this->service->where('category_id',$category->id)->where('title', 'LIKE', '%'. $search. '%');
        }
        if(!empty($request->subcategory) &&  empty($request->category)){
            $subcategory =$this->serviceSubcategory->where('title',$request->subcategory)->first();
            $data = $this->service->where('subcategory_id',$subcategory->id)->where('title', 'LIKE', '%'. $search. '%');

        }
        if(!empty($request->subcategory) &&  !empty($request->category)){
            $subcategory =$this->serviceSubcategory->where('title',$request->subcategory)->first();
            $data = $this->service->where('category_id',$category->id)->where('subcategory_id',$subcategory->id)->where('title', 'LIKE', '%'. $search. '%');

        }


        if(empty($request->category) && empty($request->subcategory) )
        {

            $data = $this->service->where('title', 'LIKE', '%'. $search. '%');

        }


        $service = $data->get();


        return response()->json( $service );
    }
}
