<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateImageOfUserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use HttpResponses;

    public function index(){
        $user = User::where('role_id' , 2)->get();

        return $this->success($user);
    }

    //TODO when we return user we should return image as file not as path
    public function show(User $user){

        return $this->success($user);
    }

    public function update(UserUpdateRequest $request , User $user)
    {
        $request->validated($request->all());

        if(Auth::user()->id !== $user->id){
            return $this->errors('' , 'you are not authorize to do this request' , 502);
        }

        $user->update($request->all());

        return $this->success($user, 'Your Information Has Been Updated Successfully');
    }

    public function updateImage(UpdateImageOfUserRequest $request , User $user){
        $request->validated($request->image);
        if(Auth::user()->id !== $user->id){
            return $this->errors('' , 'you are not authorize to do this request' , 502);
        }

        $user->update($request->all());

        return $this->success($user , 'your image has been updated successfully');

    }
}
