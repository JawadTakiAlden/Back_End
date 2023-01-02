<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDateRequest;
use App\Models\AvTime;
use App\Models\ConsultationItem;
use App\Models\Date;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatingController extends Controller
{
    use HttpResponses;
    public function index(){
        $dates = Date::with('day' , 'consultationItem')
            ->where('doing_booking' , Auth::user()->id)
            ->orWhere('booking_on' , Auth::user()->id)
            ->get();

        return $this->success($dates);
    }
    public function show(){
        //
    }
    public function create(StoreDateRequest $request){
        $avTimeId = request('av_time');
        $booking_on = User::where('id' , $request->booking_on)->first();
        if ($booking_on->role_id !== 2){
            return $this->errors('' , 'you are not authorize to do this request' , 502);
        }

        $avTime = AvTime::where('id' , $avTimeId)->first();

        if ($avTime->isBooking == true){
            return $this->errors('' , 'sorry this time already booking' , 502);
        }

        $avTime->update([
            'isBooking' => true
        ]);


        Date::create([
           'doing_booking' => Auth::user()->id,
            'booking_on' => $request->booking_on,
            'consultation_item_id' => $request->consultation_item_id,
            'time_start' => $avTime->time_start,
            'time_end' => $avTime->time_end,
            'day_id' => $avTime->day_id
        ]);
        $consultation = ConsultationItem::where('id' , $request->consultation_item_id)->first();
        $doing_booking = User::where('id' , Auth::user()->id)->first();
        $booking_on = User::where('id' , $request->booking_on)->first();

        $doing_booking->update([
            'bag' => $doing_booking->bag - $consultation->price
        ]);
        $booking_on->update([
            'bag' => $booking_on->bag + $consultation->price
        ]);

        return $this->success('' , 'Your Date Has Been Created Successfully');
    }
}
