<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Http\Resources\ExamResource;
use App\Http\Resources\QuestionResource;

use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

class ExamController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Get All Exams
    public function index()
    {
        return ExamResource::collection(Exam::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    //Create new Exam
    public function store(Request $request)
    {
        //dd($request->name);
        $create_exam = Exam::create([]);

        $request['examId'] = $create_exam->id;

        $file_url = $this->addExamQuestions($request);

        return  [
            'url' =>  $file_url,
            'examId' => $create_exam->id
        ];
    }

    //Add Exam Question
    public function addExamQuestions(Request $request)
    {
        $exam = Exam::find((int)$request->examId); //any item we want to find
        $exam ? null : abort(404, "Cant't found any User matches your search !!");

        //$exam->questions()->attach((int)$request->questionId); //pass id or array of a Question ids (passing on id)
        $exam->questions()->attach($request->questionIds); //pass id or array of a Question ids (passing array of ids)

        $file_url = $this->generateExamPdfPaper($request);

        return $file_url;
    }

    public function generateExamPdfPaper(Request $request){
        //Convert Word Document to PDF file
        // Define the path of this library :
        $rendererName = \PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF;
        $rendererLibraryPath = base_path('vendor/dompdf/dompdf');
        Settings::setPdfRenderer($rendererName, $rendererLibraryPath);

        //Load word file
        //$phpWord = \PhpOffice\PhpWord\IOFactory::load('ExamPaper.docx');
        $word_doc = $request->file_name . '.docx';
        $phpWord = IOFactory::load($word_doc);
        
        //Save it (as pdf document)
        $xmlWriter = IOFactory::createWriter($phpWord, 'PDF');
        // $xmlWriter->save('ExamPaper.pdf');
        $pdf_doc = $request->file_name . '.pdf';
        $xmlWriter->save($pdf_doc);

        $file_url = public_path() ."\\" . $pdf_doc;

        return $file_url;
    }

    //Get Exam Questions with their Answers
    public function getExamQuestions($examId)
    {
        // dd($examId);
        $exam = Exam::find($examId);
        $exam ? null : abort(404, "Cant't found any User matches your search !!");
         $exam_questions = $exam->questions;
        //$employee_subjects ? null : abort(404, "Cant't found any User matches your search !!");
         return QuestionResource::collection($exam_questions);
    }
}
