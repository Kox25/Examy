<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ExamController;

use App\Http\Controllers\MailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

//Get All Employees, Create Employee, Update Employee, Delete Employee
Route::apiResource('employees', EmployeeController::class);
//Get All Employees By Type
Route::get('employees/type/{type}', [EmployeeController::class, 'getEmployeesByType']);
//Get Employee Subjects
Route::get('employee-subjects/{empId}', [EmployeeController::class, 'getEmployeeSubjects']);
//Add Subject To Employee
Route::post('employee-subjects', [EmployeeController::class, 'addEmployeeSubject']);

//Get All Subjects, Create Subject, Update Subject, Delete Subject
Route::apiResource('subjects', SubjectController::class);
//Get Subject Questions
Route::get('subject-questions/{subjectId}', [SubjectController::class, 'getSubjectQuestions']);

//Get All Questions, Create Question, Update Question, Delete Question
Route::apiResource('questions', QuestionController::class);
//Get Question Answers
Route::get('question-answers/{questionId}', [QuestionController::class, 'getQuestionAnswers']);
//Generate Question Paper Randomly Depend on Complexity Level
Route::post('generate-question-paper', [QuestionController::class, 'generateRandomQuestion']);

//Get All Answers, Create Answer, Update Answer, Delete Answer
Route::apiResource('answers', AnswerController::class);

//Get All Exams, Create Exam, Update Exam, Delete Exam
Route::apiResource('exams', ExamController::class);
//Get Exam Questions
Route::get('exam-questions/{examId}', [ExamController::class, 'getExamQuestions']);

Route::get('mails/send/{days}', [MailController::class, 'sendMail']);
