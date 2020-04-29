<?php

namespace App\Http\Controllers;

use App\Repositories\BookingRepository;
use App\Repositories\ProductSellsReportRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{


    protected $booking, $productSell;


    public function __construct(BookingRepository $booking, ProductSellsReportRepository $productSell)
    {
        $this->productSell = $productSell;
        $this->booking = $booking;
    }

    public function index(){

        $propertypending = $this->booking->where('buyer_id',Auth::user()->id)->where('is_active','0')->count();
        $totalproperty = $this->booking->where('buyer_id',Auth::user()->id)->where('is_active','1')->count();
        $productpending = $this->productSell->where('buyer_id',Auth::user()->id)->where('is_active','0')->count();
        $totalproduct = $this->productSell->where('buyer_id',Auth::user()->id)->where('is_active','1')->count();

        return view('profile.transaction.index')
            ->withPropertypending($propertypending)->withTotalproperty($totalproperty)
            ->withProductpending($productpending)->withTotalproduct( $totalproduct);
    }
}
