<?php

namespace App\Http\Controllers;

use App\Repositories\DeviceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    protected $device;

    public function __construct(DeviceRepository $device)
    {
        $this->device = $device;
    }

    public function store(Request $request){

        $data = $request->except('_token');

        $data['user_id'] = Auth::user()->id;
        $this->device->firstOrCreate($data);
        return response()->json(['success'=>true],200);
    }
}
