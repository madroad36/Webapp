<?php

namespace App\Http\Controllers;

use App\Repositories\ProductSellsReportRepository;
use Illuminate\Http\Request;
use Auth;

class ProductOrderController extends Controller
{
    protected $productSell;

    public function __construct(ProductSellsReportRepository $productSell)
    {
        $this->productSell = $productSell;
    }

    public function index(){
        $orders = $this->productSell->where('buyer_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(12);
        return view('profile.product.order')->withOrders($orders);
    }
    public function sold(){
        $orders = $this->productSell->where('owner_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(12);
        return view('profile.product.sold')->withOrders($orders);
    }
    public function show($id){
        $order = $this->productSell->find($id);

        return view('profile.product.product')->withOrder($order);
    }
    public function changeStatus(Request $request)
    {
        $product = $this->productSell->find($request->get('id'));
        if ($product->is_active == 0) {
            $status = '1';
            $message = 'product with title "' . $product->product->title . '" is sold.';
        } else {
            $status = '0';
            $message = 'product with title "' . $product->product->title . '" is unsold.';
        }

        $this->productSell->changeStatus($product->id, $status);
        $this->productSell->update($product->id, array('is_active' => $status));
        $updated = $this->productSell->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
}
