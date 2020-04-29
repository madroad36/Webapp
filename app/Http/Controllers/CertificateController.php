<?php

namespace App\Http\Controllers;

use App\Repositories\CertificateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class CertificateController extends Controller
{
    protected $certificate;

    public function __construct(CertificateRepository $cetificate)
    {
        $this->certificate = $cetificate;
        $this->upload_path = DIRECTORY_SEPARATOR.'certificate'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');

    }
    public function store(Request $request)
    {

        $data = $request->except(['file']);
        $file = $request->file('file');
        $file_name = $file->getClientOriginalName();
        $data['user_id'] = Auth::user()->id;
        $data['image'] = 'certificate/'.$file_name;
        $this->storage->put('certificate/'.$file_name, file_get_contents($file->getRealPath()));

        $this->certificate->create($data);

        $image = $this->certificate->where('user_id',Auth::user()->id)->get();

        return response()->json(['success' =>true, 'image'=>$image]);
    }

    public function destroy(Request $request){

        $filename =  $request->get('image');
        $fileId =  $request->get('id');
        if(!empty($filename)) {
            $this->certificate->where('image', 'productImages/' . $filename)->delete();
            $path = public_path() . '/certificate/' . $filename;
            if (file_exists($path)) {
                unlink($path);
            }
            return $filename;
        }

        $image = $this->certificate->find($fileId);
        $this->certificate->where('id',$fileId )->delete();
        $path = public_path() . '/certificate/' . $image->name;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success' =>true, 'image'=>$image]);


    }
}
