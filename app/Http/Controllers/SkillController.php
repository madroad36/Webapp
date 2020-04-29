<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceSubCategoryRepository;
use App\Repositories\SkillsRepository;
use App\Repositories\TechnicianRepository;
use Illuminate\Http\Request;
use Auth;

class SkillController extends Controller
{

    protected $skill, $serviceSubcategory, $technician;

    public function __construct(SkillsRepository $skill, ServiceSubCategoryRepository $serviceSubcategory,TechnicianRepository $technician)
    {
        $this->skill = $skill;
        $this->serviceSubcategory = $serviceSubcategory;
        $this->technician = $technician;
    }

    public function create(){
        $category = $this->serviceSubcategory->orderBy('created_at','desc')->get();
        return view('profile.skill.create')->withCategory($category);
    }

    public function store(Request $request){
        $data = $request->except('_token');
        $data['user_id'] = Auth::user()->id;

        if($this->skill->create($data)){
            return redirect('view/profile')->with('success','Skill Added success fully');
        }
        return redirect()->back()->with('success','Skill cannot added success fully');
    }

}
