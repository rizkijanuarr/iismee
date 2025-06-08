<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'name';
    }

    protected $guarded = ['id'];

    public function internship()
    {
        return $this->hasOne('App\Models\Internship');
    }

    public function assessment()
    {
        return $this->hasMany('App\Models\Assessment');
    }

    public function industrialAssessment()
    {
        return $this->hasMany('App\Models\IndustrialAssessment');
    }

    public function logbook()
    {
        return $this->hasMany('App\Models\Logbook');
    }

    public function document()
    {
        return $this->hasMany('App\Models\Document');
    }

    public function report()
    {
        return $this->hasMany('App\Models\Report');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function attendance()
    {
        return $this->hasMany('App\Models\Attendance');
    }
}
