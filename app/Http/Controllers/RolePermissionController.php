<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Repositories\PermissionRepository;
use App\Repositories\RolePermissionRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $rolePermission, $permission,$role;

    public function __construct(RolePermissionRepository $rolePermission,PermissionRepository $permission, RoleRepository $role)
    {
        $this->rolePermission = $rolePermission;
        $this->permission = $permission;
        $this->role = $role;
    }

    public function index()
    {
        $permissions = $this->permission->orderBy('created_at','desc')->get();
        return response()->json(['status'=>'ok','permissions'=>$permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getPermission($id){
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = $this->role->find($request->id);


        $role->permission()->sync($request->permission_id);
        return redirect('/role')->with('success','Permission is added to role successfully');

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
