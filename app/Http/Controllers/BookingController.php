<?php

namespace App\Http\Controllers;

use App\Events\Property\PropertyBooking;
use App\Events\Property\PropertySell;
use App\Listeners\Property\PropertySellListener;
use App\Mail\PropertyBook;
use App\Mail\PropertyBookingMail;
use App\Mail\PropertySelling;
use App\Models\Property;
use App\Repositories\BookingRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserTypeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    protected $booking, $property, $setting, $userType;

    public function __construct(BookingRepository $booking,UserTypeRepository $userType, PropertyRepository $property,SettingRepository $setting)
    {
        $this->booking = $booking;
        $this->property = $property;
        $this->setting=$setting;
        $this->userType = $userType;

    }


    public  function store(Request $request)
    {

        $data = $request->except('_token');
        $user = Auth::user();

        $property = $this->property->find($request->property_id);
        $data['property_id'] = $request->property_id;
        $data['buyer_id'] = $user->id;

        $booking = $this->booking->where('property_id',$property->id)->where('buyer_id',$user->id)->get();

        if($booking->isEmpty()) {
            if ($this->booking->create($data)) {
                $booking= $this->booking->latestFirst();
                $this->orderProperty($property,$booking);
                if ($request->ajax()) {
                    $message= 'Thank You For Confirming property we will contact you soon at ';
                    return response()->json(['success' => true,'message'=>$message ,'user' => $user], 200);
                }

            }
        }
        $message= 'You have already book this property ';

        return response()->json(['success' => true,'message'=>$message, 'user' => $user], 200);

    }

    public  function order(Request $request, $id)
    {
        $data = $request->except('_token');
        $user= Auth::user();

        $property = $this->property->find($id);

        $data['property_id'] = $property ->id;
        $data['buyer_id'] = $user->id;
        $booking = $this->booking->where('property_id',$property->id)->where('buyer_id',$user->id)->get();

        if($booking->isEmpty()) {
            if ($this->booking->create($data)) {
                $booking= $this->booking->latestFirst();
                $this->orderProperty($property,$booking);

                return redirect()->route('property.show', [$property->slug])->with('success', 'we will contact you soon');
            }
        }
        return redirect()->route('property.show', [$property->slug])->with('success', 'You have already book this property');
    }

    public function orderdProperty()
    {
        $booked = $this->booking->where('buyer_id',Auth::user()->id)->pluck('property_id');
        $properties = Property::whereIn('id',$booked)->orderBy('created_at','desc')->paginate('10');
        return view('profile.property.order')->withProperties($properties);
    }

    public function update($id)
    {
        $property = $this->property->find($id);
        $booking = $this->booking->where()->first();
    }

    public function changeStatus(Request $request)
    {
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
        $usertype = $this->userType->where('name','admin')->first();

        $book['receiver_id'] = $usertype->user->id;
        $book['message']='Property Booking';


        event (new PropertySell($book));


        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }

    public function sendingEmail($property,$booking,$message)
    {
        $companyemail = $this->setting->where('slug', 'to-email')->first();
        $companyname = $this->setting->where('title', 'Company Name')->first();
        Mail::to($booking->user->email)->send(new PropertySelling($property, $booking,$message,$companyemail,$companyname));
    }

    public  function orderProperty($property,$booking)
    {
        $usertype = $this->userType->where('name','admin')->first();
        $book['receiver_id'] = $usertype->user->id;
        $book['message']= 'Property Booking';
        event  (new PropertyBooking($book));
        $companyemail = $this->setting->where('slug', 'to-email')->first();
        $companyname = $this->setting->where('title', 'Company Name')->first();
        Mail::to($property->user->email)->send(new  PropertyBookingMail($property, $booking,$companyemail,$companyname));
    }
}
