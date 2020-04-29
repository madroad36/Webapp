<?php

namespace App\Http\Controllers;

use App\Http\Requests\Broker\BrokerStoreRequest;
use App\Http\Requests\Technician\StoreRequest;
use App\Http\Requests\Technician\UpdateRequest;
use App\Repositories\TechnicianRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Repositories\UserTypeRepository;
use App\Repositories\SettingRepository;
use App\Events\User\UserTechnician;

class TechnicianController extends Controller
{
    protected $technician,$userType,$setting;

    public function __construct(TechnicianRepository $technician,UserTypeRepository$userType,SettingRepository $setting )
    {
        $this->technician = $technician;
        $this->setting = $setting;
        $this->userType =$userType;
        $this->upload_path = DIRECTORY_SEPARATOR . 'technician' . DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');

    }
    public function store(StoreRequest $request){
        $technician = $this->technician->where('technician_id',Auth::user()->id)->first();
        if(empty($technician)) {
            $data = $request->except('_token', 'citizen_upload', 'certificate_upload');
            if ($request->file('citizen_upload')) {
                $image = $request->file('citizen_upload');
                $fileName = time() . $image->getClientOriginalName();
                $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
                $data['citizen'] = 'technician/' . $fileName;

            }
            if ($request->file('certificate_upload')) {
                $image = $request->file('certificate_upload');
                $fileName = time() . $image->getClientOriginalName();
                $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
                $data['certificate'] = 'technician/' . $fileName;

            }
            $data['is_active'] = (isset($request['is_active'])) ? 1 : 0;
            $data['technician_id'] = Auth::user()->id;
            if ($this->technician->create($data)) {
                $usertype = $this->userType->where('name','admin')->first();
                $newuser['receiver_id'] =$usertype->user->id;
                $newuser['message']= Auth::user()->name.'has send service provider request';
                event (new UserTechnician($newuser));
                return response()->json(['success' => true], 200);
            }

        }
        else{
            $user = Auth::user();

            return response()->json(['success' => true], 200);
        }
        return response()->json(['errors'=>true],422);

    }

    public function update(UpdateRequest $request){
        $technician = $this->technician->where('technician_id',Auth::user()->id)->first();

            $data = $request->except('_token', 'citizen_upload', 'certificate_upload');
            if ($request->file('citizen_upload')) {
                $image = $request->file('citizen_upload');
                $fileName = time() . $image->getClientOriginalName();
                $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
                $data['citizen'] = 'technician/' . $fileName;

            }
            if ($request->file('certificate_upload')) {
                $image = $request->file('certificate_upload');
                $fileName = time() . $image->getClientOriginalName();
                $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
                $data['certificate'] = 'technician/' . $fileName;

            }
            $data['is_active'] = (isset($request['is_active'])) ? 1 : 0;
            $data['technician_id'] = Auth::user()->id;
            if ($this->technician->update($technician->id,$data)) {
                return response()->json(['success' => true], 200);
            }
        return response()->json(['errors' => true], 422);
    }
}
