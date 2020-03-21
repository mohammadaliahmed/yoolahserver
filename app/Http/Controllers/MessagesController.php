<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Messages;
use App\Rooms;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    //

    public function createMessage(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

            $message = new Messages();
            $message->messageText = $request->messageText;
            $message->messageType = $request->messageType;
            $message->messageByName = $request->messageByName;
            $message->imageUrl = $request->imageUrl;
            $message->audioUrl = $request->audioUrl;
            $message->mediaTime = $request->mediaTime;
            $message->filename = $request->filename;
            $message->messageByPicUrl = $request->messageByPicUrl;
            $message->videoUrl = $request->videoUrl;
            $message->documentUrl = $request->documentUrl;
            $message->messageById = $request->messageById;
            $message->roomId = $request->roomId;
            $message->time = $request->time;
            $message->save();

//            $chatRoom = Rooms::find($request->roomId);
//            $users = $chatRoom->users;
//            $abc = str_replace($request->messageById, '', $users);
//            $abc = str_replace(',', '', $abc);
//            $user = User::find($abc);
//
//            $this->sendPushNotification($user->fcmKey,
//                "New Message from " . $request->messageByName,
//                $message->messageText, $request->roomId);
            $messages = DB::table('messages')->where('roomId', $request->roomId)->
            orderBy('id', 'desc')->take(100)->get();

            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'messages' => $messages

                ,
            ], Response::HTTP_OK);
        }
    }


    public function userMessages(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
            $results = DB::select("select * from messages s where `roomId` in
                                            (select room_id from room_users where user_id=" . $request->id . ")
                                            and  `id`=(select max(id) from messages p where p.roomId=s.roomId )
                                            ORDER by s.time desc ");

            foreach ($results as $item) {
                $chatRoom = Rooms::find($item->roomId);

                $item->title = $chatRoom->title;
                $item->coverUrl = $chatRoom->cover_url;
            }


            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'messages' => $results

                ,
            ], Response::HTTP_OK);
        }
    }

    public function allRoomMessages(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

            $messages = DB::table('messages')->where('roomId', $request->roomId)->
            orderBy('id', 'desc')->take(100)->get();

            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false",
                'messages' => $messages

                ,
            ], Response::HTTP_OK);
        }
    }
}
