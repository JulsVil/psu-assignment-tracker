<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'subject',
        'title', 
        'details',
        'status',
        'due_date',
    ];
}