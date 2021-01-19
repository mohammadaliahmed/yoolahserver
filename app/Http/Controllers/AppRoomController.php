<?php

namespace App\Http\Controllers;

use App\Constants;
use App\MailPhp;
use App\QrCodes;
use App\Rooms;
use App\RoomUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use function sizeof;

class AppRoomController extends Controller
{
    //
    public function getRoomDetails(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
            $room = Rooms::find($request->roomId);
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'room' => $room
            ], Response::HTTP_OK);
        }
    }

    public function getRoomDetailsFromID(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

            $room = DB::table('rooms')->where('roomcode', $request->code)->first();
            if ($room != null) {
                $room = Rooms::find($room->id);
                $user = User::find($room->userid);
                return response()->json([
                    'code' => Response::HTTP_OK, 'message' => "false", 'room' => $room, 'user' => $user
                ], Response::HTTP_OK);
            } else {
                $qr_code = DB::table("qr_codes")->where("randomcode", $request->code)->first();


                if (!$qr_code) {
                    return response()->json([
                        'code' => Response::HTTP_NOT_FOUND, 'message' => "Wrong code"
                    ], Response::HTTP_NOT_FOUND);
                } else {
                    $room = Rooms::find($qr_code->room_id);
                    if ($qr_code == null) {
                        return response()->json([
                            'code' => Response::HTTP_NOT_FOUND, 'message' => "Wrong code"
                        ], Response::HTTP_NOT_FOUND);
                    } else {


                        return response()->json([
                            'code' => Response::HTTP_OK, 'message' => "false", 'room' => $room
                        ], Response::HTTP_OK);
                    }
                }
            }
        }
    }

    public function getFirstTimeGroups(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

            $room = DB::table('rooms')->where('roomcode', $request->code)->first();
            if ($room != null) {
                $rooms = array();
                $roomUser = DB::table('room_users')->where('user_id', $room->userid)->get();
                foreach ($roomUser as $roomId) {
                    array_push($rooms, Rooms::find($roomId->room_id));
                }
                $user = User::find($room->userid);
                return response()->json([
                    'code' => Response::HTTP_OK, 'message' => "false", 'rooms' => $rooms, 'user' => $user
                ], Response::HTTP_OK);
            } else {

                $qr_code = DB::table("qr_codes")->where("randomcode", $request->code)->first();


                if (!$qr_code) {
                    return response()->json([
                        'code' => Response::HTTP_NOT_FOUND, 'message' => "Wrong code"
                    ], Response::HTTP_NOT_FOUND);
                } else {
                    $room = Rooms::find($qr_code->room_id);
                    if ($qr_code == null) {
                        return response()->json([
                            'code' => Response::HTTP_NOT_FOUND, 'message' => "Wrong code"
                        ], Response::HTTP_NOT_FOUND);
                    } else {
                        $qrcode=QrCodes::find($qr_code->id);
                        if($qrcode->used==1){
                            return response()->json([
                                'code' => Response::HTTP_FORBIDDEN, 'message' => "Code already used"
                            ], Response::HTTP_OK);
                        }else{
                            $qrcode->used = true;
                            $qrcode->update();
                        }


                        return response()->json([
                            'code' => Response::HTTP_OK, 'message' => "false", 'room' => $room
                        ], Response::HTTP_OK);
                    }
                }
            }
        }
    }

    public function addAdminToOldGroups(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
//

            $room = DB::table('rooms')->where('roomcode', $request->code)->first();
            if ($room != null) {
                if ($room->userid != $request->userId) {


                    $room = Rooms::find($room->id);
                    $newuser = User::find($room->userid);
                    $user = $newuser;
                    $newuser->delete();

                    $oldUser = User::find($request->userId);
                    $oldUser->update(['password' => $user->password,
                        'email' => $user->email, 'name' => $user->name, 'email_verified' => 1]);


                    $room->update(['userid' => $request->userId]);
                    $roomUser = DB::table('room_users')->where('room_id', $room->id)
                        ->where('can_message', 1)->limit(1);
                    if ($roomUser != null) {
                        $roomUser->update(['user_id' => $request->userId]);
                    }


                }
                return response()->json([
                    'code' => Response::HTTP_OK, 'message' => "false", 'room' => $room
                ], Response::HTTP_OK);

            } else {
                $qr_code = DB::table("qr_codes")->where("randomcode", $request->code)->first();


                if (!$qr_code) {
                    return response()->json([
                        'code' => Response::HTTP_NOT_FOUND, 'message' => "false"
                    ], Response::HTTP_NOT_FOUND);
                } else {
                    $room = Rooms::find($qr_code->room_id);
                    if ($qr_code == null) {
                        return response()->json([
                            'code' => Response::HTTP_NOT_FOUND, 'message' => "false"
                        ], Response::HTTP_NOT_FOUND);
                    } else {


                        return response()->json([
                            'code' => Response::HTTP_OK, 'message' => "false", 'room' => $room
                        ], Response::HTTP_OK);
                    }
                }
            }
        }
    }

    function addUserToRoom(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

//            $qrCode = QrCodes::find($request->qr_id);
            $qrCode = DB::table('qr_codes')->where('randomcode', $request->qr_id)->first();
            if ($qrCode->used == 1) {
                return response()->json([
                    'code' => Response::HTTP_FORBIDDEN, 'message' => "Code already Used"
                ], Response::HTTP_FORBIDDEN);
            } else {
                $qrCod = QrCodes::find($qrCode->id);
                $qrCod->used = true;
                $qrCod->update();

                $roomUser = DB::table('room_users')->where('room_id', $qrCode->room_id)
                    ->where('user_id', $request->user_id)->first();
                if ($roomUser != null) {

                } else {
                    $roomUser = new RoomUsers();
                    $roomUser->room_id = $qrCode->room_id;
                    $roomUser->user_id = $request->user_id;
                    $roomUser->can_message = 0;
                    $roomUser->save();
                }
                $room = Rooms::find($qrCode->room_id);
                return response()->json([
                    'code' => Response::HTTP_OK, 'message' => "false", 'roomId' => $qrCode->room_id, 'room' => $room
                ], Response::HTTP_OK);
            }

        }

    }

    function checkQrStatus(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

//            $qrCode = QrCodes::find($request->qr_id);
            $qrCode = DB::table('qr_codes')->where('randomcode', $request->qr_id)->first();
            if ($qrCode->used == 1) {
                return response()->json([
                    'code' => Response::HTTP_FORBIDDEN, 'message' => "Code already Used"
                ], Response::HTTP_FORBIDDEN);
            } else {
                return response()->json([
                    'code' => Response::HTTP_OK, 'message' => "Available"
                ], Response::HTTP_OK);
            }

        }

    }

    public
    function addUserToRoomWithRoomId(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

            $room = Rooms::find($request->room_id);

            $roomUser = DB::table('room_users')->where('room_id', $request->room_id)
                ->where('user_id', $request->user_id)->first();
            if ($roomUser != null) {

            } else {
                $roomUser = new RoomUsers();
                $roomUser->room_id = $request->room_id;
                $roomUser->user_id = $request->user_id;
                $roomUser->can_message = 0;
                $roomUser->save();
            }
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'roomId' => $request->room_id, 'room' => $room
            ], Response::HTTP_OK);

        }

    }


    public
    function removeParticipant(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
            DB::table('room_users')->where('room_id', $request->roomId)->where('user_id', $request->userId)->delete();
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false"
            ], Response::HTTP_OK);
        }
    }

    public
    function getRoomInfo(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
            $room = Rooms::find($request->roomId);
            $users = DB::select('select * from users where id in(select user_id from room_users where room_id=' . $request->roomId . ')');


            $roomUser = DB::table('room_users')
                ->where('room_id', $request->roomId)
                ->where('user_id', $request->userId)->first();

            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'room' => $room, 'users' => $users, 'canMessage' => $roomUser->can_message
            ], Response::HTTP_OK);
        }
    }

    public
    function updateCoverUrl(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
            $room = Rooms::find($request->roomId);
            $room->cover_url = $request->coverUrl;
            $room->update();
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'room' => $room
            ], Response::HTTP_OK);
        }
    }

    public
    function viewqr(Request $request, $id)
    {

//
//        $qrcode = QrCodes::find($id);
        $qrcode = DB::table('qr_codes')->where('randomcode', $id)->first();

        $room = Rooms::find($qrcode->room_id);
        $room->qrUrl = $qrcode->qr_url;

        return view('viewqr')->with('room', $room);


    }


    public function inviteUserFromApp(Request $request)
    {
        $milliseconds = round(microtime(true) * 1000);
        $randomcode = Constants::generateRandomString(7);
        $qrCode = new QrCodes();
        $qrCode->qr_url = $milliseconds . 'qrcode.png';
        $qrCode->room_id = $request->roomId;
        $qrCode->used = false;
        $qrCode->randomcode = $randomcode;
        $qrCode->save();

        $qrLink = 'qr/' . $milliseconds . 'qrcode.png';
        QrCode::format('png')->size(300)
            ->generate('http://yoolah.com/qr/' . $randomcode, public_path('qr/' . $milliseconds . 'qrcode.png'));

        $subject = "Invited to join a group";

        Mail::send('testmail', ['groupcode' => $randomcode, 'subject' => $subject, 'qrlink' => $qrLink], function ($message) use ($request, $subject) {
            $message->from('noreply@yoolah.com', 'Yoolah');
            $message->subject($subject);
            $message->to($request->email);
        });


    }


    public function mailTo()
    {


        $url = 'http://58.27.201.82/mail/index.php';
        $data = array('email' => 'm.aliahmed0@gmail.com', 'message' => 'sdfsdfsdfsdlkfjwlkejrljk');

// use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { /* Handle error */
        }

        var_dump($result);

        return response()->json([
            'code' => Response::HTTP_OK, 'message' => $result
        ], Response::HTTP_OK);

//        $to_name = 'ali';
//        $to_email = 'm.aliahmed0@gmail.com';
//        $data = array('name' => "Ogbonna Vitalis(sender_name)", "body" => "A test mail");
//        Mail::send('emails . mail', $data, function ($message) use ($to_name, $to_email) {
//            $message->to($to_email, $to_name)->subject('Laravel Test Mail');
//            $message->from('SENDER_EMAIL_ADDRESS', 'Test Mail');
//        });

    }
}
