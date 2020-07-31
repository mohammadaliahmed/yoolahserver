<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'user'], function () {

    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@login');
    Route::post('updateProfilePicture', 'UserController@updateProfilePicture');
    Route::post('updateFcmKey', 'UserController@updateFcmKey');
    Route::post('searchUsers', 'UserController@searchUsers');
    Route::post('loginWithId', 'UserController@loginWithId');
    Route::post('userProfile', 'UserController@userProfile');
    Route::post('updateProfile', 'UserController@updateProfile');
    Route::post('sendMail', 'MailController@sendMail');
    Route::post('loginAdmin', 'UserController@loginAdmin');
});


Route::group(['prefix' => 'room'], function () {

    Route::post('getRoomDetails', 'AppRoomController@getRoomDetails');
    Route::post('updateCoverUrl', 'AppRoomController@updateCoverUrl');
    Route::post('getRoomInfo', 'AppRoomController@getRoomInfo');
    Route::post('addUserToRoomWithRoomId', 'AppRoomController@addUserToRoomWithRoomId');
    Route::post('removeParticipant', 'AppRoomController@removeParticipant');
    Route::post('addUserToRoom', 'AppRoomController@addUserToRoom');
    Route::post('getRoomDetailsFromID', 'AppRoomController@getRoomDetailsFromID');
    Route::get('mailTo', 'AppRoomController@mailTo');
});
Route::group(['prefix' => 'message'], function () {

    Route::post('createMessage', 'MessagesController@createMessage');
    Route::post('deleteMessageFroAll', 'MessagesController@deleteMessageFroAll');
    Route::post('allRoomMessages', 'MessagesController@allRoomMessages');
    Route::post('userMessages', 'MessagesController@userMessages');
});
Route::group(['prefix' => 'poll'], function () {

    Route::post('createPoll', 'PollsController@createPoll');
    Route::post('submitAnswer', 'PollsController@submitAnswer');
    Route::post('getPoll', 'PollsController@getPoll');
    Route::post('getAllPolls', 'PollsController@getAllPolls');
    Route::post('getAllPollsToFill', 'PollsController@getAllPollsToFill');
    Route::post('deletePoll', 'PollsController@deletePoll');

});


Route::post('uploadFile', 'FileUploadController@uploadFile');
