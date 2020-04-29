<?php

namespace App\Http\Controllers;

use App\Repositories\PropertyRepository;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;

class PropertyOwnerController extends Controller
{
    protected $property;
    public function __construct(PropertyRepository $property)
    {
        $this->property = $property;

    }

    public function index(){

        $properties = $this->property->where('created_by', Auth::user()->id)->orderBy('created_at','desc')->paginate('12');
        return view('profile.property.owner')->withProperties($properties);
    }

    public function edit($slug){
        dd($slug);
    }

    public function get_owner_property(){
        $id = Auth::user()->id;
        $propertys = $this->property->where('created_by',$id)->orderBy('created_at','desc')->get();
        return \DataTables::of($propertys)
        ->addColumn('action', function ($propertys) {
          return  '<a href="' . asset("property/edit/$propertys->slug") . '" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-property"
          data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
          <a href="' . asset("property_owner/property_image/create/$propertys->id") . '" class="btn btn-xs btn-info btn-icon btn-rounded"  title="Add-Property-Image" data-toggle="tooltip" > <i class="fa fa-image"></i></a>
          
          <a href="#"  data-type="' . $propertys->id . '" id="delete-property" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-property"
          data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>';



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
