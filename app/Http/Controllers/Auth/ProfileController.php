<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\Profile\ProlieUpdatRequest;
use App\Repositories\UserRepository;
use App\Repositories\UserTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $user,  $userType;

    public function __construct(UserRepository $user, UserTypeRepository $userType)
    {
        $this->user = $user;
        $this->userType= $userType;
        $this->upload_path = DIRECTORY_SEPARATOR.'user'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    public function index()
    {
        $user =$this->user->find(Auth::user()->id);
        $userTypes = $this->userType->orderBy('created_at','desc')->where('name','!=','admin')->get();
        return view('user.profile.index')->withUser($user)->withUserTypes($userTypes);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
    public function update(ProlieUpdatRequest $request, $id)
    {

        $user = $this->user->find($id);
        $data = $request->except('_token');
        if($this->user->update($user->id,$data)){
            return redirect('auth/profile')->with('success','Profile Updated Successfully');
        }
        return redirect()->back()->with('errors','Profile cannot be Updated Successfully');
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

    public function uploadImage(Request $request){
        $user =$this->user->find(Auth::user()->id);

        if($request->file('image')){
            $image= $request->file('image');
            $fileName = time().$image->getClientOriginalName();
            $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
            $data['image'] = 'user/'.$fileName;
            if(Storage::exists($user->image)){
                Storage::delete($user->image);
            }

        }
        $data['created_by'] = Auth::user()->id;
        if($this->user->update($user->id,$data)){
            $user = $this->user->find($user->id);
            return response()->json(['status'=>true,'user'=>$user],200);
        }
    }
    public function uploadnationalId(Request $request)
    {
        $user = $this->user->find(Auth::user()->id);

        if ($request->file('image')) {
            $image = $request->file('image');
            $fileName = time() . $image->getClientOriginalName();
            $this->storage->put($this->upload_path . $fileName, file_get_contents($image->getRealPath()));
            $data['id_card'] = 'user/' . $fileName;
            if (Storage::exists($user->id_card)) {
                Storage::delete($user->id_card);
            }

        }
        $data['created_by'] = Auth::user()->id;
        if ($this->user->update($user->id, $data)) {
            $user = $this->user->find($user->id);
            return response()->json(['status' => true, 'user' => $user], 200);
        }
    }
}
