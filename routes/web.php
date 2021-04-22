<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/adminlogin', 'AdminController@admin')->name('admin');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'RoomsController@create')->name('create');
Route::get('/viewroom/{id}', 'RoomsController@viewroom')->name('viewroom');
Route::get('/viewUserProfile/{id}', 'UserController@viewUserProfile')->name('viewUserProfile');
Route::get('/removeUserFromGroup/{roomId}/{userId}', 'RoomsController@removeUserFromGroup')->name('removeUserFromGroup');
Route::get('/viewroom/roomusers/{roomId}/{userId}/{status}', 'RoomsController@managePrivileges')->name('managePrivileges');
Route::get('/viewqr/{id}', 'AppRoomController@viewqr')->name('viewqr');
Route::get('/verify/{id}', 'UserController@verify')->name('verify');
Route::post('/createroom', 'RoomsController@createroom')->name('createroom');
Route::get('/loginadmin', 'AdminController@loginadmin')->name('loginadmin');
Route::get('/adminhome', 'AdminController@adminhome')->name('adminhome');
Route::post('/sendmail/{id}', 'RoomsController@sendmail')->name('sendmail');


