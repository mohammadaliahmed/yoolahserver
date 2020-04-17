<?php

namespace App;


class Constants
{


    public static $API_USERNAME = "WF9.FJ8u'FP{c5Pw";
    public static $API_PASSOWRD = "3B~fauh5s93j[FKb";


    public static function generateRandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

}
