<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\SubcategoryRepository;
use Illuminate\Http\Request;

class PropertySubcategoryController extends Controller
{
    protected $propertySubcategory;

    public function __construct(SubcategoryRepository $propertySubcategory)
    {
        $this->propertySubcategory =$propertySubcategory;
    }


    public function getsubcategory(Request $request){
        $sucategory = $this->propertySubcategory->where('category_id',$request->category_id)->where('is_active','1')->inRandomOrder()->get();

        if($sucategory->isEmpty()){
            return response()->json(array('success'=>false));
        }
        return response()->json(array('success'=>true,'sucategory'=>  $sucategory));
    }
}
