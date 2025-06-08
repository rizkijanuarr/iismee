<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
    public function lecturer()
    {
        return $this->belongsTo('App\Models\Lecturer');
    }
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
    public function assesmentAspect()
    {
        return $this->belongsTo('App\Models\AssesmentAspect');
    }
}
