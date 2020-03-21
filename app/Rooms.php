<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    //
    protected $fillable = [
        'title', 'subtitle', 'userid','cover_url'
    ];
}
