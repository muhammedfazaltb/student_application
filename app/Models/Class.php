<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Class extends Model
{
    //
    protected  $table='table_class';
    protected  $primaryKey='id';
    protected $fillable = [
    'class_name'
    ];
}
