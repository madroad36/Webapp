<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Location\LocationStoreRequest;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Gate;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $location;

    public  function __construct(LocationRepository $location)
    {
        $this->location = $location;
        

    }

    public function index()
    {
        return view('layouts.backend.location.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        return view('layouts.backend.location.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationStoreRequest $request)
    {
        $data = $request->except('_token');

        $data['created_by'] =Auth::user()->id;
        $data['is_active'] ='0';

        if($this->location->create($data)){
            return redirect('admin/location')->with('success', 'Location is created successfully');
        }
        return redirect('admin/location')->with('errors', 'Location cannot be created successfully');


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
    public function edit($id)
    {
        if(!Gate::allows('isAdmin')){
           return redirect()->back()->with('warning','Unauthorized Access.');
        }
        $location = $this->location->find($id);

        return view('layouts.backend.location.edit')->withLocation($location);
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
        $data = $request->except('_token');
        $location = $this->location->find($id);
        $data['created_by'] =Auth::user()->id;
        if($this->location->update($location->id,$data)){
            return redirect('admin/location')->with('success', 'Location is created successfully');
        }
        return redirect('admin/location')->with('errors', 'Location cannot be created successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
         $location = $this->location->find($id);

         if($this->location->destroy($location->id)){

             $message = 'Location Delete Successfully';
             return response()->json(['status'=>'ok','message'=>$message],200);

         }
         return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);

     }
    public function changeStatus(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $location = $this->location->find($request->get('id'));
        if ($location->is_active == 0) {
            $status = '1';
            $message = 'Location with title "' . $location->name . '" is published.';
        } else {
            $status = '0';
            $message = 'Location with title "' . $location->name . '" is unpublished.';
        }

        $this->location->changeStatus($location->id, $status);
        $this->location->update($location->id, array('is_active' => $status));
        $updated = $this->location->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function getdata(){

        $locations = $this->location->orderBy('created_at','desc')->get();

        return \DataTables::of($locations)
            ->addColumn('action', function ($locations) {
                return '<a href="'.asset("admin/location/edit/$locations->id").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-Location"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
                        <a href="#"  data-type="'.$locations->id.'" id="delete-location" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-Location"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  ';

            })
            ->addColumn('status', function ($locations) {
             if($locations->is_active == '1')
                 return  '<a href="#"  data-type="'.$locations->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
             data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

             if($locations->is_active == '0')   return  '<a href="#"  data-type="'.$locations->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
             data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


         })
            ->removeColumn('id')
            ->rawColumns(['action','status'])
            ->addIndexColumn()
            ->make(true);
    }
}
