<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\Question;
use App\Http\Resources\QuestionResource;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Get All Subjects
    public function index()
    {
        return SubjectResource::collection(Subject::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    //Create new Subject
    public function store(StoreSubjectRequest $request)
    {
        $create_subject = Subject::create([
            'name' => $request->name,
        ]);

        return new SubjectResource($create_subject);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    //Get Subject By Id
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubjectRequest  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    //Update Subject Data
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    //Delete Subject
    public function destroy($id)
    {
        $found = Subject::where('id', $id)->first();
        $found ? null : abort(404, "Cant't found any User matches your search !!");
        $found->delete();
        return new SubjectResource($found);
    }

    //Get Subject Questions
    public function getSubjectQuestions($subjectId)
    {
        return QuestionResource::collection(Question::where('subject_id', $subjectId)->get());
    }
}
