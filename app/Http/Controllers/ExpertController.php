<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    use HttpResponses;
    public function allExperts(){
        $experts = User::where('role_id' , 2)->get();

        return $this->success($experts);
    }
    public function expert(){

        $experts = User::latest()->filter(request(['role_id','expert_id','name']))->get();

        return $this->success($experts);
    }
}
