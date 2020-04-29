<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SliderRepository;
use App\Repositories\UserRepository;
use App\Http\Requests\Slider\SliderStoreRequest;
use App\Http\Requests\Slider\SliderUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Auth;
use Session;
use Gate;

class SliderController extends Controller
{
    protected $slider;

    public function __construct(SliderRepository $slider)
    {
        $this->slider = $slider;
        $this->upload_path = DIRECTORY_SEPARATOR.'slider'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    public function index()
    {
        return view('layouts.backend.slider.view');
    }

    public function create()
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Sorry");
        }
        return view('layouts.backend.slider.create');
    }

    public function store(SliderStoreRequest $request)
    {
        $data = $request->except('_token');
        $data['status'] = isset($request->status) ? 1:0;
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'slider/'.$fileName;

        }
        if($this->slider->firstOrCreate($data)){
            return redirect()->route('admin.slider.index')->with('success','Slider created successfully');
        }
        return redirect()->back()->with('success','Slider cannot created successfully');

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
            abort(404,"Sorry");
        }
        $slider =  $this->slider->where('id',$id)->first();
        return view('layouts.backend.slider.edit')->withslider($slider);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderUpdateRequest $request, $id)
    {
        $slider =  $this->slider->find($id);

        $data = $request->except('_token');
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'slider/'.$fileName;
            if(Storage::exists($slider->image)){
                Storage::delete($slider->image);
            }

        }
        if($this->slider->update($slider->id,$data)){
            return redirect()->route('admin.slider.index')->with('success','Slider updated successfully');
        }
        return redirect()->back()->with('success','Slider cannot updated successfully');
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
            abort(404,"Sorry");
        }
        $slider = $this->slider->find($id);
        if($this->slider->destroy($slider->id))
        {
            $message = 'Slider Deleted Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);
        }
        return response()->json(['status'=>'ok','message'=>'Service cannot be delete'],422);
    }

    public function changeStatus(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Sorry");
        }
        $slider = $this->slider->find($request->get('id'));
        if ($slider->status == 0) {
            $status = '1';
            $message = 'slider with title "' . ucfirst($slider->section) . '" is published.';
        } else {
            $status = '0';
            $message = 'slider with title "' . ucfirst($slider->section) . '" is unpublished.';
        }

        $this->slider->changeStatus($slider->id, $status);
        $this->slider->update($slider->id, array('status' => $status));
        $updated = $this->slider->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'property' => $updated], 200);
    }

    public function getdata()
    {
        $slider = $this->slider->orderBy('created_at','desc')->get();
        return \DataTables::of($slider)
        ->addColumn('action', function ($slider) {
            return '<a href="'.asset("admin/slider/edit/$slider->id").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-Location"
            data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
            <a href="#"  data-type="'.$slider->id.'" id="delete-slider" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-Location"
            data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
            ';

        }) 
        
        ->addColumn('section',function($slider){

            return  ucfirst($slider->section);
        }) 

        ->addColumn('created_by',function($slider){

            return  ucfirst($slider->user->name);
        })
        ->addColumn('image',function($slider){

            return '<img style="width:100px; height:100px" src="'.asset('storage/'.$slider->image).'">';

        })

        ->addColumn('status', function ($slider) {
            if($slider->status == '1')
                return  '<a href="#"  data-type="'.$slider->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
            data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

            if($slider->status == '0')   return  '<a href="#"  data-type="'.$slider->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
            data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';
        })
        ->removeColumn('id')
        ->rawColumns(['action','created_by','status','image'])
        ->addIndexColumn()
        ->make(true);
    }
}
