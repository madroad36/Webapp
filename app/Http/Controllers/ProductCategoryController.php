<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    protected $product, $productCategory, $category, $service;

    public function __construct(ProductRepository $product, ProductCategoryRepository $productCategory, CategoryRepository $category,ServiceRepository $service)
    {
        $this->product = $product;
        $this->productCategory = $productCategory;
        $this->category = $category;
        $this->service = $service;
    }

    public function index(Request $request){
        $data = $this->productCategory->where('title', 'LIKE', '%' . $request->term . '%')->get();
        return response()->json($data);
    }

    public function show($slug)
    {
        $productCategory = $this->productCategory->where('slug',$slug)->first();
        $category = $this->productCategory->where('is_active', 1)->get();
        $products = $this->product->where('category_id',$productCategory->id)->where('is_active','1')->paginate(8);
        $services = $this->service->where('is_active','1')->paginate(8);
        return view('product.index')->withProducts($products)->withProductCategory($productCategory)->withServices($services )->withCategory($category);
    }

    public function autocompleteTitle(Request $request)
    {
        $search = $request->get('term');
        if(!empty($request->category)){
            $category = $this->productCategory->where('title',$request->category)->first();
            $data = $this->product->where('category_id',$category->id)->where('title', 'LIKE', '%'. $search. '%')->get();
        }else{
            $data = $this->product->where('title', 'LIKE', '%'. $search. '%')->get();

        }
        return response()->json( $data);
    }
}
