<?php

namespace App\Http\Controllers;

use App\Models\WorkTime;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class AvilibleTimeController extends Controller
{
    use HttpResponses;
    public function get_free_time(){
        $expert_id = request('expert_id');

        if(!$expert_id){
            return $this->errors('' , 'the expert id is wrong or not found');
        }

        $WorkTime = WorkTime::with('day')->where('expert_id' , $expert_id)->get();

        return $WorkTime;

        // we want to get all work time that related to expert id that we expect
    }
}
