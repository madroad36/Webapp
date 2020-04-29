<?php

namespace App\Http\Controllers;

use App\Events\Product\ProductCreated;
use App\Http\Requests\Product\ProductStoreRequest;
//use App\Helper\Product\ProductStoreNotification;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCatergory;
use App\Models\Property;
use App\Notifications\Product\ProductStoreNotification;
use App\Repositories\CategoryRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserTypeRepository;
use Illuminate\Http\Request;
use Notification;
use Illuminate\Support\Facades\Storage;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $product, $productCategory, $category, $service, $settting, $userType, $notification;

    public function __construct(ProductRepository $product,
        ProductCategoryRepository $productCategory,
        CategoryRepository $category,
        ServiceRepository $service,
        SettingRepository $setting,
        UserTypeRepository $userType,
        NotificationRepository $notification
    )
    {
        $this->product = $product;
        $this->productCategory = $productCategory;
        $this->category = $category;
        $this->service = $service;
        $this->setting = $setting;
        $this->userType = $userType;
        $this->notification = $notification;
        $this->upload_path = DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');

    }

    public function index($slug)
    {
       $productCategory = $this->productCategory->where('slug',$slug)->first();
       $products = $this->product->where('category_id',$productCategory->id)->orderBy('created_at','desc')->where('is_active','1')->paginate(20);
       $services = $this->service->where('is_active','1')->paginate(8);
       return view('product.index')->withProducts($products)->withProductCategory($productCategory)->withServices($services );
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->productCategory->where('is_active','1')->get();
        return view('profile.product.create')->withCategories( $categories);
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
        $usertype = $this->userType->where('name','admin')->first();

        if($this->product->create($data)){
            $product = $this->product->latestFirst();
            $usertype = $this->userType->where('name','admin')->first();
//            $notification['link'] = route('product.show',[$product->slug]);
//            $notification['message'] = 'New Product has been added';
//            $notification['icon'] = '<i class="fa fa-plus"></i>';
//            $notification['receiver_id'] = $usertype->user->id;
//            $this->notification->create( $notification);
            $product['receiver_id'] =$usertype->user->id;

            event(new ProductCreated($product));

            return response()->json(['success'=>true,'product'=>$product],200);
        }
        return redirect()->back()->with('errors','Product cannot Created Successfully');
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
        $categorylist = $this->productCategory->where('is_active','1')->get();
        $product = $this->product->where('slug',$slug)->first();
        return view('product.show')->withProduct($product)->withCategorylist($categorylist)->withCategories($categories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $categories = $this->productCategory->where('is_active','1')->get();
        $product = $this->product->where('slug',$slug)->first();
        return view('profile.product.edit')->withCategories( $categories)->withProduct($product);
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

        $data = $request->except('_token','image');
        $product = $this->product->find($id);
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'product/'.$fileName;

        }
        $data['paid'] =(isset($request['paid'])) ? 1 : 0;
        $data['is_active'] =(isset($request['is_active'])) ? 1 : 0;
        $data['created_by'] = Auth::user()->id;
        if($this->product->update($product->id,$data)){

            return response()->json(['success'=>true,'product'=>$product,'images'=>$product->images],200);
        }
        return redirect()->back()->with('errors','Product cannot Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->product->find($id);

        if($this->product->destroy($product->id)){
            $products = $this->product->where('created_by', Auth::user()->id)->orderBy('created_at','desc')->paginate(20);

            return view('profile.product.tablist')->withProducts( $products );

        }
        return response()->json(['status'=>'ok','message'=>'Product cannot be delete'],422);
    }

    public function getcategory(Request $request){

        $category = $this->product->where('category_id',$request->category_id)->orderBy('created_at','desc')->get();
        if($category->isEmpty()){
            return response()->json(array('success'=>false));
        }
        return response()->json(array('success'=>true,'category'=>  $category));
    }

    public function search(Request $request)
    { 
        $productCategory = $this->productCategory->find($request->category);
        $query = $this->product->where('is_active', '1')->latest()->take(25)->get();
        if(!empty($request->category_id))
        {
            $search = strtolower($request->category_id);
            $category = $this->productCategory->where('title','like', '%'.$search.'%')->where('is_active',1)->first();
            if($category){
                $query = $this->product->where('is_active', '1')->where('category_id', $category->id)->latest()->take(25);
            }  
            else
            {
                $query = collect([]);
            }

        } 

        //Title Search
        if(!empty($request->title))
        {
            $search = strtolower($request->title);
            // dd($query);
            $product = $this->product->where('title','like', '%'.$search.'%')->where('is_active',1)->get();
            if(count($product) > 0)
            {
                foreach($product as $product)
                {
                    $query = $this->product->where('title', $product->title)->where('is_active',1)->latest()->take(25);
                }
            }
            else
            {
                $query = collect([]);
            }
        }

        if(!empty($request->low) && !empty($request->high)) {
            $query = $this->product->where('is_active', '1')->latest()->take(25)->whereBetween('price', [(int)$request->low, (int)$request->high]);
        }

        if(!empty($request->low) && empty($request->high)){
            $query = $query->where('price','>=',(int)$request->low);
        }

        if(!empty($request->high) && empty($request->low)){
            $query = $query->where('price','<=',(int)$request->high);
        }

        if(empty($request->category_id) && empty($request->title) && empty($request->low) && empty($request->high) && empty($request->lowest) && empty($request->higest)){
            $products =$this->product->where('category_id',$productCategory->id)->paginate(8);
            return view('product.search')->withProducts($products)->withProductCategory($productCategory);;
        }

        if($request->has('lowest')) 
        {
            $products  = Product::where('category_id',$request->category)->where('is_active', '1')->orderBy('price','asc')->paginate(8);
            return view('product.search')->withProducts($products)->withProductCategory($productCategory);
        }

        if($request->has('higest'))
        {
            $products = Product::where('category_id',$request->category)->where('is_active', '1')->orderBy('price','desc')->paginate(8);
            return view('product.search')->withProducts($products)->withProductCategory($productCategory);
        }
        $products = $query->paginate(8);
        return view('product.search')->withProducts($products)->withProductCategory($productCategory);;
    }
    
    public function autocomplete(Request $request,$id)
    {


        $search = $request->get('term');

        $data = $this->product->where('category_id',$id)->where('title', 'LIKE', '%'. $search. '%')->get();


        return response()->json( $data);
    }

    public function perpage(Request $request){

        $products =Product::paginate(5, ['*'], 'page', $request->page);
        return view('product.search')->withProducts($products);

    }

    public function homesearch( request$request)
    {

        $query = new Product();
        if(!empty($request->category_id)){
            $category = $this->productCategory->where('id',$request->category_id)->first();
            $query = $query->where('category_id',$category->id);
            $productCategory = $this->productCategory->find($request->category_id);

        }
        if(empty($request->category_id)){
            $productCategory = ProductCatergory::inRandomOrder()->first();

        }
        if(!empty($request->title)){
            $query = $query->where('title',$request->title);
        }

        $products = $query->paginate(8);
        return view('product.search')->withProducts($products)->withProductCategory($productCategory);;

    }

}





