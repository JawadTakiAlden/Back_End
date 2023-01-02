<?php

namespace App\Traits;

trait HttpResponses {
    protected function success($data , $message = null , $code = 200){
        return response()->json([
           "status" => "request was successful" ,
            "message" => $message,
            "data" => $data
        ] , $code);
    }

    protected function errors ($data , $message = null , $code){
        return response()->json([
            "status" => "Errors has occurred...." ,
            "message" => $message,
            "data" => $data
        ] , $code);
    }
}
