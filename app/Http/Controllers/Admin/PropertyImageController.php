<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\PropertyImageRepository;
use App\Repositories\PropertyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Gate;

class PropertyImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $propertyImage, $property;

    public function __construct(PropertyImageRepository $propertyImage, PropertyRepository $property)
    {
        $this->property = $property;
        $this ->propertyImage = $propertyImage;
        $this->upload_path = DIRECTORY_SEPARATOR.'propertyImages'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
        
    }

    public function index($id)
    {
        $property = $this->property->find($id);
        $images= $this->propertyImage->where('property_id',$id)->get();
        return view('layouts.backend.property.image')->withProperty($property )->withImages($images);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function create($id)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $property = $this->property->find($id);
        return view('layouts.backend.property.upload')->withProperty($property);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $data = $request->except(['file']);
        $file = $request->file('file');
        $file_name = time()."_".$file->getClientOriginalName();
        $data['property_id'] = $id;
        $data['image'] = 'propertyImages/'. $id. '/' .$file_name;
        $this->storage->put('propertyImages/'.$id.'/'.$file_name, file_get_contents($file->getRealPath()));

        $this->propertyImage->create($data);
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
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $product = $this->propertyImage->find($id);

        if($this->propertyImage->destroy($product->id)){

            $message = 'Property Image Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);

    }
}
