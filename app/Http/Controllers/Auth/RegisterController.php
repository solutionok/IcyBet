<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\IcybetMail;

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
    protected $redirectTo = '/home';

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        /** sending welcome email */
        $comment = "
        <h4>Welcome " . $data['name'] . ",</h4>
        <p>Glad decideed to join us, your account has been setup and you have everything you need to create bets and complete with your friends.</p>
        <p>
        <p style='margin-top:50px;margin-bottom:50px;'><a href='{{url()}}' class='btn btn-primary'>Create a Bet</a></p>
        ";

        $toEmail = $data['email'];

        Mail::to($toEmail)->send(new IcybetMail($comment));

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'email_notification' => 1,
            'password' => Hash::make($data['password']),
        ]);
    }
}
