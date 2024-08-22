<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    //Get Related Questions (for getting exam questions) M:M (Exam-Question)
    public function questions()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Question::class,
            'exams_questions',
            'exam_id',
            'question_id'
        );
    }
}
