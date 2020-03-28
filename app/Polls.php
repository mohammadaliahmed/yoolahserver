<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Polls extends Model
{
    //
    protected $fillable = [
        'title', 'question', 'userid', 'option1', 'option2', 'option3', 'option4','roomId'
    ];
}
