<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssesmentAspect extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function subjec()
    {
        return $this->belongsTo('App\Models\Subject');
    }

    public function assessment()
    {
        return $this->hasMany('App\Models\Assessment');
    }
    public function industrialAssessment()
    {
        return $this->hasMany('App\Models\IndustrialAssessment');
    }
}
