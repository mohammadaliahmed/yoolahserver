<?php

namespace App\Http\Controllers;

use App\Constants;
use App\PollAnswers;
use App\Polls;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PollsController extends Controller
{
    //
    public function createPoll(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {
            $poll = new Polls();
            $poll->title = $request->title;
            $poll->question = $request->question;
            $poll->option1 = $request->option1;
            $poll->option2 = $request->option2;
            $poll->option3 = $request->option3;
            $poll->option4 = $request->option4;
            $poll->userid = $request->userid;
            $poll->roomId = $request->roomId;
            $poll->save();
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false",
            ], Response::HTTP_OK);
        }
    }

    public function getPoll(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

            $poll = Polls::find($request->id);
            $pollAnswer = DB::table('poll_answers')->where('pollId',$poll->id)->where('userId',$request->userId)->first();
            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'poll' => $poll,'pollAnswer'=>$pollAnswer
            ], Response::HTTP_OK);

        }
    }

    public function submitAnswer(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

            $pollAnswer = DB::table('poll_answers')->where('userId', $request->userId)->where('pollId', $request->pollId)->get();

            //
            if (sizeof($pollAnswer) > 0) {

                return response()->json([
                    'code' => Response::HTTP_OK, 'message' => "false"
                ], Response::HTTP_OK);
            } else {

//
//
                $pollAnswer = new PollAnswers();
                $pollAnswer->pollId = $request->pollId;
                $pollAnswer->option = $request->option;
                $pollAnswer->userId = $request->userId;
                $pollAnswer->save();
                return response()->json([
                    'code' => Response::HTTP_OK, 'message' => "false"
                ], Response::HTTP_OK);

            }
// else {
//                return response()->json([
//                    'code' => Response::HTTP_OK, 'message' => "false"
//                ], Response::HTTP_OK);
//            }
        }
    }

    public function getAllPolls(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

            $polls = DB::table('polls')
                ->where('roomId', $request->roomId)
                ->get();
            foreach ($polls as $poll) {

                $polll = DB::table('poll_answers')->where('pollId', $poll->id)->get();

                $poll->answers = $polll;

            }

            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'polls' => $polls
            ], Response::HTTP_OK);

        }
    }

    public function getAllPollsToFill(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {

            $polls = DB::table('polls')
                ->where('roomId', $request->roomId)
                ->get();


            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false", 'polls' => $polls
            ], Response::HTTP_OK);

        }
    }

    public function deletePoll(Request $request)
    {
        if ($request->api_username != Constants::$API_USERNAME && $request->api_password != Constants::$API_PASSOWRD) {
            return response()->json([
                'code' => Response::HTTP_FORBIDDEN, 'message' => "Wrong api credentials"
            ], Response::HTTP_OK);
        } else {


            $poll = Polls::find($request->pollId);
            $poll->delete();


            return response()->json([
                'code' => Response::HTTP_OK, 'message' => "false"
            ], Response::HTTP_OK);

        }
    }
}
