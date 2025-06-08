<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustrialAdviser extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    public function industrialAssessment()
    {
        return $this->hasMany('App\Models\IndustrialAssessment');
    }
}
