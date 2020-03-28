<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Rooms;
use App\RoomUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
            if ($room==null) {
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

    public
    function addUserToRoom(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
            $roomUser = DB::table('room_users')->where('room_id', $request->room_id)
                ->where('user_id', $request->user_id)->first();
            if ($roomUser != null) {

            } else {
                $roomUser = new RoomUsers();
                $roomUser->room_id = $request->room_id;
                $roomUser->user_id = $request->user_id;
                $roomUser->can_message = 1;
                $roomUser->save();
            }
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
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'room' => $room, 'users' => $users
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
        $room = Rooms::find($id);

        return view('viewqr')->with('room', $room);


    }
}
