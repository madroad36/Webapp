<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\UserRoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Repositories\UserRepository;
use App\Repositories\UserTypeRepository;
use Auth;
use Hash;
use Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $user, $useRole, $usertype;

    public function __construct(UserRepository $user,UserRoleRepository $useRole,UserTypeRepository $usertype)
    {
        $this->user = $user;
        $this->useRole =$useRole;
        $this->userType =$usertype;
    }

    public function index(Request $request)
    {

        return view('layouts.backend.user.view');
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
        $usertype = $this->userType->all();
        return view('layouts.backend.user.create', compact('usertype'));
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
        $data['created_by'] = Auth::user()->created_by;

        $data['is_active'] ='0';
        $data['is_active'] =(isset($request['is_active'])) ? 1 : 0;
        $data['password'] = bcrypt($request->password);

        if($this->user->create($data)){
            return redirect('/admin/users')->with('success','User Created Successfully');
        }
        return redirect('/admin/users')->with('errors','User Cannot Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = $this->user->where('batch_number',$slug)->first();
        return view('layouts.backend.user.profile')->withUser($user);

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
            abort(404,"Sorry");
        }
        $user = $this->user->find($id);
        $usertype = $this->userType->all();
        $select = [];
        foreach($usertype as $users){
            $select[$users->id] = $users->name;
        }
        return view('layouts.backend.user.edit', compact('select'))->withUser($user);
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
        if(Hash::check($request->input('password'), $user->password)){
            $data = $request->except('_token');

            $data['created_by'] = Auth::user()->id;

            $data['password'] = bcrypt($request->password);
            if($user->update($data)){
                return redirect('/admin/users')->with('success','User Update Successfully');
            }
            return redirect('/admin/users')->with('errors','User Cannot Update Successfully');
        }
        else
        {
            return redirect('/admin/users')->with('errors','Password or Email Confirmation Failed');
        }
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
        $user = $this->user->find($id);
        $this->useRole->where('user_id',$user->id)->delete();

        if($this->user->destroy($user->id)){
            $message = 'User deleted successfully.';
            if($user->id == Auth::user()->id){
                return redirect()->route('admin.login');
            }
            return response()->json(['status' => 'ok', 'message' => $message], 200);
        }
        return response()->json(['status' => 'error', 'message' => ''], 422);
    }

    public function changeStatus(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Sorry");
        }
        $user = $this->user->find($request->get('id'));
        if ($user->is_active == 0) {
            $status = '1';
            $message = 'User with title "' . $user->name . '" is published.';
        } else {
            $status = '0';
            $message = 'User with title "' . $user->name . '" is unpublished.';
        }

        $this->user->changeStatus($user->id, $status);
        $this->user->update($user->id, array('is_active' => $status));
        $updated = $this->user->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function broker(Request $request)
    {
        $user = $this->user->find($request->get('id'));
        if ($user->broker == 0) {
            $status = '1';
            $message =  $user->name . '" is assign broker .';
        } else {
            $status = '0';
            $message =  $user->name . '" will not be  broker more';
        }

        $this->user->update($user->id, array('broker' => $status));
        $updated = $this->user->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function vendor(Request $request)
    {
        $user = $this->user->find($request->get('id'));
        if ($user->vendor == 0) {
            $status = '1';
            $message =  $user->name . '" is assign vendor .';
        } else {
            $status = '0';
            $message =  $user->name . '" will not be  vendor more';
        }

        $this->user->update($user->id, array('vendor' => $status));
        $updated = $this->user->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function service(Request $request)
    {
        $user = $this->user->find($request->get('id'));
        if ($user->service == 0) {
            $status = '1';
            $message =  $user->name . '" is assign service .';
        } else {
            $status = '0';
            $message =  $user->name . '" will not be  service more';
        }

        $this->user->update($user->id, array('service' => $status));
        $updated = $this->user->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function getdata(Request $request){

        if($request->has('batch_number')){
            $users = $this->user->where('batch_number',$request->batch_number)->orderBy('created_at','desc')->get();
        }
        else{
            $users = $this->user->orderBy('created_at','desc')->get();
        }


        return \DataTables::of($users)
        ->addColumn('action', function ($users) {
            return '<a href="'.route("admin.users.edit" , $users->id).'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-User"
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
        ->addColumn('status', function ($users) {
            if($users->is_active == '1')
                return  '<a href="#"  data-type="'.$users->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
            data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

            if($users->is_active == '0')   return  '<a href="#"  data-type="'.$users->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
            data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


        })
        ->addColumn('broker', function ($users) {
            if($users->broker == '1')
                return  '<a href="#"  data-type="'.$users->id.'" id="broker" class="btn btn-xs btn-success published"  title="broker"
            data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

            if($users->broker == '0')   return  '<a href="#"  data-type="'.$users->id.'" id="broker" class="btn btn-xs btn-success unpublished" "  title="broker"
            data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


        })
        ->addColumn('vendor', function ($users) {
            if($users->vendor == '1')
                return  '<a href="#"  data-type="'.$users->id.'" id="vendor" class="btn btn-xs btn-success published"  title="vendor"
            data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

            if($users->vendor == '0')   return  '<a href="#"  data-type="'.$users->id.'" id="vendor" class="btn btn-xs btn-success unpublished" "  title="vendor"
            data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


        })
        ->addColumn('service', function ($users) {
            if($users->service == '1')
                return  '<a href="#"  data-type="'.$users->id.'" id="service" class="btn btn-xs btn-success published"  title="service"
            data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

            if($users->service == '0')   return  '<a href="#"  data-type="'.$users->id.'" id="service" class="btn btn-xs btn-success unpublished" "  title="service"
            data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';


        })
        ->removeColumn('id')
        ->rawColumns(['action','roles','status','broker','service','vendor'])
        ->addIndexColumn()
        ->make(true);
    }
}

