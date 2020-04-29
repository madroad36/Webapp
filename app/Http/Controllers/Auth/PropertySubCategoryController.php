<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\SubCategory\SubCategoryStoreRequest;
use App\Http\Requests\SubCategory\SubCategoryUpdateRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\SubcategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropertySubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $category, $subcategory;

    public  function __construct(CategoryRepository $category, SubcategoryRepository $subcategory )
    {
        $this->category = $category;
        $this->subcategory = $subcategory;
    }

    public function index()
    {
        return view('user.subcategory.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->category->where('is_active','1')->get();
        return view('user.subcategory.create')->withCategories($categories);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryStoreRequest $request)
    {
        $data = $request->except('_token');

        if($this->subcategory->create($data)){
            return redirect('auth/property_subcategory')->with('success','Property Subcategory is Created Successfully');
        }
        return redirect()->back()->with('errors','Property Subcategory Can not  Created Successfully');

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
        $subcategory = $this->subcategory->find($id);
        $categories = $this->category->where('is_active','1')->get();
        return view('user.subcategory.edit')->withCategories($categories)->withSubcategory($subcategory);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoryUpdateRequest $request, $id)
    {
        $subcategory = $this->subcategory->find($id);

        $data = $request->except('_token');

        if($this->subcategory->update( $subcategory->id,$data)){
            return redirect('auth/property_subcategory')->with('success','Property Subcategory is Updated Successfully');
        }
        return redirect()->back()->with('errors','Property Subcategory Can not  Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = $this->subcategory->find($id);

        if($this->subcategory->destroy($subcategory->id)){

            $message = 'Subcategory Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);

    }
    public function changeStatus(Request $request)
    {
        $subcategory = $this->subcategory->find($request->get('id'));
        if ($subcategory->is_active == 0) {
            $status = '1';
            $message = 'subcategory with title "' . $subcategory->name . '" is published.';
        } else {
            $status = '0';
            $message = 'subcategory with title "' . $subcategory->name . '" is unpublished.';
        }

        $this->subcategory->changeStatus($subcategory->id, $status);
        $this->subcategory->update($subcategory->id, array('is_active' => $status));
        $updated = $this->subcategory->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function getdata(){

        $subcategorys = $this->subcategory->orderBy('created_at','desc')->get();

        return \DataTables::of($subcategorys)
            ->addColumn('action', function ($subcategorys) {
                $data = '';
                if (auth()->user()->can('edit-property-subcategory')){
                    $data .= '<a href="' . asset("auth/property_subcategory/edit/$subcategorys->id") . '" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-subcategory"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>';
            }
                if (auth()->user()->can('edit-property-subcategory')){
                      $data .='&nbsp;  <a href="#"  data-type="'.$subcategorys->id.'" id="delete-category" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-subcategory"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  ';
                                  }
                                  return $data;

            })
            ->addColumn('category',function($subcategorys){

                return  $subcategorys->category->name;
            })
            ->addColumn('status', function ($subcategorys) {
                if(auth()->user()->can('changestatus-property-subcategory')) {
                    if ($subcategorys->is_active == '1')
                        return '<a href="#"  data-type="' . $subcategorys->id . '" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                    if ($subcategorys->is_active == '0') return '<a href="#"  data-type="' . $subcategorys->id . '" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';
                }

            })
            ->removeColumn('id')
            ->rawColumns(['action','category','status'])
            ->addIndexColumn()
            ->make(true);
    }
}
