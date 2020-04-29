<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Place\PlaceStoreRequest;
use App\Http\Requests\Place\PlaceUpdateRequest;
use App\Repositories\LocationRepository;
use App\Repositories\PlaceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    protected $place, $location;

    public function __construct(PlaceRepository $place, LocationRepository $location)
    {
        $this->location = $location;
        $this->place = $place;
    }

    public function index()
    {
        return view('user.place.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = $this->location->orderBy('created_by','desc')->get();

        return view('user.place.create')->withLocations($locations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlaceStoreRequest $request)
    {
        $data = $request->except('_token');
        $data['created_by']= Auth::user()->id;

        if($this->place->create($data)){
            return redirect('auth/place')->with('success','Place is created success');
        }
        return redirect()->back()->with('success','Place is created success');

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
    public function edit($slug)
    {

        $locations = $this->location->orderBy('created_by','desc')->get();
        $place = $this->place->where('slug',$slug)->first();
        return view('user.place.edit')->withPlace($place)->withLocations($locations);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlaceUpdateRequest $request, $id)
    {
        $place = $this->place->find($id);
        $data = $request->except('_token');
        $data['created_by']= Auth::user()->id;

        if($this->place->update($place->id,$data)){
            return redirect('auth/place')->with('success','Place is update success');
        }
        return redirect()->back()->with('success','Place is update success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = $this->place->find($id);

        if($this->place->destroy($place->id)){

            $message = 'Place Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Place cannot be delete'],422);
    }

    public function getdata(){
        $places = $this->place->orderBy('created_at','desc')->get();

        return \DataTables::of($places)
            ->addColumn('action', function ($places) {
                $data ='';
                if(auth()->user()->can('edit-place')) {
                    $data .= '<a href="' . asset("auth/place/edit/$places->slug") . '" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-Location"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>';
                    }
                if(auth()->user()->can('edit-place')) {
                      $data .='&nbsp; <a href="#"  data-type="'.$places->id.'" id="delete-location" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-Location"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  ';
                                  }
                                  return $data;

            })
            ->addColumn('created_by',function($places){

                return  $places->user->name;
            })
            ->addColumn('location',function($places){

                return  $places->location->name;
            })
            ->addColumn('status', function ($places) {
                if($places->is_active == '1')
                    return  '<a href="#"  data-type="'.$places->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($places->is_active == '0')   return  '<a href="#"  data-type="'.$places->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


            })
            ->removeColumn('id')
            ->rawColumns(['action','created_by','status','location'])
            ->addIndexColumn()
            ->make(true);
    }
}
