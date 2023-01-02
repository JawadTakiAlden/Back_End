<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    use HttpResponses;

    public function index(){

        if (request('expert_id')){
            $skills = Skill::Where('expert_id' , request('expert_id'))
                ->get();
            return $this->success($skills);
        }
        $skills = Skill::where('expert_id' , Auth::user()->id)
            ->get();

        return $this->success($skills);
    }

    public function show(Skill $skill){
        return $skill;
        return $this->success($skill);
    }


    public function store(StoreSkillRequest $request){
        $request->validated($request->all());

        if (Auth::user()->role_id !== 2){
            return $this->errors("" , "You are not expert to do this request" , 401);
        }

        $skill = Skill::create(array_merge($request->all() , ['expert_id' => Auth::user()->id]));
        return $this->success($skill , "Your Skill Has Been Added Successfully");
    }
    public function update( Skill $skill , UpdateSkillRequest $request ){
        $request->validated($request->all());
        if (Auth::user()->role_id == 2 && Auth::user()->id == $skill->expert_id ){
            $skill->update($request->all());
            return $this->success($skill , "Your Skill Has Been Updated Successfully");
        }
        return $this->errors( '', "You are not authorize to do this request" , 401);
    }


    public function destroy(Skill $skill){
        if(! Auth::user()->id == $skill->expert_id){
            return $this->errors("" , "you are not authorize to do this request" , 502);
        }

        $skill->delete();

        return $this->success("" , "your skill has been deleted successfully");
    }

}
