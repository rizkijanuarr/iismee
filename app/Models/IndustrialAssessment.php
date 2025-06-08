<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustrialAssessment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
    public function industrialAdviser()
    {
        return $this->belongsTo('App\Models\IndustrialAdviser');
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
