<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\IcybetMail;

class AccountController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        return view('account');
    }
    public function save(Request $request)
    {
        $data = $request->input();

        $bet = User::find(auth()->user()->id);
        $bet->name = $data['name'];
        $bet->email = $data['email'];
        $bet->phone = $data['phone'];
        $bet->email_notification = $data['email_notification'];
        if($data['password']!=$bet->password){
            $bet->password = Hash::make($data['password']);
        }
        $bet->save();

        return redirect('account');

    }

    public function cancel()
    {

        $user = User::find(auth()->user()->id);
        // $user->status = -1;//close
        // $user->closed_at = date('Y-m-d H:i:s');
        // $user->save();
        $user->delete();
        return 'ok';
    }
}
