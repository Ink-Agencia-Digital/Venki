<?php

namespace App\Http\Controllers\Survey;

use App\Category;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\QuestionResource;
use App\Question;
use App\Survey;
use Illuminate\Http\Request;

class SurveyCategoryQuestionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idsurvey, $idcategory)
    {
        $questions = Question::join('answers','answers.question_id','=','questions.id')->where('survey_id','=',$idsurvey)->where('category_id', '=', $idcategory)->get();
        //return $this->collectionResponse(QuestionResource::collection($this->getModel(new Question, ['answers'], $questions))->all());
        return $this->showAll($questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
