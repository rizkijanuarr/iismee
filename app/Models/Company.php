<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function students()
    {
        return $this->hasMany('App\Models\Student');
    }

    public function industrialAdvisers()
    {
        return $this->hasMany('App\Models\IndustrialAdviser');
    }
}
