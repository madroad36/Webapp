<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserType\UserTypeStoreRequest;
use App\Http\Requests\UserType\UserTypeUpdateRequest;
use App\Repositories\UserTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $userType;
    public function __construct(UserTypeRepository $userType)
    {
        $this->userType = $userType;
    }

    public function index()
    {
        return view('layouts.backend.userType.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.backend.userType.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserTypeStoreRequest $request)
    {
        $data = $request->except('_token');

        if($this->userType->create($data)){
            return redirect('admin/users_type')->with('success','User Type Created Successfully');

        }

        return redirect()->back()->with('errors','User Type Cannot Created Successfully');
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
        $usertype = $this->userType->find($id);
        return view('layouts.backend.userType.edit')->withUsertype($usertype);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserTypeUpdateRequest $request, $id)
    {
        $usertype = $this->userType->find($id);

        $data = $request->except('_token');

        if($this->userType->update(  $usertype->id,$data)){
            return redirect('admin/users_type')->with('success','User Type Update Successfully');

        }

        return redirect()->back()->with('errors','User Type Cannot Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userType = $this->userType->find($id);

        if($this->userType->destroy($userType->id)){

            $message = 'User Type Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);
    }
    public function getdata(){

        $user_types = $this->userType->orderBy('created_at','desc')->where('name','!=','admin')->get();

        return \DataTables::of($user_types)
            ->addColumn('action', function ($user_types) {
                return '<a href="'.asset("admin/users_type/edit/$user_types->id").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-UserType"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
                        <a href="#"  data-type="'.$user_types->id.'" id="delete-UserType" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-UserType"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  ';

            })
            ->removeColumn('id')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
}
