<?php

namespace App\Http\Controllers;

use App\Constants;
use App\QrCodes;
use App\Rooms;
use App\RoomUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RoomsController extends Controller
{
    //
    public function create()
    {
        $userId = Auth::id();

        $rooms = DB::table('rooms')->where('userid', $userId)->get();
        foreach ($rooms as $room) {
            $members = DB::select("Select * from users where id IN(Select user_id from room_users where room_id=" . $room->id . ")");
            $room->memeberSize = sizeof($members);
        }
        return view('createroom')->with('rooms', $rooms);


    }

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function createroom(Request $request)
    {

        $userId = Auth::id();

        $roomCode = rand(1234567, 9876544);

        $room = Rooms::create([
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'members' => $request['members'],
            'userid' => $userId,
            'roomcode' => $roomCode,

        ]);

        QrCode::format('png')->size(300)
            ->generate('http://yoolah.com/room/' . $room->id, public_path('qr/' . $room->id . 'qrcode.png'));

        $roomm = Rooms::find($room->id);
        $roomm->qr_code = $room->id . 'qrcode.png';
        $roomm->update();
//
        $roomUser = new RoomUsers();
        $roomUser->room_id = $room->id;
        $roomUser->user_id = $userId;
        $roomUser->can_message = true;
        $roomUser->save();

//        return redirect()->back()->with('message', 'Room Created');
//        return view('viewroom')->with('room', $room->id);
        return redirect('viewroom/' . $room->id);


    }

    public function viewroom(Request $request, $id)
    {
        $room = Rooms::find($id);
        $members = DB::select("SELECT *
                                          FROM users, room_users
                                          WHERE users.id=room_users.user_id and room_users.room_id=" . $room->id . "
                                          GROUP BY users.email");


        return view('viewroom')->with('room', $room)->with('members', $members);


    }

    public function removeUserFromGroup(Request $request, $roomId, $userId)
    {
        DB::table('room_users')->where('room_id', $roomId)->where('user_id', $userId)->delete();


        $room = Rooms::find($roomId);

        $members = DB::select("SELECT *
                                          FROM users, room_users
                                          WHERE users.id=room_users.user_id and room_users.room_id=" . $room->id . "
                                          GROUP BY users.email");

        return redirect()->back();


    }

    public function managePrivileges(Request $request, $roomId, $userId, $status)
    {
//        $roomUser = DB::table('room_users')->where('room_id', $roomId)->where('user_id', $userId)->first();
        $val = 0;
        if ($status == 'active') {
            $val = 1;
        }

        DB::table('room_users')
            ->where('room_id', $roomId)
            ->where('user_id', $userId)
            ->update(['can_message' => $val]);


        return redirect()->back();


    }

    public function sendmail(Request $request, $id)
    {
        $email = $request['email'];


        $milliseconds = round(microtime(true) * 1000);

        $randomcode = Constants::generateRandomString(20);
        $qrCode = new QrCodes();
        $qrCode->qr_url = $milliseconds . 'qrcode.png';
        $qrCode->room_id = $id;
        $qrCode->used = false;
        $qrCode->randomcode = $randomcode;
        $qrCode->save();

        QrCode::format('png')->size(300)
            ->generate('http://yoolah.com/qr/' . $randomcode, public_path('qr/' . $milliseconds . 'qrcode.png'));

        $room = Rooms::find($id);


        $msg = 'Use the follwing code to enter the group\n\n Group code: ' . $room->roomcode;

        $msg = $msg . "\n\n\nOr Click on the following link: http://yoolah.acnure.com/viewqr/" . $randomcode;


        return $msg;
//        mail($request['email'], "Invitation to Yoolah group", $msg);


        return redirect()->back()->with('message', 'Mail Sent');


    }

    public function mailTo()
    {


        $data = [
            'data' => "http://yoolah.com/r/",

        ];
        $email = "m.aliahmed0@gmail.com";
        Mail::send('mail', ["data1" => $data], function ($message) use ($email) {
            $message->to($email)->subject("Invitation to Yoolah group");
            $message->from('chat@gmail.com', 'Chat App');
        });

    }

}
