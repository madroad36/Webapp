<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\ServiceSubCategory\ServiceSubCategoryStoreRequest;
use App\Http\Requests\ServiceSubCategory\ServiceSubCategoryUpdateRequest;
use App\Repositories\ServiceCategoryRepository;
use App\Repositories\ServiceSubCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceSubCategoryController extends Controller
{
    protected $serviceCategory, $subcategory;
    public function __construct(ServiceCategoryRepository $serviceCategory, ServiceSubCategoryRepository $subcategory)
    {
        $this->serviceCategory = $serviceCategory;
        $this->subcategory = $subcategory;
        $this->upload_path = DIRECTORY_SEPARATOR.'service-subcategory'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');

    }

    public function index()
    {
        return view('layouts.backend.serviceSubcategory.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->serviceCategory->where('is_active','1')->get();
        return view('layouts.backend.serviceSubcategory.create')->withCategories($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceSubCategoryStoreRequest $request)
    {
        $data = $request->except('_token');
        $data['is_active'] = isset($request->is_active) ? 1:0;
        $data['created_by'] = Auth::user()->id;
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'service-subcategory/'.$fileName;

        }

        if($this->subcategory->create($data)){
            return redirect('admin/service_sub_category')->with('success','Service Subcategory created successfully');
        }
        return redirect('admin/service_sub_category')->back()->with('success','Service Subcategory cannot created successfully');

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
        $categories = $this->serviceCategory->where('is_active','1')->get();
        $subcategory =  $this->subcategory->where('slug',$slug)->first();
        return view('layouts.backend.serviceSubcategory.edit')->withSubcategory($subcategory)->withCategories($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceSubCategoryUpdateRequest $request, $id)
    {
        $subcategory =  $this->serviceCategory->find($id);

        $data = $request->except('_token');
        $data['created_by'] = Auth::user()->id;
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'service-category/'.$fileName;
            if(Storage::exists($subcategory->image)){
                Storage::delete($subcategory->image);
            }

        }

        if($this->serviceCategory->update($subcategory->id,$data)){
            return redirect('admin/service_sub_category')->with('success','Service Subcategory updated successfully');
        }
        return redirect('admin/service_sub_category')->back()->with('success','Service Subcategory cannot updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = $this->subcategory->find($id);
        if($this->subcategory->destroy($subcategory->id)){

            $message = 'Service  Subcategory Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Service cannot be delete'],422);
    }
    public function changeStatus(Request $request)
    {
        $subcategory = $this->subcategory->find($request->get('id'));
        if ($subcategory->is_active == 0) {
            $status = '1';
            $message = 'Service Subcategory with title "' . $subcategory->title . '" is published.';
        } else {
            $status = '0';
            $message = 'Service Subcategory with title "' . $subcategory->title . '" is unpublished.';
        }

        $this->subcategory->changeStatus($subcategory->id, $status);
        $this->subcategory->update($subcategory->id, array('is_active' => $status));
        $updated = $this->subcategory->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'property' => $updated], 200);
    }

    public function getdata(){
        $servicecategories = $this->subcategory->orderBy('created_at','desc')->get();

        return \DataTables::of($servicecategories)
            ->addColumn('action', function ($servicecategories) {
                return '<a href="'.asset("admin/service_sub_category/edit/$servicecategories->slug").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-Location"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
                        <a href="#"  data-type="'.$servicecategories->id.'" id="delete-service-subcategory" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-Location"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  ';

            })
            ->addColumn('category',function($servicecategories){

                return  $servicecategories->category->name;
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
            ->rawColumns(['action','category','status','image'])
            ->addIndexColumn()
            ->make(true);
    }
}
