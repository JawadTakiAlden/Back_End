<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    use HttpResponses;
    public function index(){

        $messages = Message::where('conversation_id' , request('conversation_id'))->get();

        return $this->success($messages);
    }

    public function store(StoreMessageRequest $request){
        $request->validated($request->all());

        $message = Message::create($request->all());
        return $this->success($message);
    }

    public function destroy(Message $message){
        if (Auth::user()->id !== $message->from_user_id || Auth::user()->id !== $message->to_user_id  ){
            return $this->errors('' , 'You Are Not Authorize to Do This Request');
        }

        if(Auth::user()->id == $message->from_user_id){
            if ($message->to_user_id == null){
                $message->delete();
            }else{
                $message->update([
                    'from_user_id' => null
                ]);
            }
        }

        if(Auth::user()->id == $message->to_user_id){
            if ($message->from_user_id == null){
                $message->delete();
            }else{
                $message->update([
                    'to_user_id' => null
                ]);
            }
        }

        return $this->success('' , 'Your Message Has Been Deleted Successfully');

    }
}
