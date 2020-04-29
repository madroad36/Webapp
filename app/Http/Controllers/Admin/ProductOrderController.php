<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ProductSellsReportRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

class ProductOrderController extends Controller
{
    protected $ordersSellOrder;

    public  function __construct(ProductSellsReportRepository $ordersSellOrder)
    {
        $this->ordersSellOrder= $ordersSellOrder;
    }

    public function index(){
        return view('layouts.backend.product.orderlist');
    }
    

    public function changeStatus(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $order = $this->ordersSellOrder->find($request->get('id'));
        if ($order->is_active == 0) {
            $status = '1';
            $message = 'order with title "' . $order->product->title . '" is published.';
        } else {
            $status = '0';
            $message = 'order with title "' . $order->product->title . '" is unpublished.';
        }
        $this->ordersSellOrder->changeStatus($order->id, $status);
        $this->ordersSellOrder->update($order->id, array('is_active' => $status));
        $updated = $this->ordersSellOrder->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }

    public function getdata(){
        
        $orders = $this->ordersSellOrder->orderBy('created_at','desc')->get();
        return \DataTables::of($orders)
            ->addColumn('action', function ($orders) {
                return '<a href="javascript:void(0)"  data-type="'.$orders->id.'" id="view-order"  class="btn btn-xs btn-danger btn-icon btn-rounded"  title="view-orders"
                                   ><i class="fa fa-eye" aria-hidden="true"></i></a>
                                   ';


            })
            ->addColumn('title',function($orders){

                return  $orders->product->title;
            })
            ->addColumn('owner',function($orders){

                return  $orders->owner->name;
            })
            ->addColumn('buyer',function($orders){

                return  $orders->buyer->name;
            })
            ->addColumn('contact',function($orders){

                return  $orders->buyer->contact;
            })
            ->addColumn('price',function($orders){

                return  $orders->quantity * $orders->product->price;
            })
            ->addColumn('status', function ($orders) {
                if($orders->is_active == '1')
                    return  '<a href="#"  data-type="'.$orders->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($orders->is_active == '0')   return  '<a href="#"  data-type="'.$orders->id.'" id="change-status" class="btn btn-xs btn-success unpublished" title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


            })

            ->removeColumn('id')
            ->rawColumns(['action','owner','buyer','title','status','contact','price'])
            ->addIndexColumn()
            ->make(true);
    }

    public function show($id){
        $order = $this->ordersSellOrder->find($id);

        return view('layouts.backend.product.orderdetail')->withOrder($order);
    }
}
