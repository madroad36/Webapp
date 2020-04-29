<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vendor\UpdateRequest;
use App\Http\Requests\Vendor\VendorStoreRequest;
use App\Repositories\VendorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\UserTypeRepository;
use App\Repositories\SettingRepository;
use App\Events\User\UserVendor;
use Auth;

class VendorController extends Controller
{
    protected $vendor,$userType,$setting;
    public function __construct(VendorRepository $vendor,UserTypeRepository $userType,SettingRepository $setting)
    {
        $this->vendor = $vendor;
        $this->upload_path = DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
        $this->setting = $setting;
        $this->userType =$userType;
    }

    public function store(VendorStoreRequest $request){
        $data = $request->except('_token', 'pan_vat_image');

        if ($request->file('pan_vat_image')) {
            $image = $request->file('pan_vat_image');
            $fileName = time() . $image->getClientOriginalName();
            $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
            $data['pan_vat_image'] = 'vendor/' . $fileName;

        }
        $data['is_active'] = (isset($request['is_active'])) ? 1 : 0;
        $data['vendor_id'] = Auth::user()->id;
        if($this->vendor->create($data)){
            $usertype = $this->userType->where('name','admin')->first();
            $newuser['receiver_id'] =$usertype->user->id;
            $newuser['message']= Auth::user()->name.'has send vendor request';
            event (new UserVendor($newuser));
            return response()->json(['success'=>true],200);
        }
        return response()->json(['errors'=>true],422);

    }

    public  function update(UpdateRequest $request){
        $data = $request->except('_token', 'pan_vat_image');
        $vendor = $this->vendor->where('vendor_id',Auth::user()->id)->first();
        if ($request->file('pan_vat_image')) {
            $image = $request->file('pan_vat_image');
            $fileName = time() . $image->getClientOriginalName();
            $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
            $data['pan_vat_image'] = 'vendor/' . $fileName;

        }
        if($this->vendor->update($vendor->id,$data)){
            return response()->json(['success'=>true],200);
        }
        return response()->json(['errors'=>true],422);

    }
}
