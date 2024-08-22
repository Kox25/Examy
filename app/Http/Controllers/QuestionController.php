<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use App\Models\Answer;
use App\Http\Resources\AnswerResource;

use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

use Carbon\Carbon;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Get All Questions with thier answers
    public function index()
    {
        //Get all Questions
        return QuestionResource::collection(Question::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    //Create new Question
    public function store(StoreQuestionRequest $request)
    {
        $create_question = Question::create([
            'question' => $request->question,
            'chapter_number' => (int)$request->chapter_number,
            'question_age' => (int)$request->question_age,
            'question_complexity' => $request->question_complexity,
            'question_mark' => (int)$request->question_mark,
            'subject_id' => (int)$request->subject_id,
        ]);

        return new QuestionResource($create_question);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    // Get Question Data by Id
    public function show(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionRequest  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    // Update Question Data
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    // Delete Question
    public function destroy($id)
    {
        $found = Question::where('id', $id)->first();
        $found ? null : abort(404, "Cant't found any User matches your search !!");
        $found->delete();
        return new QuestionResource($found);
    }

    //Get Question Answers
    public function getQuestionAnswers($questionId)
    {
        return AnswerResource::collection(Answer::where('question_id', $questionId)->get());
    }

    //Generate Random Questions with their answers on conditions (subject_id, question_complexity)
    public function generateRandomQuestion(Request $request)
    {
        //Generate random Questions
        $questions = Question::inRandomOrder()->where([
            'subject_id' => $request->subject_id,
            'question_complexity' => $request->question_complexity
        ])
            ->limit(50)
             
            #here you can change the limit as what the user want 
            #if you want to take the range from the user you have to declare variable 
            #and give him to the user for take the limit questions 

            ->get();

        $questionIds = array();

        //Create Word Doc

        //$phpWord =  new \PhpOffice\PhpWord\PhpWord();
        // phpofice its the library that give me files of pdf and word 
        $phpWord =  new PhpWord();
        //adding word new page
        $section = $phpWord->addSection();

        foreach ($questions as $i => $question) {
            $index = $i + 1;
            //adding text to word page in new line
            $text = $section->addText("Question {$index}: " . $question->question);

            $questionIds[] = $question->id;

            $answers = $question->answers;

            foreach ($answers as $j => $answer) {
                $answer_index = $j + 1;
                //adding text to word page in new line
                $text = $section->addText("{$answer_index} - " . $answer->answer);
            }
        }

        $current_timestamp = Carbon::now()->timestamp;
        $file_name = 'ExamPaper_' . $question->subject->name . '_' . $current_timestamp;
        $file_extension = '.docx';
        $word_doc = $file_name . $file_extension;

        //writing word file in public folder
        //$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        // $objWriter->save('ExamPaper.docx');
        //$objWriter->save('ExamPaper_' . $current_timestamp . '.docx');
        $objWriter->save($word_doc);

        $file_url = public_path() . "\\" . $word_doc;

        return [
            'questionIds' => $questionIds,
            //'url' => public_path()."\ExamPaper.docx",
            'url' => $file_url,
            'file_name' => $file_name,
            'questions' => $questions
        ];
        // return QuestionResource::collection($questions);
    }
}
