<?php

namespace App\Http\Controllers\quiz;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StorequizRequest;
use App\Http\Resources\QuizResource;
use App\quiz;
use App\User;
use Illuminate\Http\Request;

class quizController extends ApiController
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
     * @param  \Illuminate\Http\Request 
     * $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorequizRequest $request)
    {
       
        foreach($request->all() as $item)
        {
            $quiz = new quiz;
            $quiz->id_user=$item['id_user'];
            $quiz->id_resource = $item['id_resource'];
            $quiz->pregunta = $item['pregunta'];
            $quiz->respuesta = $item['respuesta'];
            //$quiz->fill($item->all());
            $quiz->saveOrFail();
        }        
        return $this->api_success([
            'data' => new QuizResource($quiz),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(quiz $quiz)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\quiz  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(quiz $quiz)
    {
        
    }

}
