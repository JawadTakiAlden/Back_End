<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class FreeTimeController extends Controller
{
    use HttpResponses;
    public function index(){
        $avTime = Day::with('avTimes')
            ->filter(request(['expert_id']))
            ->get();

        return $this->success($avTime);
    }
}
