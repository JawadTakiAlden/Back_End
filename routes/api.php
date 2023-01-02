<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultationItemController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\WorkTimeController;



    // Auth Controller
Route::post('/register' , [AuthController::class , 'register']);
Route::post('/login' , [AuthController::class , 'login']);

    // Middleware
Route::group(['middleware' => ['auth:sanctum']] , function () {
    // Auth Controller
    Route::post('/logout' , [AuthController::class , 'logout']);

    // User Controller
    Route::get('/users' ,[ \App\Http\Controllers\UserController::class , 'index' ]);
    Route::get('/users/{user}' ,[ \App\Http\Controllers\UserController::class , 'show' ]);
    Route::patch('/users/{user}' ,[ \App\Http\Controllers\UserController::class , 'update' ]);

    // update user image

    Route::post('/users/updateUserImage/{user}' , [\App\Http\Controllers\UserController::class , 'updateImage'] );

    // Skill Controller

    Route::get('/skills' , [SkillController::class , 'index']);
    Route::get('/skills/{skill}' , [SkillController::class , 'show']);
    Route::post('/skills' , [SkillController::class , 'store']);
    Route::patch('/skills/{skill}' , [SkillController::class , 'update']);
    Route::delete('/skills/{skill}' , [SkillController::class , 'destroy']);

    // Work Time Controller

    Route::get('/workTimes' , [WorkTimeController::class , 'index']);
    Route::get('/workTimes/{workTime}' , [WorkTimeController::class , 'show']);
    Route::post('/workTimes' , [WorkTimeController::class , 'store']);
    Route::patch('/workTimes/{workTime}' , [WorkTimeController::class , 'update']);
    Route::delete('/workTimes/{workTime}' , [WorkTimeController::class , 'destroy']);


    // Consultation Items Controller

    Route::get('/consultations' , [ConsultationItemController::class , 'index']);
    Route::get('/consultations/{consultationItem}' , [ConsultationItemController::class , 'show']);
    Route::post('/consultations' , [ConsultationItemController::class , 'store']);
    Route::patch('/consultations/{consultationItem}' , [ConsultationItemController::class , 'update']);
    Route::delete('/consultations/{consultationItem}' , [ConsultationItemController::class , 'destroy']);

    //consultation type

    Route::post('/consultations/rating/{consultationItem}' , [ConsultationItemController::class , 'rating']);

    Route::get('/consultationType' , [\App\Http\Controllers\ConsultationTypeController::class , 'index']);

    // Conversation Controller

    Route::get('/conversations' , [\App\Http\Controllers\ConversationController::class , 'index']);
    Route::delete('/conversations/{conversation}' , [\App\Http\Controllers\ConversationController::class , 'destroy']);

    // Message Controller

    Route::get('/messages' , [\App\Http\Controllers\MessageController::class , 'index']);
    Route::post('/messages' , [\App\Http\Controllers\MessageController::class , 'store']);
    Route::delete('/messages/{message}' , [\App\Http\Controllers\MessageController::class , 'destroy']);


    // Dating Controller

    Route::get('/dates' , [\App\Http\Controllers\DatingController::class , 'index']);
    Route::post('/dates' , [\App\Http\Controllers\DatingController::class , 'create']);


    // Available Time Controller
    Route::get('/availableTime' , [\App\Http\Controllers\AvTimeController::class , 'index']);

    // Search Controller
    Route::get('/search' , [SearchController::class , 'search']);

});
