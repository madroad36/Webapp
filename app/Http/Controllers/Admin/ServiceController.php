<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Repositories\LocationRepository;
use App\Repositories\PlaceRepository;
use App\Repositories\ServiceCategoryRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\ServiceSubCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Gate;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $service, $category,$location,$place,$subcategory;
    public function __construct(ServiceRepository $service, ServiceCategoryRepository $category,LocationRepository $location, PlaceRepository $place,ServiceSubCategoryRepository $subcategory)
    {
        $this->service = $service;
        $this->category = $category;
        $this->location = $location;
        $this->place =$place;
        $this->subcategory = $subcategory;

        $this->upload_path = DIRECTORY_SEPARATOR.'service'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    public function index()
    {

        return view('layouts.backend.service.view');
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
        $locations = $this->location->where('is_active','1')->orderBy('created_at','desc')->get();
        $categories = $this->category->where('is_active',1)->get();
        return view('layouts.backend.service.create')->withCategories($categories)->withLocations($locations);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceStoreRequest $request)
    {
        $data = $request->except('_token','image');

        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['thumbnail'] = 'service/'.$fileName;

        }
        $data['is_active'] =(isset($request['is_active'])) ? 1 : 0;
        $data['created_by'] = Auth::user()->id;
        $data['title'] = strtolower($request->title);
        if($this->service->create($data)){
            return redirect('admin/service')->with('success','Service Created Successfully');
        }
        return redirect()->back()->with('errors','Service Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $service = $this->service->where('slug',$slug)->first();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $locations = $this->location->where('is_active','1')->orderBy('created_at','desc')->get();
        $categories = $this->category->where('is_active',1)->get();
        $service = $this->service->where('slug',$slug)->first();
        return view('layouts.backend.service.edit')->withService($service)->withCategories($categories)->withLocations($locations);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceUpdateRequest $request, $id)
    {
        $service = $this->service->find($id);
        $data = $request->except('_token','image');

        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['thumbnail'] = 'service/'.$fileName;
            if(Storage::exists($service->thumbnail)){
                Storage::delete($service->thumbnail);
            }

        }
        $data['created_by'] = Auth::user()->id;
        $data['is_active'] =(isset($request['is_active'])) ? 1 : 0;

        if($this->service->update($service->id,$data)){
            return redirect('admin/service')->with('success','Service Updated Successfully');
        }
        return redirect()->back()->with('errors','Service Updated Successfully');
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
        $service = $this->service->find($id);

        if($this->service->destroy($service->id)){

            $message = 'Service Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);

    }

    public function changeStatus(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $service = $this->service->find($request->get('id'));
        if ($service->is_active == 0) {
            $status = '1';
            $message = 'service with title "' . $service->title . '" is published.';
        } else {
            $status = '0';
            $message = 'service with title "' . $service->title . '" is unpublished.';
        }

        $this->service->changeStatus($service->id, $status);
        $this->service->update($service->id, array('is_active' => $status));
        $updated = $this->service->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'service' => $updated], 200);
    }
    public function getdata(){

        $services = $this->service->orderBy('created_at','desc')->get();
        return \DataTables::of($services)
            ->addColumn('action', function ($services) {
                return '<a href="'.asset("admin/service/edit/$services->slug").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-Service"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
                        <a href="#"  data-type="'.$services->id.'" id="delete-service" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-Service"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  ';

            })
            ->addColumn('title',function($services){

                return  ucfirst($services->title);
            })
            ->addColumn('created_by',function($services){

                return  ucfirst($services->user->name);
            })
            ->addColumn('category',function($services){

                if(empty($services->category_id)){
                    return '--';
                }
                return  ucfirst($services->category->name);
            })

            ->addColumn('image',function($services){
                return '<img style="width:100px; height:100px" src="'.asset('storage/'.$services->thumbnail).'">';


            })
//            ->addColumn('location',function($services){
//                if(empty($services->location)){
//                    return '--';
//                }
//                return  $services->location->name;
//            })
//            ->addColumn('place',function($services){
//                if(empty($services->place)){
//                    return '--';
//                }
//                return  $services->place->name;
//            })
            ->addColumn('status', function ($services) {
                if($services->is_active == '1')
                    return  '<a href="#"  data-type="'.$services->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($services->is_active == '0')   return  '<a href="#"  data-type="'.$services->id.'" id="change-status" class="btn btn-xs btn-success unpublished" title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


            })
            ->removeColumn('id')
            ->rawColumns(['action','created_by','image','status','category','location','place'])
            ->addIndexColumn()
            ->make(true);
    }

    public function getsubcategory(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $subcategory = $this->subcategory->where('category_id', $request->category_id)->get();
        if($subcategory->isEmpty()){
            return response()->json(array('errors'=>false),422);
        }
        return response()->json(array('success'=>true,'subcategory'=>  $subcategory),200);
    }
}
