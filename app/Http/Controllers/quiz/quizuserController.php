<?php

namespace App\Http\Controllers\quiz;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\QuizResource;
use App\quiz;
use App\User;

class quizuserController extends ApiController
{
    public function index(User $user)
    {
        //print_r($user);
        $quizusers = $user->quizzes();
        return $this->collectionResponse(quizResource::collection($this->getModel(new quiz,['user'],$quizusers)));
    }
}
