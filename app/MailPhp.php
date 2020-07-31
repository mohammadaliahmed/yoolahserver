<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


//require 'vendor/autoload.php';


class MailPhp extends  Model
{
    public function sendmail($email,$message)
    {
        $url = 'http://58.27.201.82/mail/index.php';
        $data = array('email' => $email, 'message' => $message);

// use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

    }
}