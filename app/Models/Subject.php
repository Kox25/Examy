<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Employee;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //Get Related Employees (for getting subject employees) M:M (Employee-Subject)
    public function employees()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Employee::class,
            'employees_subjects',
            'subject_id',
            'employee_id'
        );
    }

    //Get Related Questions (for getting subject questions) 1:M (Subject-Question)
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
