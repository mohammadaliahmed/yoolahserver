<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Rooms;
use App\User;
use function contains;
use function hasKey;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends Controller
{
    //

    public function viewUserProfile(Request $request, $id)
    {
        $user = User::find($id);

        return view('viewuser')->with('user', $user);

    }

    public function verify(Request $request, $id)
    {
//        $user=User::find(10);
        $user = DB::table('users')->where('randomcode', $id)->first();
        if ($user != null) {

            $user = User::find($user->id);
            $user->email_verified = true;
            $user->update();

            return redirect('home');


        } else {
            return 'Wrong url';
        }
    }

    public function login(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

//            $abc=Hash::make($request->password);
//            return $abc;

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = DB::table('users')->where('email', $request->email)->first();
                return response()->json([
                    'code' => 200, 'message' => "false", 'user' => $user
                    ,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'code' => 302, 'message' => 'Wrong credentials',
                ], Response::HTTP_OK);
            }
        }

    }

    public function loginWithId(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

            $user = DB::table('users')
                ->where('randomcode', $request->randomcode)
                ->first();

            if ($user != null) {
                return response()->json([
                    'code' => 200, 'message' => 'false', 'user' => $user
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'code' => 302, 'message' => 'Wrong Id',
                ], Response::HTTP_OK);
            }
        }

    }

    public function loginAdmin(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME || $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

            $room = Rooms::find($request->id);
            $user = User::find($room->userid);

            if ($user != null) {
                return response()->json([
                    'code' => 200, 'message' => 'false', 'user' => $user
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'code' => 302, 'message' => 'Wrong Id',
                ], Response::HTTP_OK);
            }
        }

    }

    public function register(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_FORBIDDEN);
        } else {
            $user = DB::table('users')
                ->where('email', $request->email)
                ->first();
            if ($user != null) {
                return response()->json([
                    'code' => 302, 'message' => 'Account already exist',
                ], Response::HTTP_OK);
            } else {

                if ($request->name == null) {
                    return response()->json([
                        'code' => 302, 'message' => 'Empty params',
                    ], Response::HTTP_OK);
                } else {
                    $milliseconds = round(microtime(true) * 1000);
                    $my_rand_strng = Constants::generateRandomString(7);

                    QrCode::format('png')->size(300)
                        ->generate('http://yoolah.com/user/' . $my_rand_strng, public_path('qr/' . $my_rand_strng . 'qrcode.png'));

                    $abc = Hash::make($request->password);
                    $user = new User();
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->username = $request->username;
                    $user->dob = $request->dob;
                    $user->gender = $request->gender;
                    $user->password = $abc;
                    $user->email_verified = false;
                    $user->phone = $request->phone;
                    $user->randomcode = $my_rand_strng;
                    $user->save();
//            $this->sendMail($request->email);
                    return response()->json([
                        'code' => Response::HTTP_OK, 'message' => "false", 'user' => $user
                        ,
                    ], Response::HTTP_OK);
                }

            }

        }
    }

    public
    function updateFcmKey(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
            $user = User::find($request->id);
            $user->fcmKey = $request->fcmKey;
            $user->update();
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'user' => $user
            ], Response::HTTP_OK);
        }
    }

    public
    function updateProfile(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {


            $user = User::find($request->id);
            $user->thumbnailUrl = $request->thumbnailUrl;
            $user->name = $request->name;
//            $user->phone = $request->phone;
//            $user->gender = $request->gender;
//            if ($request->has("email")) {
//                $user->email = $request->email;
//
//            }
            $user->update();
            DB::table('messages')
                ->where('messageById', $request->id)
                ->update(['messageByPicUrl' => $request->thumbnailUrl]);
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'user' => $user
            ], Response::HTTP_OK);


        }
    }

    public
    function userProfile(Request $request)
    {

        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {


            $user = User::find($request->id);
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'user' => $user
            ], Response::HTTP_OK);

        }
    }

    public function sendMail()
    {


        $data = [
            'data' => "http://chatapp.com/sdfdsfsdfsdfsdfsdfsdfsfsdfsdfsdfsdfsdfsdfs",

        ];
        $email = "m.aliahmed000@gmail.com";
        Mail::send('mail', ["data1" => $data], function ($message) use ($email) {
            $message->to($email)->subject("New yoolah User  Registration");
            $message->from('chat@gmail.com', 'Chat App');
        });

    }

}
