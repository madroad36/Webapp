<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AdvertisementRepository;
use App\Repositories\UserRepository;
use App\Http\Requests\Advertisement\AdvertisementStoreRequest;
use App\Http\Requests\Advertisement\AdvertisementUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Auth;
use Session;
use Gate;

class AdvertisementController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $advertisement;

    public function __construct(AdvertisementRepository $advertisement)
    {
        $this->advertisement = $advertisement;
        $this->upload_path = DIRECTORY_SEPARATOR.'advertisement'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    public function index()
    {
        return view('layouts.backend.advertisement.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Sorry");
        }
        $date = date("Y-m-d");
        return view('layouts.backend.advertisement.create',compact('date'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertisementStoreRequest $request)
    {
        $data = $request->except('_token');
        $data['status'] = isset($request->status) ? 1:0;
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'advertisement/'.$fileName;

        }
        $data['name'] = strtolower($request->name);
        if($this->advertisement->firstOrCreate($data)){
            return redirect()->route('admin.advertisement.index')->with('success','Advertisemsnt created successfully');
        }
        return redirect()->back()->with('success','Advertisemsnt cannot created successfully');

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
            abort(404,"Sorry");
        }
        $date = date("Y-m-d");
        $advertisement =  $this->advertisement->where('slug',$slug)->first();
        return view('layouts.backend.advertisement.edit',compact('date'))->withAdvertisement($advertisement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdvertisementUpdateRequest $request, $id)
    {
        $advertisement =  $this->advertisement->find($id);

        $data = $request->except('_token');
        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'advertisement/'.$fileName;
            if(Storage::exists($advertisement->image)){
                Storage::delete($advertisement->image);
            }

        }
        $data['name'] = strtolower($request->name);
        if($this->advertisement->update($advertisement->id,$data)){
            return redirect()->route('admin.advertisement.index')->with('success','Service category updated successfully');
        }
        return redirect()->back()->with('success','Service Category cannot updated successfully');
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
        $advertisement = $this->advertisement->find($id);
        if($this->advertisement->destroy($advertisement->id))
        {
            $message = 'Service Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);
        }
        return response()->json(['status'=>'ok','message'=>'Service cannot be delete'],422);
    }

    public function changeStatus(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Sorry");
        }
        $advertisement = $this->advertisement->find($request->get('id'));
        if ($advertisement->status == 0) {
            $status = '1';
            $message = 'Advertisement with title "' . $advertisement->name . '" is published.';
        } else {
            $status = '0';
            $message = 'Advertisement with title "' . $advertisement->name . '" is unpublished.';
        }

        $this->advertisement->changeStatus($advertisement->id, $status);
        $this->advertisement->update($advertisement->id, array('status' => $status));
        $updated = $this->advertisement->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'property' => $updated], 200);
    }

    public function getdata()
    {
        $advertisement = $this->advertisement->orderBy('created_at','desc')->get();
        return \DataTables::of($advertisement)
            ->addColumn('action', function ($advertisement) {
                return '<a href="'.asset("admin/advertisement/edit/$advertisement->slug").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-Location"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
                        <a href="#"  data-type="'.$advertisement->id.'" id="delete-advertisement" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-Location"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  ';

            }) 
            ->addColumn('created_by',function($advertisement){

                return  ucfirst($advertisement->user->name);
            })
            ->addColumn('image',function($advertisement){

                return '<img style="width:100px; height:100px" src="'.asset('storage/'.$advertisement->image).'">';

            })

            ->addColumn('status', function ($advertisement) {
                if($advertisement->status == '1')
                    return  '<a href="#"  data-type="'.$advertisement->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($advertisement->status == '0')   return  '<a href="#"  data-type="'.$advertisement->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';
            })
            ->removeColumn('id')
            ->rawColumns(['action','created_by','status','image'])
            ->addIndexColumn()
            ->make(true);
    }

}