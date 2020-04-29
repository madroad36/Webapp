<?php

namespace App\Http\Controllers;

use App\Repositories\LocationRepository;
use App\Repositories\PlaceRepository;
use Illuminate\Http\Request;

class PlaceController extends Controller
{

    protected $place, $location;

    public function __construct(PlaceRepository $place, LocationRepository $location )
    {
        $this->place =$place;
        $this->location= $location;
    }

    public function getplace(Request $request){
        $place = $this->place->where('location_id', $request->location_id)->get();
        return response()->json(['success'=>true,'place'=>$place],200);
    }

    public function getlocation (Request $request){
        
        $search = $request->get('term');
        $data = $this->location->where('name', 'LIKE', '%'. $search. '%')->get();

        return response()->json( $data);
    }

    public function place(Request $request){
     
        $city = $request->get('city');
        $search = $request->get('term');
        $location = $this->location->where('name',$city)->first();

        $data = $this->place->where('location_id',$location->id)->where('name', 'LIKE', '%'. $search. '%')->get();
        return response()->json( $data);
    }
}
