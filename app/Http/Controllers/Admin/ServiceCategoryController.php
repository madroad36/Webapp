<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ServiceCategory\ServiceCategoryStoreRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryUpdateRequest;
use App\Repositories\ServiceCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Gate;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $serviceCategory;

    public function __construct(ServiceCategoryRepository $serviceCategory)
    {
        $this->serviceCategory = $serviceCategory;
        $this->upload_path = DIRECTORY_SEPARATOR.'service-category'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');

    }

    public function index()
    {
        return view('layouts.backend.serviceCategory.view');
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
        return view('layouts.backend.serviceCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceCategoryStoreRequest $request)
    {
        $data = $request->except('_token');
        $data['is_active'] = isset($request->is_active) ? 1:0;
        $data['created_by'] = Auth::user()->id;
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'service-category/'.$fileName;

        }
        $data['name'] = strtolower($request->name);
        if($this->serviceCategory->firstOrCreate($data)){
            return redirect('admin/service_category')->with('success','Service category created successfully');
        }
        return redirect('admin/service_category')->back()->with('success','Service Category cannot created successfully');

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
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $category =  $this->serviceCategory->where('slug',$slug)->first();
        return view('layouts.backend.serviceCategory.edit')->withCategory($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceCategoryUpdateRequest $request, $id)
    {
        $servicecategory =  $this->serviceCategory->find($id);

        $data = $request->except('_token');
        $data['created_by'] = Auth::user()->id;
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'service-category/'.$fileName;
            if(Storage::exists($servicecategory->image)){
                Storage::delete($servicecategory->image);
            }

        }
        $data['name'] = strtolower($request->name);
        if($this->serviceCategory->update($servicecategory->id,$data)){
            return redirect('admin/service_category')->with('success','Service category updated successfully');
        }
        return redirect('admin/service_category')->back()->with('success','Service Category cannot updated successfully');
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
        $servicecategory = $this->serviceCategory->find($id);
        if($this->serviceCategory->destroy($servicecategory->id))
        {
            $message = 'Service Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);
        }
        return response()->json(['status'=>'ok','message'=>'Service cannot be delete'],422);
    }

    public function changeStatus(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $serviecategory = $this->serviceCategory->find($request->get('id'));
        if ($serviecategory->is_active == 0) {
            $status = '1';
            $message = 'Service Category with title "' . ucfirst($serviecategory->name) . '" is published.';
        } else {
            $status = '0';
            $message = 'Service Category with title "' . ucfirst($serviecategory->name) . '" is unpublished.';
        }

        $this->serviceCategory->changeStatus($serviecategory->id, $status);
        $this->serviceCategory->update($serviecategory->id, array('is_active' => $status));
        $updated = $this->serviceCategory->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'property' => $updated], 200);
    }

    public function getdata()
    {
        $servicecategories = $this->serviceCategory->orderBy('created_at','desc')->get();
        return \DataTables::of($servicecategories)
            ->addColumn('action', function ($servicecategories) {
                return '<a href="'.asset("admin/service_category/edit/$servicecategories->slug").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-Location"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
                        <a href="#"  data-type="'.$servicecategories->id.'" id="delete-service-category" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-Location"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  ';

            })
            ->addColumn('name',function($servicecategories){

                return  ucfirst($servicecategories->name);
            })   
            ->addColumn('created_by',function($servicecategories){

                return  ucfirst($servicecategories->user->name);
            })
            ->addColumn('image',function($servicecategories){

                return '<img style="width:100px; height:100px" src="'.asset('storage/'.$servicecategories->image).'">';

            })

            ->addColumn('status', function ($servicecategories) {
                if($servicecategories->is_active == '1')
                    return  '<a href="#"  data-type="'.$servicecategories->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($servicecategories->is_active == '0')   return  '<a href="#"  data-type="'.$servicecategories->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';
            })
            ->removeColumn('id')
            ->rawColumns(['action','created_by','status','image'])
            ->addIndexColumn()
            ->make(true);
    }
}
