<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $fillable = [
        'id', 'messageText', 'messageType', 'messageByName', 'imageUrl', 'audioUrl', 'documentUrl','messageByPicUrl', 'videoUrl',
        'messageById', 'roomId', 'time','mediaTime','filename'
    ];
    //
}
