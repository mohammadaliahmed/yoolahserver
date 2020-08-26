<?php

namespace App\Http\Controllers;

use App\Constants;
use App\MailPhp;
use App\Messages;
use App\QrCodes;
use App\Rooms;
use App\RoomUsers;
use App\User;
use function http_get;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use function urldecode;
use function urlencode;

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

//        $roomCode = rand(1234567, 9876544);
        $roomCode = Constants::generateRandomString(7);

        $room = Rooms::create([
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'members' => $request['members'],
            'userid' => $userId,
            'roomcode' => $roomCode,

        ]);
        $user = User::find($userId);

        QrCode::format('png')->size(300)
            ->generate('http://yoolah.net/mainRoom/' . $room->id, public_path('qr/' . $room->id . 'qrcode.png'));

        $roomm = Rooms::find($room->id);
        $roomm->qr_code = $room->id . 'qrcode.png';
        $roomm->update();
//
        $roomUser = new RoomUsers();
        $roomUser->room_id = $room->id;
        $roomUser->user_id = $userId;
        $roomUser->can_message = true;
        $roomUser->save();

        $milliseconds = round(microtime(true) * 1000);
        $message = new Messages();
        $message->messageText = "Group Created";
        $message->messageType = "BUBBLE";
        $message->messageByName = $user->name;
        $message->messageById = $user->id;
        $message->roomId = $room->id;
        $message->time = $milliseconds;
        $message->save();

        $qrcode=new QrCodes();
        $qrcode->qr_url=$room->id . 'qrcode.png';
        $qrcode->room_id=$room->id ;
        $qrcode->used=0;
        $qrcode->randomCode=$roomCode;

//        return redirect()->back()->with('message', 'Room Created');
//        return view('viewroom')->with('room', $room->id);
        return redirect('viewroom/' . $room->id);


    }

    public function viewroom(Request $request, $id)
    {
        $room = Rooms::find($id);
        $admin = User::find($room->userid);
        $members = DB::select("SELECT *
                                          FROM users, room_users
                                          WHERE users.id=room_users.user_id and room_users.room_id=" . $room->id . "
                                          GROUP BY users.email");


        return view('viewroom')->with('room', $room)->with('members', $members)->with('admin', $admin);


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

        $randomcode = Constants::generateRandomString(7);
        $qrCode = new QrCodes();
        $qrCode->qr_url = $milliseconds . 'qrcode.png';
        $qrCode->room_id = $id;
        $qrCode->used = false;
        $qrCode->randomcode = $randomcode;
        $qrCode->save();

        QrCode::format('png')->size(300)
            ->generate('http://yoolah.net/qr/' . $randomcode, public_path('qr/' . $milliseconds . 'qrcode.png'));

        $room = Rooms::find($id);


        $msg = "Use the following code to enter the group \n\n Group code: " . $randomcode;

        $msg = $msg . "\n\n\nOr Click on the following link: http://yoolah.net/viewqr/" . $randomcode;

        $mail = new MailPhp();
        $mail->sendmail($request['email'], $msg);
        return redirect()->back()->with('message', 'Mail Sent');


    }

    public function mailTo()
    {


    }

}
