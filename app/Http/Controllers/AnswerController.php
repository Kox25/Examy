<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Http\Resources\AnswerResource;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Get All Answers
    public function index()
    {
        return AnswerResource::collection(Answer::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnswerRequest  $request
     * @return \Illuminate\Http\Response
     */
    //Create new Answer
    public function store(StoreAnswerRequest $request)
    {
        $create_answer = Answer::create([
            'answer' => $request->answer,
            'is_correct' => $request->is_correct,
            'question_id' => (int)$request->question_id
        ]);

        return new AnswerResource($create_answer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    //Get Answer By Id
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnswerRequest  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    //Update Answer Data
    public function update(UpdateAnswerRequest $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    //Delete Answer
    public function destroy($id)
    {
        $found = Answer::where('id', $id)->first();
        $found ? null : abort(404, "Cant't found any User matches your search !!");
        $found->delete();
        return new AnswerResource($found);
    }
}
