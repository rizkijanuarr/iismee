<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'subject_name';
    }

    public function lecturer()
    {
        return $this->belongsTo('App\Models\Lecturer');
    }

    public function assesmentAspect()
    {
        return $this->hasMany('App\Models\AssesmentAspect');
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
