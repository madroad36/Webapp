<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $role,$useRole,$user;

    public  function __construct(RoleRepository $role, UserRoleRepository $userRole,UserRepository $user)
    {
        $this->role = $role;
        $this->useRole = $userRole;
        $this->user =$user;
        $this->middleware('admin');

    }


    public function index(Request $request)
    {
//       $userRoles = $this->useRole->where('user_id',$request->id)->get();
        $roles = $this->role->orderBy('created_at','desc')->get();
        return response()->json(['status'=>'ok','roles'=>$roles]);
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
    public function getRole($id){
        $userRoles = $this->useRole->where('user_id',$id)->get();

        $role = [];

        foreach ($userRoles as $roles)
        {
            $rol['id'] = $roles->role_id;
            $rol['name'] = $roles->Role->name;
            $role[] =$rol;
        }


        return response()->json(['status'=>'ok','role'=>$role]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->user->find($request->id);

        $user->UserRoles()->sync($request->role_id);
        return redirect('/admin/users')->with('success','User Role Added  Successfully');
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

