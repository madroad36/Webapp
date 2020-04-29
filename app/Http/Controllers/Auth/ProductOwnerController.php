<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Product\ProductStoreRequest;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Auth;

class ProductOwnerController extends Controller
{
    protected $productCategory, $product;

    public function __construct(ProductRepository $product, ProductCategoryRepository $productCategory)
    {
        $this->productCategory = $productCategory;
        $this->product = $product;
        $this->upload_path = DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    public function index()
    {
        return view('user.product-owner.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->productCategory->where('is_active','1')->get();
        return view('user.product.create')->withCategories($categories);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $data = $request->except('_token','image');

        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'product/'.$fileName;

        }
        $data['paid'] =(isset($request['paid'])) ? 1 : 0;
        $data['is_active'] =(isset($request['is_active'])) ? 1 : 0;
        $data['created_by'] = Auth::user()->id;
        if($this->product->create($data)){
            return redirect('auth/product')->with('success','Product Created Successfully');
        }
        return redirect()->back()->with('errors','Product Created Successfully');
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
    public function edit($slug)
    {
        $product = $this->product->where('slug',$slug)->first();
        $categories = $this->productCategory->where('is_active','1')->get();
        return view('user.product-owner.edit')->withCategories($categories)->withProduct($product);
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
        $product = $this->product->find($id);

        $data = $request->except('_token','image');

        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'product/'.$fileName;
            if(Storage::exists($product->image)){
                Storage::delete($product->image);
            }

        }
        $data['paid'] =(isset($request['paid'])) ? 1 : 0;
        $data['is_active'] =(isset($request['is_active'])) ? 1 : 0;
        $data['created_by'] = Auth::user()->id;
        if($this->product->update($product->id,$data)){
            return redirect('auth/product_owner')->with('success','Product Update Successfully');
        }
        return redirect()->back()->with('errors','Product CannotUpdate Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd($id);
        $product = $this->product->find($id);

        if($this->product->destroy($product->id)){

            $message = 'Product Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);

    }

    public function getdata(){

        $product = $this->product->where('created_by',Auth::user()->id)->orderBy('created_at','desc')->get();


        return \DataTables::of($product)
            ->addColumn('action', function ($product) {
                $data ='';
                if(auth()->user()->can('edit-product')) {
                    $data .= '<a href="' . asset("auth/product_owner/edit/$product->slug") . '" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-Product"
                                  data-toggle="tooltip" > <i class="fa fa-edit"></i></a>';
                }
                if(auth()->user()->can('add-product-image')) {
                    $data .=  '&nbsp;<a href="' . asset("auth/product_image/create/$product->id") . '" class="btn btn-xs btn-info btn-icon btn-rounded"  title="Edit-Product"
                                  data-toggle="tooltip" > <i class="fa fa-image"></i></a>';
                }
                if(auth()->user()->can('delete-product')) {
                    $data .= '&nbsp;<a href="#"  data-type="' . $product->id . '" id="delete-product" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-Product"
                                  data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                 ';
                }
                return $data;

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
                    if ($product->is_active == '1')
                        return '<a href="javascript:void(0)"  data-type="' . $product->id . '" id="change-status" class="btn btn-xs btn-success unpublished" title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                    if ($product->is_active == '0') return '<a href="javascript:void(0)"  data-type="' . $product->id . '" id="change-status" class="btn btn-xs btn-success unpublished" title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';

            })
            ->addColumn('paid', function ($product) {
                if(auth()->user()->can('changestatus-product')) {
                    if ($product->paid == '1')
                        return '<a href="javascript:void(0)"  data-type="' . $product->id . '" id="paid" class="btn btn-xs btn-warning published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                    if ($product->paid == '0') return '<a href="javascript:void(0)"  data-type="' . $product->id . '" id="paid" class="btn btn-xs btn-warning unpublished" title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';
                }

            })
            ->removeColumn('id')
            ->rawColumns(['action','created_by','image','status','category','paid'])
            ->addIndexColumn()
            ->make(true);
    }
}
