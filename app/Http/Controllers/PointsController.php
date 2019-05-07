<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Bet;
use App\Models\BetOptions;
use App\Models\BetPlayers;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\IcybetMail;

class PointsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $mybetIds = BetPlayers::where('invited_email', auth()->user()->email)
                        ->groupBy('bet_id')
                        ->pluck('bet_id')
                        ->toArray();
        $friendsEmails = BetPlayers::whereIn('bet_id', $mybetIds)
                        ->groupBy('invited_email')
                        ->pluck('invited_email')
                        ->toArray();

        $players = DB::table('bet_players as b')
                        ->leftJoin('users as a', 'b.invited_email', '=', 'a.email')
                        ->whereIn('b.invited_email', $friendsEmails)
                        ->groupBy('b.invited_email')
                        ->orderBy('a.point', 'desc')
                        ->get(['b.invited_email', 'b.invited_name', 'a.point', DB::raw('(select count(e.id) from bet_players as e where e.invited_email=b.invited_email and e.betting_option_id>0) as play_count')]);

        return view('points', ['players'=>$players]);
    }

    public function getHistory($email){
        $history = DB::table('bet as a')
                    ->join('bet_players as b', 'a.id', '=', 'b.bet_id')
                    ->join('bet_options as c', 'b.betting_option_id', '=', 'c.id')
                    ->where('b.invited_email', $email)
                    ->orderBy('b.betting_at', 'desc')
                    ->get(['a.title', 'c.title as option_title', 'b.earn_point'])
                    ->toArray();
        $re='';
        foreach($history as $h){
            $re .= '<tr>';
            $re .= '<td>'.$h->title.'</td>';
            $re .= '<td>'.$h->option_title.'</td>';
            $re .= '<td>'.$h->earn_point.'</td>';
            $re .= '</tr>';
        }
        return $re;
    }
}
