<?php

namespace App\Http\Controllers;

use App\Models\AvTime;
use App\Models\Day;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class AvTimeController extends Controller
{
    use HttpResponses;
    public function index(){
        $avTimes = Day::latest()->filter(request(['expert_id']))->get();
        return $this->success($avTimes);
    }

}
