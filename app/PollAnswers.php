<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollAnswers extends Model
{
    protected $fillable = [
        'pollId', 'userId', 'option'
    ];
    //
}
