<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductCategory\CategoryStoreRequest;
use App\Http\Requests\ProductCategory\CategoryUpdateRequest;
use App\Repositories\ProductCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Gate;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $productCategory;
    public function __construct(ProductCategoryRepository $productCategory)
    {
        $this->productCategory = $productCategory;
    }

    public function index()
    {
        return view('layouts.backend.productCategory.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        return view('layouts.backend.productCategory.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $data = $request->except('_token');

        $data['created_by'] = Auth::user()->id;

        if($this->productCategory->create($data)){
            return redirect('admin/product_category')->with('success','Product category created successfully');
        }
        return redirect('admin/product_category')->with('errors','Product category cannot created successfully');

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
    public function edit($slug)
    {
        if(!Gate::allows('isAdmin')){
            return redirect()->back()->with('warning','Unauthorized Action.');
        }
        $category = $this->productCategory->where('slug',$slug)->first();
        return view('layouts.backend.productCategory.edit')->withCategory($category);



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = $this->productCategory->find($id);

        $data = $request->except('_token');

        $data['created_by'] = Auth::user()->id;

        if($this->productCategory->update($category->id,$data)){
            return redirect('admin/product_category')->with('success','Product category update  successfully');
        }
        return redirect('admin/product_category')->with('errors','Product category cannot update successfully');

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
        $category = $this->productCategory->find($id);

        if($this->productCategory->destroy($category->id)){

            $message = 'product category Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);

    }
    public function changeStatus(Request $request)
    {
        if(!Gate::allows('isAdmin')){
            abort(404,"Permission Denied.");
        }
        $category = $this->productCategory->find($request->get('id'));
        if ($category->is_active == 0) {
            $status = '1';
            $message = 'product category with title "' . $category->name . '" is published.';
        } else {
            $status = '0';
            $message = 'product category with title "' . $category->name . '" is unpublished.';
        }

        $this->productCategory->changeStatus($category->id, $status);
        $this->productCategory->update($category->id, array('is_active' => $status));
        $updated = $this->productCategory->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function getdata(){

        $categorys = $this->productCategory->orderBy('created_at','desc')->get();

        return \DataTables::of($categorys)
            ->addColumn('action', function ($categorys) {
                    return '<a href="'.asset("admin/product_category/edit/$categorys->slug").'" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-category"
                    data-toggle="tooltip" > <i class="fa fa-edit"></i></a>
                    <a href="#"  data-type="'.$categorys->id.'" id="delete-category" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-category"
                    data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    ';
            })
            ->addColumn('created_by',function($categorys){

                return  $categorys->user->name;
            })
            ->addColumn('status', function ($categorys) {
                    if($categorys->is_active == '1')
                        return  '<a href="#"  data-type="'.$categorys->id.'" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                    data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                    if($categorys->is_active == '0')   return  '<a href="#"  data-type="'.$categorys->id.'" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
                    data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';

            })
            ->removeColumn('id')
            ->rawColumns(['action','created_by','status'])
            ->addIndexColumn()
            ->make(true);
    }
}
