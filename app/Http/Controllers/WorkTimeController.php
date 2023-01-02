<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkTimeRequest;
use App\Http\Requests\UpdateWorkTimeRequest;
use App\Models\AvTime;
use App\Models\Day;
use App\Models\User;
use App\Models\WorkTime;
use App\Traits\HttpResponses;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorkTimeController extends Controller
{
    use HttpResponses;

    public function index(){

        if(request('expert_id')){
            $workTimes = WorkTime::with('day')->where('expert_id' , request('expert_id'))->get();
            return $this->success($workTimes);
        }
        $workTimes = WorkTime::with('day')->where('expert_id' , Auth::user()->id)->get();
        return $this->success($workTimes);
    }

    public function show(WorkTime $workTime){
        return $this->success($workTime);
    }
    public function store(StoreWorkTimeRequest $request){
        $request->validated($request->all());

        if(Auth::user()->role_id != 2){
            return $this->errors('' , 'You Are Not Authorize To Do This Request');
        }
        $time_start = $request->time_start;
        $time_end = $request->time_end;

        $h_start = Carbon::createFromTimeString($time_start)->hour;
        $m_start = Carbon::createFromTimeString($time_start)->minute;
        $s_start = Carbon::createFromTimeString($time_start)->second;

        $h_end = Carbon::createFromTimeString($time_end)->hour;
        $m_end = Carbon::createFromTimeString($time_end)->minute;
        $s_end = Carbon::createFromTimeString($time_end)->second;

        $c_time_start = Carbon::create(now()->year , now()->month  , now()->day , $h_start , $m_start , $s_start);
        $c_time_end = Carbon::create(now()->year , now()->month  , now()->day ,  $h_end , $m_end , $s_end);



        $c_time_start_w = Carbon::create(now()->year , now()->month  , now()->day , $h_start , $m_start , $s_start);
        $c_time_end_w = Carbon::create(now()->year , now()->month  , now()->day ,  $h_end , $m_end , $s_end);
        $workTime = WorkTime::create([
            'expert_id' => Auth::user()->id,
            'day_id' => $request->day_id,
            'time_start' => $c_time_start_w,
            'time_end' =>$c_time_end_w
        ]);

        while ($c_time_start->copy()->addMinutes(40)->lessThanOrEqualTo($c_time_end)){
            AvTime::create([
                'expert_id' => Auth::user()->id,
                'day_id'=>$request->day_id,
                'work_time_id'=>$workTime->id,
                'time_start'=>$c_time_start,
                'time_end' => $c_time_start->copy()->addMinutes(30)
            ]);
            $c_time_start->addMinutes(40);
        }

        return $this->success($workTime , 'Your Work Time Has Been Created Successfully');
    }

//    public function update( UpdateWorkTimeRequest $request , WorkTime $workTime){
//        $request->validated($request->all());
//        $workTime->update($request->all());
//        AvTime::where('work_time_id' , $workTime->id)->delete();
//        $time_start = $workTime->time_start;
//        $time_end = $workTime->time_end;
//
//        $h_start = Carbon::createFromTimeString($time_start)->hour;
//        $m_start = Carbon::createFromTimeString($time_start)->minute;
//        $s_start = Carbon::createFromTimeString($time_start)->second;
//
//        $h_end = Carbon::createFromTimeString($time_end)->hour;
//        $m_end = Carbon::createFromTimeString($time_end)->minute;
//        $s_end = Carbon::createFromTimeString($time_end)->second;
//
//        $c_time_start = Carbon::create(now()->year , now()->month  , now()->day , $h_start , $m_start , $s_start);
//        $c_time_end = Carbon::create(now()->year , now()->month  , now()->day ,  $h_end , $m_end , $s_end);
//
//        while ($c_time_start->copy()->addMinutes(40)->lessThanOrEqualTo($c_time_end)){
//            AvTime::create([
//                'expert_id' => Auth::user()->id,
//                'day_id'=>$request->day_id,
//                'work_time_id'=>$workTime->id,
//                'time_start'=>$c_time_start,
//                'time_end' => $c_time_start->copy()->addMinutes(30)
//            ]);
//            $c_time_start->addMinutes(40);
//        }
//        return $this->success('' , 'Your Work Time Has Been Updated Successfully');
//    }

    public function destroy(WorkTime $workTime){

        if(Auth::user()->id !== $workTime->expert_id){
            return $this->errors('' , 'You Are Not Authorize To Do This Request' , 402);
        }
        $workTime->delete();
        AvTime::where('work_time_id' , $workTime->id)->delete();
        return $this->success('' , 'Your Work Time Has Been deleted Successfully');
    }

}
