<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Auth;
use Guard;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('layouts.user.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->except('_token');
        if(Auth::guard('user')->check()){
            $data['created_by'] = Auth::guard('user')->user()->id;
        }else{
            $data['created_by'] = Auth::user()->created_by;
        }

        $data['password'] = bcrypt($request->password);

        if($this->user->create($data)){
            return redirect('/users')->with('success','User Created Successfully');
        }
        return redirect('/users')->with('errors','User Cannot Created Successfully');
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
        $user = $this->user->find($id);
        return view('layouts.user.edit')->withUser($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->user->find($id);
        $data = $request->except('_token');
        if(Auth::guard('user')->check()){
            $data['created_by'] = Auth::guard('user')->user()->id;
        }else{
            $data['created_by'] = Auth::user()->created_by;
        }
        $data['password'] = bcrypt($request->password);
        if($this->user->updated( $user->id,$data)){
            return redirect('/users')->with('success','User Update Successfully');
        }
        return redirect('/users')->with('errors','User Cannot Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);
        if($this->user->destroy($user->id)){
            $message = 'User deleted successfully.';
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

        dd($id);
        $users = $this->user->where('created_by',$id)->orderBy('created_at','desc')->get();

        return \DataTables::of($users)
            ->addColumn('action', function ($users) {
                return '<a href="'.asset("user/edit/$users->id").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-User"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
                        <a href="#"  data-type="'.$users->id.'" id="delete-user" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-User"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                   <a href="#"  data-type="'.$users->id.'" id="add-role" class="btn btn-xs btn-warning addRole"  title="Add-Roles"
                                    data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a>';

            })
            ->addColumn('roles',function($users){
                $data ='';
                foreach($users->UserRoles as $roles){
                    $data .= '<span class="label label-success">';
                    $data .=$roles->name;
                    $data .='</span>&nbsp;&nbsp;';
                }
                return  $data;
            })
            ->removeColumn('id')
            ->rawColumns(['action','roles'])
            ->addIndexColumn()
            ->make(true);
    }
}
