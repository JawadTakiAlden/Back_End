<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationController;
use App\Models\Conversation;
use App\Models\Message;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    use HttpResponses;
    public function index(){
        $conversation = Conversation::with('users')
            ->where('user_id_one' , Auth::user()->id)
            ->orWhere('user_id_two' , Auth::user()->id)
            ->get();

        return $this->success($conversation);
    }

    public function destroy(Conversation $conversation){
        if(Auth::user()->id !== $conversation->user_id_one || Auth::user()->id !== $conversation->user_id_twoS){
            return $this->errors('' , 'You Are Not Authorize To Do This Request');
        }

        if(Auth::user()->id == $conversation->user_id_one){
            if($conversation->user_id_two == null){
                Message::where('conversation_id' , $conversation->id)->delete();
                $conversation->delete();
            }else{
                $conversation->update([
                    'user_id_one' => null
                ]);
            }
        }else if (Auth::user()->id == $conversation->user_id_two){
            if($conversation->user_id_two == null){
                Message::where('conversation_id' , $conversation->id)->delete();
                $conversation->delete();
            }else{
                $conversation->update([
                    'user_id_two' => null
                ]);
            }
        }
        return $this->success("", "your conversation has been deleted Successfully");
    }


    // ToDo
    public function create(StoreConversationController $request){
        $request->validated($request->all());

        $conversation = Conversation::create($request->all());

        $conversationtwo = Conversation::with('users')->where('id' , $conversation->id)->get();

        return $this->success($conversationtwo , "your conversation has been created");
    }

}
