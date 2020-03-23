<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Rooms;
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
        return view('createroom')->with('rooms', $rooms);


    }

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function createroom(Request $request)
    {

        $userId = Auth::id();


        $room = Rooms::create([
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'userid' => $userId,

        ]);


        QrCode::size(1500)
            ->format('svg')
            ->generate('http://yoolah.com/r/' . $room->id, public_path('qr/' . $room->id . 'qrcode.svg'));
        QrCode::size(1500)
            ->format('png')
            ->generate('http://yoolah.com/r/' . $room->id, public_path('qr/' . $room->id . 'qrcode.png'));

        $roomm = Rooms::find($room->id);
        $roomm->qr_code = $room->id . 'qrcode.svg';
        $roomm->update();

//        return redirect()->back()->with('message', 'Room Created');
//        return view('viewroom')->with('room', $room->id);
        return redirect('viewroom/' . $room->id);


    }

    public function viewroom(Request $request, $id)
    {
        $room = Rooms::find($id);
        $members = DB::select("Select * from users where id IN(Select user_id from room_users where room_id=" . $room->id . ")");

        return view('viewroom')->with('room', $room)->with('members', $members);


    }

    public function sendmail(Request $request)
    {
        $this->mailTo($request['email'], 8);
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
