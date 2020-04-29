<?php

namespace App\Http\Controllers;

use App\Repositories\PropertyImageRepository;
use App\Repositories\PropertyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyImageController extends Controller
{
    protected $property, $propertyImage;

    public function __construct(PropertyRepository $property, PropertyImageRepository $propertyImage)
    {
        $this->property = $property;
        $this->propertyImage = $propertyImage;$this->upload_path = DIRECTORY_SEPARATOR.'propertyImages'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');

    }


    public function index() {
        $properties = $this->property->where('created_by', Auth::user()->id)->orderBy('created_at','desc')->paginate('12');
        return view('profile.property.view')->withproperties($properties);
    }
    public function show($slug){
        $property = $this->property->where('slug',$slug)->first();
        return view('profile.property.image')->withProperty($property);
    }
    public function store(Request $request)
    {


        $data = $request->except(['file']);
        $file = $request->file('file');
        $file_name = $file->getClientOriginalName();
        $data['property_id'] = $request->id;
        $data['image'] = 'propertyImages/'.$file_name;
        $this->storage->put('propertyImages/'.$file_name, file_get_contents($file->getRealPath()));

        $this->propertyImage->create($data);

        $image = $this->propertyImage->where('property_id',$request->id)->get();

        return response()->json(['success' =>true, 'image'=>$image]);
    }

    public function destroy(Request $request){

        $filename =  $request->get('image');
        $fileId =  $request->get('id');
        if(!empty($filename)) {
            $this->propertyImage->where('image', 'propertyImages/' . $filename)->delete();
            $path = public_path() . '/propertyImages/' . $filename;
            if (file_exists($path)) {
                unlink($path);
            }
            return $filename;
        }

            $image = $this->propertyImage->find($fileId);
            $this->propertyImage->where('id',$fileId )->delete();
            $path = public_path() . '/propertyImages/' . $image->name;
            if (file_exists($path)) {
                unlink($path);
            }
            return response()->json(['success' =>true, 'image'=>$image]);


    }
}
