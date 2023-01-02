<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsultationRequest;
use App\Http\Requests\UpdateConsultationRequest;
use App\Models\ConsultationItem;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationItemController extends Controller
{
    use HttpResponses;

    public function index(){
        $consultations = ConsultationItem::latest()->filter(request(['type_id' , 'expert_id']))->get();

        return $this->success($consultations);
    }

    public function show(ConsultationItem $consultationItem){
        return $this->success($consultationItem);
    }

    public function store(StoreConsultationRequest $request){
        $request->validated($request->all());

        if(Auth::user()->role_id !== 2){
            return $this->errors('' , 'You Are Not Authorize To Do This Request' , 502);
        }

        $consultation = ConsultationItem::create(array_merge($request->all() , ['expert_id' => Auth::user()->id]));

        return $this->success($consultation);
    }

    public  function update(UpdateConsultationRequest $request , ConsultationItem $consultationItem){
        $request->validated($request->all());

        if(Auth::user()->id !== $consultationItem->expert_id){
            return $this->errors('' , 'You Are Not Authorize To Do This Request');
        }

        $consultationItem->update($request->all());

        return $this->success($consultationItem , 'Your Consultation Has BEen Updated Successfully');
    }

    public function destroy(ConsultationItem $consultationItem){
        if (Auth::user()->id !== $consultationItem->expert_id){
            return $this->errors('' , 'You Are Not Authorize To Do This Request');
        }

        $consultationItem->delete();

        return $this->success(''  , 'Your Consultation Has Been Deleted Successfully');
    }

    public function rating(ConsultationItem $consultationItem){

        $currentRating = request('new_rating');
        $oldRating = $consultationItem->rate;
        $expert = User::where('id' , $consultationItem->expert_id)->first();


        if($consultationItem->number_of_rating == 0){
            $newRating = $currentRating + $oldRating;
            $newRateOfExpert = $expert->rate + $currentRating;
            $consultationItem->update([
                'rate' => $newRating,
                'number_of_rating' => $consultationItem->number_of_rating + 1
            ]);
            $expert->update([
               'rate' => $newRateOfExpert
            ]);
        }

        $newRating = ($currentRating + $oldRating) / 2 ;
        $newRateOfExpert = ($expert->rate + $currentRating) / 2 ;

        $consultationItem->update([
            'rate' => $newRating,
            'number_of_rating' => $consultationItem->number_of_rating + 1
        ]);

        $expert->update([
            'rate' => $newRateOfExpert
        ]);


        return $this->success('' , 'thank you for your rating');
    }

}
