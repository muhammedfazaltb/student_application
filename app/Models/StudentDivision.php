<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDivision extends Model
{
    //
    protected  $table='table_division';
    protected  $primaryKey='id';
    protected $fillable = [
    'class_id',
    'division_name'
    ];
}
