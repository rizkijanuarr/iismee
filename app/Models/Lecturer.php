<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'name';
    }

    public function subject()
    {
        return $this->hasOne('App\Models\Subject');
    }

    public function supervisor()
    {
        return $this->hasOne('App\Models\Supervisor');
    }

    public function internship()
    {
        return $this->hasMany('App\Models\Internship');
    }

    public function assessment()
    {
        return $this->hasMany('App\Models\Assessment');
    }
}
