<?php

namespace App\Http\Controllers;


use App\Http\Requests\Product\ProductStoreRequest;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Auth;

class OwnerProductController extends Controller
{
    protected $productCategory, $product;

    public function __construct(ProductRepository $product, ProductCategoryRepository $productCategory)
    {
        $this->productCategory = $productCategory;
        $this->product = $product;

    }

    public function index()
    {
        $products = $this->product->where('created_by', Auth::user()->id)->orderBy('created_at','desc')->paginate(20);
        return view('profile.product.view')->withProducts(  $products);
    }


    public function destroy($id)
    {
        $product = $this->product->find($id);
        $products = $this->product->where('created_by', Auth::user()->id)->orderBy('created_at','desc')->paginate(20);


        if($this->product->destroy($product->id)){

            $message = 'Product Delete Successfully';

           return view('profile.product.tablist')->withProducts( $products );

        }

        return response()->json(['status'=>'ok','message'=>'Product cannot be delete'],422);

    }
    public function changeStatus(Request $request)
    {
        $product = $this->product->find($request->get('id'));
        if ($product->is_active == 0) {
            $status = '1';
            $message = 'product with title "' . $product->title . '" is published.';
        } else {
            $status = '0';
            $message = 'product with title "' . $product->title . '" is unpublished.';
        }

        $this->product->changeStatus($product->id, $status);
        $this->product->update($product->id, array('is_active' => $status));
        $updated = $this->product->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function paid(Request $request)
    {
        $product = $this->product->find($request->get('id'));
        if ($product->paid == 0) {
            $status = '1';
            $message = 'product with title "' . $product->title . '" is paid.';
        } else {
            $status = '0';
            $message = 'product with title "' . $product->title . '" is unpaid.';
        }

        $this->product->changeStatus($product->id, $status);
        $this->product->update($product->id, array('paid' => $status));
        $updated = $this->product->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function getdata(){

        $product = $this->product->where('created_by', Auth::user()->id)->orderBy('created_at','desc')->get();
        return \DataTables::of($product)
            ->addColumn('action', function ($product) {
                return '<a href="'.asset("product/edit/$product->slug").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-Product"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
                                 
                        <a href="#"  data-type="'.$product->id.'" id="delete-product" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-Product"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  ';

            })
            ->addColumn('created_by',function($product){

                return  $product->user->name;
            })
            ->addColumn('category',function($product){

                return  $product->category->title;
            })
            ->addColumn('image',function($product){
                return '<img style="width:100px; height:100px" src="'.asset('storage/'.$product->image).'">';


            })
            ->addColumn('status', function ($product) {
                if($product->is_active == '1')
                    return  '<a href="#"  data-type="'.$product->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($product->is_active == '0')   return  '<a href="#"  data-type="'.$product->id.'" id="change-status" class="btn btn-xs btn-success unpublished" title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


            })
            ->addColumn('paid', function ($product) {
                if($product->paid == '1')
                    return  '<a href="#"  data-type="'.$product->id.'" id="paid" class="btn btn-xs btn-warning published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($product->paid == '0')   return  '<a href="#"  data-type="'.$product->id.'" id="paid" class="btn btn-xs btn-warning unpublished" title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


            })
            ->removeColumn('id')
            ->rawColumns(['action','created_by','image','status','category','paid'])
            ->addIndexColumn()
            ->make(true);
    }
}
