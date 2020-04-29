<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SkillsRepository;
use App\Repositories\TechnicianRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $skill, $technician;

    public function __construct(SkillsRepository $skill, TechnicianRepository $technician)
    {
        $this->skill = $skill;
        $this->technician = $technician;
    }

    public function index()
    {
        //
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
        //
    }

//    public function getsubcategory($subcategory){
//
//        $skill = $this->skill->where('subcategory_id',$subcategory)->get();
//
//        $data = [];
//        foreach ($skill as $key=>$value) {
//            $data[] = [
//                'id' => $value->user->id,
//                'name' => $value->user->name
//            ];
//        }
//
//        if($skill->isNotEmpty()){
//
//            return response()->json(['status' => 'ok', 'data' => $data], 200);
//        }
//        return response()->json(['status' => 'error', 'message' => ''], 422);
//
//    }
    public function getcategory($id){
        $technician = $this->technician->where('category_id',$id)->orderBy('created_at','asc')->get();
        $data = [];
        foreach ($technician  as $key=>$value) {
            $data[] = [
                'id' => $value->user->id,
                'name' => $value->user->name
            ];
        }
        return response()->json(['status' => 'ok', 'data' =>$data], 200);
    }
}
