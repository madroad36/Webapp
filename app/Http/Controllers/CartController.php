<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CartStoreRequest;
use App\Events\Product\ProductSell;
use App\Mail\AdminCart;
use App\Mail\UserCart;
use App\Mail\VendroCart;
use App\Models\Cart;
use App\Repositories\ProductRepository;
use App\Repositories\ProductSellsReportRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use Mail;
use App\Repositories\UserTypeRepository;



class CartController extends Controller
{


    protected $product, $setting, $user,$productSellReport;

    public function __construct(ProductRepository $product, 
                                SettingRepository $setting,
                                UserTypeRepository $userType,
                                 UserRepository $user,ProductSellsReportRepository $productSellReport)
    {
        $this->product = $product;
        $this->setting = $setting;
        $this->user = $user;
        $this->userType = $userType;
        $this->productSellReport = $productSellReport;
    }

    public function index()
    {
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
        return view('profile.cart.index')->withCart($cart)->withTotalprice($cart->totalPrice)->withTotalItem($cart->totalItem);
    }

    public function store(CartStoreRequest $request)
    {


        $product = $this->product->find($request->id);

        if ($request->ajax()) {

            $oldCart = Session::has('cart') ? Session::get('cart') : null;



            $cart = new Cart($oldCart);
            $peice = $request->quantity;
            $slug = $product->category->slug;
            $cart->add($product, $product->id, $peice,$slug);
            $product = Session::put('cart', $cart);
            $oldcart = Session::get('cart');
            $cart = new Cart($oldcart);
            return view('profile.cart.list')->withCart($cart);
        }

        $oldCart = Session::has('cart') ? Session::get('cart') : null;



        $cart = new Cart($oldCart);
        $peice = $request->quantity;
        $location='';
        $slug = $product->category->slug;
        $cart->add($product, $product->id, $peice,$slug,$location);
        $product = Session::put('cart', $cart);
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
        return view('profile.cart.index')->withCart($cart)->withTotalprice($cart->totalPrice)->withTotalItem($cart->totalItem)->with('success', 'Product added successfully');
    }

    public function checkout(Request $request)
    {


        $buyer = Auth::user();
       

        $products = Session::get('cart');
        $location = Session::get('location');

        if (empty($products)) {
            return redirect()->back()->with('flaserror', 'please add the product to cart');
        }

        $ownerProduct = [];
        $email = [];
        $admin = $this->setting->where('title', 'Email')->first();
        $companyemail = $this->setting->where('slug', 'to-email')->first();
        $companyname = $this->setting->where('title', 'Company Name')->first();

        $product = $this->productSellReport->latestFirst();

        $token = $this->batch($product);

        foreach ($products->items as $product) {
            $user = $this->user->where('id', $product['item']['created_by'])->first();
            $email[$user->email] [] = $product;
            $ownerProduct[] = [
                'owner_id' => $user->id,
                'product_id' => $product['item']['id'],
                'quantity' => $product['peice'],
                'buyer_id' => Auth::user()->id,
                'location' => $location,
                'serial_number' =>$token,
                'is_active' => 0,
                'created_at' => Carbon::now()
            ];
        }
       
           
        $this->productSellReport->insert($ownerProduct);
    
        $usertype = $this->userType->where('name','admin')->first();
       
         $productbooking['receiver_id'] =$usertype->user->id;
        $productbooking['message']='Product Ordered '.$token;
       
        event (new ProductSell($productbooking));

        if ($admin) {
        Mail::to($admin->value)->send(new AdminCart($products, $companyname, $companyemail, $user));
        }
        // if ($buyer->email) {
        // Mail::to($buyer->email)->send(new UserCart($products, $companyname, $companyemail, $buyer));
        // }
       
       // foreach ($email as $key => $productowner) {
       //     $owner = $this->user->where('email', $key)->first();
       //     Mail::to($key)->send(new VendroCart($productowner, $companyemail, $companyname, $buyer, $owner));
       // }
    $users = Auth::user();
        Session::forget('cart');
        \Cache::forget('cart');
    //    $request->session()->flush('cart');
    
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $users = Auth::user();

        if ($request->ajax()) {
            return view('profile.cart.list')->withCart($cart)->withUsers($users);
        }
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);
//        dd(Auth::user());

        return redirect()->route('cart.index')->with('cart-message','Product order has been place we will contact you soon ');


    }
    public function location(Request $request){

        $address = $request->location;
        $location = $request->session()->put('location', $address);
        return response()->json(['success'=>true],200);
    }
    public function flush(Request $request){
        Session::forget('cart');
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        return view('profile.cart.index')->withCart($cart)->with('cart-message','Cart singel record has been flush');

    }

    public function remove($id){

       $data = Session::get('cart');
        unset($data->items[$id]);
        $oldcart = Session::get('cart');
        $cart = new Cart($oldcart);

        return view('profile.cart.index')->withCart($cart)->with('cart-message','Cart singel record has been flush');

    }

    public function batch($product){
        if (empty($product->serial_number)) {
            return  'sell-01';
        } else {
            return  ++$product->serial_number;
        }
    }

}
