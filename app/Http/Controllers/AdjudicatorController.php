<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bet;
use App\Models\BetOptions;
use App\Models\BetPlayers;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\IcybetMail;

class AdjudicatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $adjudicatedBets = Bet::where('adjudicator_id', auth()->user()->id)
                                ->orderBy('created_at', 'desc')
                                ->get();
        return view('adjudicator', ['adjudicatedBets'=>$adjudicatedBets]);
    }

    public function getBet(Request $request, $id)
    {
        $bet = Bet::find($id);
        $bet->options;
        $bet->players;

        return $bet->toArray();
    }

    public function saveBet(Request $request)
    {
        $data = $request->input();

        $created = false;
        if(!$data['id']){
            $created = true;
            $bet = new Bet;
            $bet->adjudicator_id = auth()->user()->id;
            $bet->status = 1;
        }else{

            $bet = Bet::find($request->input('id'));
        }

        $bet->title = $data['title'];
        $bet->description = $data['description'];
        $bet->expire = $data['expire'];
        $bet->save();

        $betId = !empty($data['id']) ? $data['id'] : $bet->id;

        BetOptions::where('bet_id', $betId)->delete();
        BetPlayers::where('bet_id', $betId)->delete();

        foreach($data['options'] as $option){
            BetOptions::insert([
                'bet_id' => $betId,
                'title' => $option['txt'],
                'is_answer' => $option['is_answer'],
            ]);
        }

        foreach($data['players'] as $option){
            BetPlayers::insert([
                'bet_id' => $betId,
                'invitor_id' => auth()->user()->id,
                'invited_email' => $option['email'],
                'invited_name' => $option['name'],
                'invited_at' => date('Y-m-d H:i:s'),
            ]);
            if($created === false){
                continue;
            }

            $user = User::where('email', $option['email'])->first();

            if($user && !$user->email_notification){
                continue;
            }
            /** sending invite email */
            $comment = "
            <h6>Welcome " . $option['name'] . ",</h6>
            <p>We'd like to information you that your friend ". auth()->user()->name .
            " would like you to participate in the bet for \"" . $data['title'] . "\"</p>
            <p>
            <p style='margin-top:50px;margin-bottom:50px;'><a href='{{url()}}' class='btn btn-primary'>Place Bet</a></p>
            ";

            $toEmail = $option['email'];

            Mail::to($toEmail)->send(new IcybetMail($comment));
        }

        //adding self
        BetPlayers::insert([
            'bet_id' => $betId,
            'invitor_id' => 0,
            'invited_email' => auth()->user()->email,
            'invited_name' => auth()->user()->name,
            'invited_at' => date('Y-m-d H:i:s'),
        ]);

        return 'ok';
    }

    public function cancelBet(Request $request){
        $id = $request->input('id');
        $bet = Bet::find($id);
        $bet->status = 3;
        $bet->save();

        foreach($bet->players as $player){

            /** sending cancel email */
            $comment = "
            <h6>Hello " . $player->invited_name . ",</h6>
            <p>We'd like to information you that the bet \"" . $bet->title . "\ has been canceled by adjudicator.</p>".
            "<p style='margin-top:50px;margin-bottom:50px;'><a href='{{url()}}' class='btn btn-primary'>Confirm it</a></p>";

            $toEmail = $player['invited_email'];

            Mail::to($toEmail)->send(new IcybetMail($comment));
        }
        return 'ok';
    }

    public function award(Request $request){
        $emails = $request->input('winners');
        $betId = $request->input('betId');

        $point = round(1 / count($emails), 2);

        $bet = Bet::find($betId);

        foreach($emails as $email){
            $player = BetPlayers::where('invited_email', $email)->where('bet_id', $betId)->first();
            $player->earn_point = $point;
            $player->save();

            $user = User::where('email', $player->invited_email)->first();
            if(!$user){
                continue;
            }
            $user->point = doubleval($user->point) + $point;
            $user->save();

            $option = BetOptions::find($player->betting_option_id);
            $option->is_answer = 1;
            $option->save();

            if(!$option){
                continue;
            }

            /** sending cancel email */
            $comment = "
            <h6>Hello " . $player->invited_name . ",</h6>
            <p>Looks like you've won! You just earned another point for winning \"" . $bet->title . "\ with selecting ".$option->title.".</p>
            <p>You've now got ".$user->point." points in the leader board amongst your friends.</p>".
            "<p style='margin-top:50px;margin-bottom:50px;'>
                <a href='".url('')."' class='btn btn-primary'>Create New Bet</a>
                <a href='".url('points')."' class='btn btn-primary'>See Points Board</a>
            </p>";

            $toEmail = $player->invited_email;

            Mail::to($toEmail)->send(new IcybetMail($comment));
        }


        $bet->status = 4;
        $bet->save();

        return 'ok';
    }

    public function importGoogleContact(Request $request)
    {
        // get data from request
        $code = 'AIzaSyDqQgQDvjzLMK1iwafpx-Kn0oFgKP9y1ng';
        // $code = $request->get('code');

        // get google service
        $googleService = \OAuth::consumer('Google');

        // check if code is valid

        // if code is provided get user data and sign in
        if (!is_null($code)) {
            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken($code);

            // Send a request with it
            $result = json_decode($googleService->request('https://www.google.com/m8/feeds/contacts/default/full?alt=json&amp;max-results=400'), true);

            // Going through the array to clear it and create a new clean array with only the email addresses
            $emails = []; // initialize the new array
            foreach ($result['feed']['entry'] as $contact) {
                if (isset($contact['gd$email'])) { // Sometimes, a contact doesn't have email address
                    $emails[] = $contact['gd$email'][0]['address'];
                }
            }

            return $emails;
        }

        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return redirect((string)$url);
        }
    }
}
