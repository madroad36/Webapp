<?php

namespace  App\Http\Controllers\Admin;

use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\RolePermissionRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $role, $rolePermission, $permission;

    public function __construct(RoleRepository $role, RolePermissionRepository $rolePermission, PermissionRepository $permission)
    {
        $this->role = $role;
        $this->rolePermission = $rolePermission;
        $this->permission = $permission;
        $this->middleware('admin');

    }

    public function index()
    {
        return view('layouts.backend.role.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.backend.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        $data = $request->except('_token');
        if($this->role->create($data)){
            return redirect('admin/role')->with('success','Role Created Successfully');
        }
        return redirect()->back()->with('errors','Role Created Successfully');

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
        $role = $this->role->find($id);
        return view('layouts.backend.role.edit')->withRole($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        $role = $this->role->find($id);

        $data = $request->except('__token');
        if($this->role->update($role->id,$data)){
            return redirect('admin/role')->with('success','Role Updated Successfully');
        }
        return redirect()->back()->with('success','Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = $this->role->find($id);
        if($this->role->destroy($role->id)){
            $message = 'Role deleted successfully.';
            return response()->json(['status' => 'ok', 'message' => $message], 200);
        }
        return response()->json(['status' => 'error', 'message' => ''], 422);
    }

    public function changeStatus(Request $request){

    }
    public function getdata(){
        $roles = $this->role->orderBy('created_at','desc')->get();

        return \DataTables::of($roles)
            ->addColumn('action', function ($roles) {
                return '<a href="'.asset("admin/role/edit/$roles->id").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-Role"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
                        <a href="#"  data-type="'.$roles->id.'" id="delete-role" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-Role"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  <a href="#"  data-type="'.$roles->id.'" id="add-permission" class="btn btn-xs btn-warning addPermission"  title="Add-Permission"
                                    data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a>';


            })
            ->addColumn('permission',function($roles){
                $data ='';
                foreach($roles->permission as $permission){
                    $data .= '<span class="label label-success">';
                    $data .=$permission->name;
                    $data .='</br></span>&nbsp;&nbsp;';
                }
                return  $data;
            })
            ->removeColumn('id')
            ->rawColumns(['action','permission'])
            ->addIndexColumn()
            ->make(true);
    }
    public function storepermission(Request $request){
        $role = $this->role->find($request->id);


        $role->permission()->sync($request->permission_id);
        return redirect('admin/role')->with('success','Permission is added to role successfully');

    }


    public function getpermission(){
        $permissions = $this->permission->orderBy('created_at','desc')->get();
        return response()->json(['status'=>'ok','permissions'=>$permissions]);
    }
    public function getrolepermission($id){
        $permissions = $this->rolePermission->where('role_id',$id)->get();

        $perms = [];

        foreach ($permissions as $permission)
        {
            $perm['id'] = $permission->permission_id;
            $perm['name'] = $permission->permission->name;
            $perms[] =$perm;
        }

        return response()->json(['status'=>'ok','perms'=>$perms]);

    }
}
