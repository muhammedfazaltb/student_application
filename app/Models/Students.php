<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    //
    protected  $table='table_student';
    protected  $primaryKey='id';
    protected $fillable = [
    'name',
    'address_one',
    'address_two',
    'role_no',
    'class_id',
    'division_id',
    'teacher_id',
    'image'
    ];
}
