<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Subject;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'password', 'type'];

    //Get Related Subjects (for getting employee subjects) M:M (Employee-Subject)
    public function subjects()
    {
        //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Subject::class,
            'employees_subjects',
            'employee_id',
            'subject_id'
        );
    }
}
