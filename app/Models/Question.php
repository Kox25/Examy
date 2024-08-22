<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'chapter_number', 'question_age', 'question_mark', 'question_complexity', 'subject_id'];

    //for getting subject data from son (question)
    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    //Get Related Answers (for getting question answers) 1:M (Question-Answer)
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function exams()
    {
        return $this->belongsToMany(
            Exam::class,
            'exams_questions',
            'question_id',
            'exam_id'
        );
    }
}
