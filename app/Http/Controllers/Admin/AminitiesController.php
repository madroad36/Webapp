<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Aminities\AminitiesStoreRequest;
use App\Http\Requests\Aminities\AminitiesUpdateRequest;
use App\Repositories\AminitiesRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Gate;

class AminitiesController extends Controller
{
    protected $user, $aminities;

    public function __construct(UserRepository $user, AminitiesRepository $aminities)
    {
        $this->aminities = $aminities;
        $this->user = $user;
    }

    public function index()
    {
        return view('layouts.backend.aminities.view');
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
        return view('layouts.backend.aminities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AminitiesStoreRequest $request)
    {
        $data = $request->except('_token');
        $data['created_by'] = Auth::user()->id;
        $data['is_active'] =(isset($request['is_active'])) ? 1 : 0;
        if($this->aminities->create($data)){
            return redirect('admin/aminities')->with('success','Aminities created successfully');
        }
        return redirect('admin/aminities')->with('errors','Aminities cannot be created successfully');

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
            abort(404,"Permission Denied.");
        }
        $aminities = $this->aminities->find($id);

        return view('layouts.backend.aminities.edit')->withAminities($aminities);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AminitiesUpdateRequest $request, $id)
    {
        $aminities = $this->aminities->find($id);
        $data = $request->except('_token');
        $data['created_by'] = Auth::user()->id;
        if($this->aminities->update($aminities->id, $data)){
            return redirect('admin/aminities')->with('success','aminities update successfully');
        }
        return redirect('admin/aminities')->with('errors','aminities cannot be update successfully');

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
        $aminities = $this->aminities->find($id);

        if($this->aminities->destroy($aminities->id)){

            $message = 'Aminities Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);

    }
    public function changeStatus(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $aminities = $this->aminities->find($request->get('id'));
        if ($aminities->is_active == 0) {
            $status = '1';
            $message = 'aminities with title "' . $aminities->name . '" is published.';
        } else {
            $status = '0';
            $message = 'aminities with title "' . $aminities->name . '" is unpublished.';
        }

        $this->aminities->changeStatus($aminities->id, $status);
        $this->aminities->update($aminities->id, array('is_active' => $status));
        $updated = $this->aminities->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function getdata(){

        $aminities = $this->aminities->orderBy('created_at','desc')->get();

        return \DataTables::of($aminities)
            ->addColumn('action', function ($aminities) {
                return '<a href="'.asset("admin/aminities/edit/$aminities->id").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-aminities"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
                        <a href="#"  data-type="'.$aminities->id.'" id="delete-aminities" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-aminities"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  ';

            })
            ->addColumn('created_by',function($aminities){

                return  $aminities->user->name;
            })
            ->addColumn('status', function ($aminities) {
                if($aminities->is_active == '1')
                    return  '<a href="#"  data-type="'.$aminities->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                if($aminities->is_active == '0')   return  '<a href="#"  data-type="'.$aminities->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


            })
            ->removeColumn('id')
            ->rawColumns(['action','created_by','status'])
            ->addIndexColumn()
            ->make(true);
    }
}
