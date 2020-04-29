<?php

namespace App\Http\Controllers;



use App\Http\Requests\Role\RoleStoreRequest;
use App\Http\Requests\Role\RoleUpdateRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\RolePermissionRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
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
    }

    public function index()
    {
        return view('role.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
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
        if(Auth::guard('user')->check()){
            $data['created_by'] = Auth::guard('user')->user()->id;

        }
        else{
            $data['created_by'] = Auth::user()->created_by;

        }
        if($this->role->create($data)){
            return redirect('/role')->with('success','Role Created Successfully');
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
        return view('role.edit')->withRole($role);
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
        if(Auth::guard('user')->check()){
            $data['created_by'] = Auth::guard('user')->user()->id;

        }else{
            $data['created_by'] = Auth::user()->created_by;

        }
        if($this->role->update($role->id,$data)){
            return redirect('/role')->with('success','Role Updated Successfully');
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
        if(Auth::guard('user')->check()){
            $id = Auth::guard('user')->user()->id;

        }else{
            $id = Auth::user()->created_by;

        }
        $roles = $this->role->where('created_by',$id)->orderBy('created_at','desc')->get();

        return \DataTables::of($roles)
            ->addColumn('action', function ($roles) {
                return '<a href="'.asset("role/edit/$roles->id").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-Role"
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
                    $data .='</span>&nbsp;&nbsp;';
                }
                return  $data;
            })
            ->removeColumn('id')
            ->rawColumns(['action','permission'])
            ->addIndexColumn()
            ->make(true);
    }
}
