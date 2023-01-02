<?php

namespace App\Http\Controllers;

use App\Models\ConsultationType;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ConsultationTypeController extends Controller
{
    use HttpResponses;

    public function index(){
        $consultationType = ConsultationType::all();

        return $this->success($consultationType);
    }
}
