<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QrCodes extends Model
{
    //
    protected $fillable = [
        'qr_url', 'room_id', 'used'
    ];
}
