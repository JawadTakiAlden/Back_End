<?php

namespace App\Http\Controllers;

use App\Models\ConsultationItem;
use App\Models\ConsultationType;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use HttpResponses;

    public function search(){
        $experts = User::latest()->filter(['search' , 'type_id'])->get();
        $consultations = ConsultationItem::latest()->filter(['search' , 'type_id'])->get();

        return $this->success([
            'experts' => $experts,
            'consultations' => $consultations,
        ]);
    }
}
