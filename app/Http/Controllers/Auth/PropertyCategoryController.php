<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\UserRepository;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PropertyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user, $category;

    public function __construct(UserRepository $user, CategoryRepository $category)
    {
        $this->category = $category;
        $this->user = $user;
    }

    public function index()
    {
        return view('user.category.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.category.create');
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
        $data['is_active'] = '0';
        if($this->category->create($data)){
            return redirect('auth/property_category')->with('success','Category created successfully');
        }
        return redirect('auth/property_category')->with('errors','Category cannot be created successfully');

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
        $category = $this->category->find($id);

        return view('user.category.edit')->withCategory($category);

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
        $category = $this->category->find($id);
        $data = $request->except('_token');
        $data['created_by'] = Auth::user()->id;
        if($this->category->update($category->id, $data)){
            return redirect('auth/property_category')->with('success','Category update successfully');
        }
        return redirect('auth/property_category')->with('errors','Category cannot be update successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);

        if($this->category->destroy($category->id)){

            $message = 'category Delete Successfully';
            return response()->json(['status'=>'ok','message'=>$message],200);

        }
        return response()->json(['status'=>'ok','message'=>'Class cannot be delete'],422);

    }
    public function changeStatus(Request $request)
    {
        $category = $this->category->find($request->get('id'));
        if ($category->is_active == 0) {
            $status = '1';
            $message = 'category with title "' . $category->name . '" is published.';
        } else {
            $status = '0';
            $message = 'category with title "' . $category->name . '" is unpublished.';
        }

        $this->category->changeStatus($category->id, $status);
        $this->category->update($category->id, array('is_active' => $status));
        $updated = $this->category->find($request->get('id'));
        return response()->json(['status' => 'ok', 'message' => $message, 'response' => $updated], 200);
    }
    public function getdata(){

        $categorys = $this->category->orderBy('created_at','desc')->get();

        return \DataTables::of($categorys)
            ->addColumn('action', function ($categorys) {
                $data ='';
                if(auth()->user()->can('edit-property-category')) {
                    $data .= '<a href="' . asset("auth/property_category/edit/$categorys->id") . '" class="btn btn-xs btn-primary btn-icon btn-rounded"  title="Edit-category"
                                   data-toggle="tooltip" > <i class="fa fa-edit"></i></a>';
                }
                if(auth()->user()->can('add-property-category')) {
                    $data .= '&nbsp; <a href="#"  data-type="' . $categorys->id . '" id="delete-category" class="btn btn-xs btn-danger btn-icon btn-rounded"  title="Delete-category"
                                   data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  ';
                }
                return $data;

            })
            ->addColumn('created_by',function($categorys){

                return  $categorys->user->name;
            })
            ->addColumn('status', function ($categorys) {
                if(auth()->user()->can('changestatus-property-category')) {
                    if ($categorys->is_active == '1')
                        return '<a href="#"  data-type="' . $categorys->id . '" id="change-status" class="btn btn-xs btn-success published"  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-check" aria-hidden="true"></i></a>';

                    if ($categorys->is_active == '0') return '<a href="#"  data-type="' . $categorys->id . '" id="change-status" class="btn btn-xs btn-success unpublished" "  title="change-status"
                                   data-toggle="tooltip"> <i class="fa fa-minus" aria-hidden="true"></i></a>';
                }

            })
            ->removeColumn('id')
            ->rawColumns(['action','created_by','status'])
            ->addIndexColumn()
            ->make(true);
    }
}
