<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserUpdateRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class ProfileController extends Controller
{
    protected $user;
     public  function __construct(UserRepository $user)
     {
         $this->user = $user;
         $this->upload_path = DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR;
         $this->storage = Storage::disk('public');
     }
     public function Profile(UserUpdateRequest $request){
         $data = $request->except('_token', 'image');
         if($request->file('image')){
             $image= $request->file('image');
             $fileName = time().$image->getClientOriginalName();
             $this->storage->put($this->upload_path. $fileName, file_get_contents($image->getRealPath()));
             $data['image'] = 'user/'.$fileName;

         }
         $user = $this->user->find(Auth::user()->id);
         if($this->user->update($user->id, $data)){
             return response()->json(['success'=>true,'profile_update'=>true],200);
         }
         return response()->json(['errors'=>true,'profile_update'=>true],422);

     }
}
