<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\ProductImageRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $productImage,$product;

    public function __construct(ProductImageRepository $productImage,ProductRepository $product)
    {
        $this->productImage = $productImage;
        $this->product =$product;
        $this->upload_path = DIRECTORY_SEPARATOR.'productImages'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    public function index($id)
    {
        $product = $this->product->find($id);
        $images = $this->productImage->where('product_id',$id)->get();
        return view('user.product.image')->withImages($images)->withProduct($product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $product = $this->product->find($id);
        return view('user.product.upload')->withProduct($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,  $id)
    {
        $data = $request->except(['file']);
        $file = $request->file('file');
        $file_name = time()."_".$file->getClientOriginalName();
        $data['product_id'] = $id;
        $data['image'] = 'productImages/'. $id. '/' .$file_name;
        $this->storage->put('productImages/'.$id.'/'.$file_name, file_get_contents($file->getRealPath()));

        $this->productImage->create($data);
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
        $product = $this->productImage->find($id);

        if($this->productImage->destroy($product->id)){

            $message = 'Product Image Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);

    }
}
