<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingStoreRequest;
use App\Http\Requests\Setting\SettingUpdateRequest;
use App\Repositories\SettingRepository;
use Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    public function index()
    {
        return view('user.setting.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.setting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingStoreRequest $request)
    {
        $data = $request->except('_token');
        $data['created_by'] = Auth::user()->id;
        if($this->setting->create($data)){
            return redirect('setting')->with('success','Setting Created Successfully');
        }
        return redirect()->back()->with('errors','Setting Cant not Created Successfully');

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
        $setting = $this->setting->where('slug',$slug)->first();
        return view('user.setting.edit')->withSetting($setting);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SettingUpdateRequest $request, $id)
    {
        $setting = $this->setting->find($id);
        $data = $request->except('_token');
        $data['created_by'] = Auth::user()->id;
        if($this->setting->update($setting->id, $data)){
            return redirect('setting')->with('success','Setting Update Successfully');
        }
        return redirect()->back()->with('errors','Setting Cant not Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $setting = $this->setting->find($id);

        if($this->setting->destroy($setting->id)){

            $message = 'setting Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);

    }
    public function changeStatus(Request $request)
    {
        $setting = $this->setting->find($request->get('id'));
        if ($setting->is_active == 0) {
            $status = '1';
            $message = 'setting with title "' . $setting->title . '" is published.';
        } else {
            $status = '0';
            $message = 'setting with title "' . $setting->title . '" is unpublished.';
        }

        $this->setting->changeStatus($setting->id, $status);
        $this->setting->update($setting->id, array('is_active' => $status,'created_by'=>Auth::user()->id));
        $updated = $this->setting->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function getdata(){

        $settings = $this->setting->orderBy('created_at','desc')->get();

        return \DataTables::of($settings)
            ->addColumn('action', function ($settings) {
                $data = '';

                if(auth()->user()->can('edit-setting')) {
                    $data .= '<a href="' . asset("setting/edit/$settings->slug") . '" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-setting" data-toggle="tooltip" > <i class="fa fa-edit"></i></a>';
                        }
                if(auth()->user()->can('delete-setting')) {
                    $data .= '&nbsp;<a href="#"  data-type="' . $settings->id . '" id="delete-setting" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-setting"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }
                return $data;

            })
            ->addColumn('created_by',function($settings){

                return  $settings->user->name;
            })
            ->addColumn('status', function ($settings) {
                if($settings->is_active == '1')
                    return  '<a href="#"  data-type="'.$settings->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($settings->is_active == '0')   return  '<a href="#"  data-type="'.$settings->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


            })
            ->removeColumn('id')
            ->rawColumns(['action','status','created_by'])
            ->addIndexColumn()
            ->make(true);
    }
}
