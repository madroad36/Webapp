<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Setting\SettingStoreRequest;
use App\Http\Requests\Setting\SettingUpdateRequest;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Gate;
use Storage;

class SettingController extends Controller
{
    protected $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
        $this->upload_path = DIRECTORY_SEPARATOR.'setting'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    public function index()
    {
        $setting = $this->setting->where('is_active',1)->first();
        if($setting)
        {
            return redirect()->route('admin.setting.edit',compact('setting'));
        }
        else
        {
            return redirect()->route('admin.setting.create');   
        }
        // return view('layouts.backend.setting.view');
    }

    public function create()
    {
        if(!Gate::allows('isAdmin'))
        {
            abort(404,"Permission Denied.");
        }

        $setting = $this->setting->where('is_active',1)->first();
        if($setting)
        {
            return redirect()->route('admin.setting.edit',compact('setting'));
        }
        else
        {
            return view('layouts.backend.setting.create');
        }
    }

    public function store(SettingStoreRequest $request)
    {
        $data = $request->except('_token');
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'setting/'.$fileName;

        }
        $data['created_by'] = Auth::user()->id;
        if($this->setting->create($data)){
            Session::flash('success','Company Registered Successfully.');
            return redirect()->route('admin.setting.index');
        }
        return redirect()->back()->with('successs','Setting Cant not Created Successfully');

    }

    public function edit($id)
    {
        if(!Gate::allows('isAdmin'))
        {
            abort(404,"Permission Denied.");
        }
        $setting = $this->setting->findorfail($id)->first();
        return view('layouts.backend.setting.edit')->withSetting($setting);
    }

    public function update(SettingUpdateRequest $request, $id)
    {
        $setting = $this->setting->findorfail($id);
        $data = $request->except('_token');
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'setting/'.$fileName;
            if(Storage::exists($setting->image)){
                Storage::delete($setting->image);
            }

        }
        $data['created_by'] = Auth::user()->id;
        if($this->setting->update($setting->id, $data)){
            Session::flash('success','Company Upgraded Successfully.');
            return redirect()->route('admin.setting.index');
        }
        return redirect()->back()->with('successs','Setting Cannot Update Successfully');
    }

    public function getdata()
    {
        $settings = $this->setting->orderBy('created_at','desc')->get();

        return \DataTables::of($settings)
        ->addColumn('action', function ($settings) {
            return '<a href="'.asset("admin/setting/edit/$settings->slug").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-setting"
            data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
            <a href="#"  data-type="'.$settings->id.'" id="delete-setting" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-setting"
            data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
            ';

        })
        ->addColumn('created_by',function($settings){

            return  $settings->user->name;
        })
        ->addColumn('status', function ($settings) {
            if($settings->is_active == '1')
                return  '<a href="#"  data-type="'.$settings->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
            data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a> ';

            if($settings->is_active == '0')   return  '<a href="#"  data-type="'.$settings->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
            data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


        })
        ->removeColumn('id')
        ->rawColumns(['action','status','created_by'])
        ->addIndexColumn()
        ->make(true);
    }
}
