<?php

namespace App\Http\Controllers;

use App\Repositories\ProductImageRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    protected $productImage,$product;

    public function __construct(ProductImageRepository $productImage,ProductRepository $product)
    {
        $this->productImage = $productImage;
        $this->product =$product;
        $this->upload_path = DIRECTORY_SEPARATOR.'productImages'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    public function show($slug){
        $product = $this->product->where('slug',$slug)->first();
        return view('profile.product.image')->withProduct($product);
    }
    public function store(Request $request)
    {
        $data = $request->except(['file']);
        $file = $request->file('file');
        $file_name = $file->getClientOriginalName();
        $data['product_id'] = $request->id;
        $data['image'] = 'productImages/'.$file_name;
        $this->storage->put('productImages/'.$file_name, file_get_contents($file->getRealPath()));

        $this->productImage->create($data);

        $image = $this->productImage->where('product_id',$request->id)->get();

        return response()->json(['success' =>true, 'image'=>$image]);
    }

    public function destroy(Request $request){

        $filename =  $request->get('image');
        $fileId =  $request->get('id');
        if(!empty($filename)) {
            $this->productImage->where('image', 'productImages/' . $filename)->delete();
            $path = public_path() . '/productImages/' . $filename;
            if (file_exists($path)) {
                unlink($path);
            }
            return $filename;
        }

        $image = $this->productImage->find($fileId);
        $this->productImage->where('id',$fileId )->delete();
        $path = public_path() . '/productImages/' . $image->name;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success' =>true, 'image'=>$image]);


    }
}
