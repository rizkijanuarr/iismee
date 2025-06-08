<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function lecturer()
    {
        return $this->belongsTo('App\Models\Lecturer');
    }
}
