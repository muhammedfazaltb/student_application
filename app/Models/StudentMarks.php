<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class StudentMarks extends Model
{
    //
    protected  $table='student_mark';
    protected  $primaryKey='id';
    protected $fillable = [
    'student_id',
    'subject_id',
    'teacher_id',
    'mark',
    ];
}
