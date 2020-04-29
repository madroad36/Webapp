<?php

namespace  App\Http\Controllers\Admin;

use App\Http\Requests\Permission\PermissionStoreRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $permission;

    public  function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
        $this->middleware('admin');

    }

    public function index()
    {
        return view('layouts.backend.permission.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.backend.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionStoreRequest $request)
    {
        $data = $request->except('__token');
        if($this->permission->create($data)){
            return redirect('admin/permission')->with('success','Permission Created Successfully');
        }
        return redirect()->back()->with('success','Permission Cannot Created Successfully');

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
        $permission = $this->permission->find($id);

        return view('layouts.backend.permission.edit')->withPermission( $permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        $data = $request->except('__token');
        $permission = $this->permission->find($id);
        if($this->permission->update( $permission->id,$data)){
            return redirect('admin/permission')->with('success','Permission Updated Successfully');
        }
        return redirect()->back()->with('success','Permission Cannot Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = $this->permission->find($id);
        if($this->permission->destroy($permission->id)){
            $message = 'Permission deleted successfully.';
            return response()->json(['status' => 'ok', 'message' => $message], 200);
        }
        return response()->json(['status' => 'error', 'message' => ''], 422);
    }
    public function getdata(){
        $permissions = $this->permission->orderBy('created_at','desc')->get();

        return \DataTables::of($permissions)
            ->addColumn('action', function ($permissions) {
                return '<a href="'.asset('permission/edit/$permissions->id').'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-Permission" data-toggle="tooltip" > <i class="fa fa-edit" aria-hidden="true"></i></a>
                        <a href="#"  data-type="'.$permissions->id.'" id="delete-permission" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-Permission"data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>';

            })
            ->removeColumn('id')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
}
