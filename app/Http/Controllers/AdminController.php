<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function sizeof;

class AdminController extends Controller
{
    //

    public function admin()
    {
        return view('adminlogin');
    }


    public
    function loginadmin(Request $request)
    {
        if ($request->email == 'admin@admin.com' && $request->password == 'adminadmin') {
            return view('adminhome');
        } else {
            return view('adminlogin');

        }
    }

    public
    function adminhome()
    {
        $rooms = DB::table('rooms')->get();
        foreach ($rooms as $room) {
            $members = DB::select("Select * from users where id IN(Select user_id from room_users where room_id=" . $room->id . ")");
            $rooms->memeberSize = sizeof($members);
        }
        return view('adminhome')->with('rooms', $rooms);


    }
}
