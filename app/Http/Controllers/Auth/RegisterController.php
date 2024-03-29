<?php

namespace App\Http\Controllers\Auth;

use App\Constants;
use App\Http\Controllers\Controller;
use App\MailPhp;
use App\Providers\RouteServiceProvider;
use App\Rules\Captcha;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => new Captcha()
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $roomCode = Constants::generateRandomString(7);

        $ema = $data['email'];
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified' => false,
            'randomcode' => $roomCode

//            'password' => md5($data['password']),
        ]);;
        $data = "Please click on the following link to verify your email\nhttp://yoolah.com/verify/" . $roomCode;


        $subject = "Email Verification";

        Mail::send('verifyemail', ['roomCode'=> $roomCode,'subject'=>$subject], function ($message) use ( $subject,$ema) {
            $message->from('noreply@yoolah.com', 'Yoolah');
            $message->subject($subject);
            $message->to($ema);
        });


        return $user;


    }
}
