<?php

namespace App\Http\Controllers\Admin;

use App\Events\Property\bookingsell;
use App\Events\Property\PropertySell;
use App\Mail\PropertySelling;
use App\Repositories\BookingRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Gate;

class PropertyBookingController extends Controller
{
    protected $property,$booking,$setting;
    public function __construct(PropertyRepository $property, BookingRepository $booking,SettingRepository $setting)
    {
        $this->property = $property;
        $this->booking =$booking;
        $this->setting = $setting;
    }
    
    public function index(){
        return view('layouts.backend.propertyBooking.index');
    }

    public function getbooking(){

        $bookings = $this->booking->orderBy('updated_at','desc')->get();

        return \DataTables::of($bookings)
            ->addColumn('title',function($bookings){

                return  $bookings->property->title;
            })
            ->addColumn('buyer',function($bookings){

                return  $bookings->user->name;
            })
            ->addColumn('owner',function($bookings){

                return  $bookings->property->user->name;
            })
            ->addColumn('price',function($bookings){

                return  $bookings->property->price;
            })
            ->addColumn('category',function($bookings){

                return  $bookings->property->category->name;
            })
            ->addColumn('subcategory',function($bookings) {
                if (!empty($bookings->property->subcategory_id)){
                    return $bookings->property->subcategory->title;
                }
                else{
                    return '---';
                }


            })
            
            ->addColumn('action', function ($bookings) {
                if($bookings->is_active == '1')
                    return  '<a href="#"  data-type="'.$bookings->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($bookings->is_active == '0')   return  '<a href="#"  data-type="'.$bookings->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


            })
            ->removeColumn('id')
            ->rawColumns(['action','buyer','owner','category','subcategory','price','title'])
            ->addIndexColumn()
            ->make(true);
    }
    public function changeStatus(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $booking = $this->booking->find($request->id);
        $property = $this->property->where('id',$booking->property_id)->first();

        if ($booking->is_active == 0) {
            $status = '1';
            $props['is_active']='0';
            $props['paid'] = '1';
            $message =  $booking->property->title . ' is sold to '.$booking->user->name .'.';
        } else {
            $status = '0';
            $props['is_active']='0';
            $props['paid'] = '1';
            $message =  $booking->property->title . 'is not unsold to '.$booking->user->name .'.';
        }
        $this->booking->changeStatus($booking->id, $status);
        $this->booking->update($booking->id, array('is_active' => $status));
        $this->property->update($property->id,$props);
        $updated = $this->booking->find($request->get('id'));
//        $this->sendingEmail($property,$booking,$message);

        $companyemail = $this->setting->where('slug', 'to-email')->first();
        $companyname = $this->setting->where('title', 'Company Name')->first();
        // if($booking->user->email){
        // Mail::to($booking->user->email)->send(new PropertySelling($property, $booking,$message,$companyemail,$companyname));
        // }

        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }

}
