<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Bet;
use App\Models\BetOptions;
use App\Models\BetPlayers;
use Illuminate\Support\Facades\Mail;
use App\Mail\IcybetMail;

class BetsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $flag = $request->input('c', 'opened');
        $sql = DB::table('bet as a')
                    ->join('bet_players as b', 'a.id', '=', 'b.bet_id')
                    ->join('bet_options as c', 'a.id', '=', 'c.bet_id')
                    ->leftJoin('bet_options as d', 'b.betting_option_id', '=', 'd.id')
                    ->where('b.invited_email', auth()->user()->email)
                    ->groupBy('a.id')
                    ->orderBy('b.invited_at', 'desc');

        if($flag == 'opened'){
            $sql->where('a.status', '<=', 2);
        }elseif($flag == 'closed'){
            $sql->where('a.status', '>=', 3);
        }
        $mybets = $sql->get(['a.*', DB::raw('group_concat(c.title SEPARATOR " | ") as options'), DB::raw('(select count(e.id) from bet_players as e where e.bet_id=a.id) as player_num'), 'd.title as chosen', 'b.*']);

        return view('bets', ['mybets'=>$mybets, 'flag'=>$flag]);
    }

    public function betList(){
        $a = [
                "draw"=> 1,
                "recordsTotal"=> 18,
                "recordsFiltered"=> 18,
                'data' => [

                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                    [mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand()],
                ]
            ];
        return $a;
    }

    public function inviteMyfrinds(Request $request)
    {
        $friends = $request->input('friends');
        $betId = $request->input('bet_id');

        foreach($friends as $fr){
            if(BetPlayers::where('bet_id', $betId)->where('invited_email', $fr['email'])->first()){
                continue;
            }

            $player = new BetPlayers;
            $player->bet_id = $betId;
            $player->invitor_id = auth()->user()->id;
            $player->invited_email = $fr['email'];
            $player->invited_name = $fr['name'];
            $player->invited_at = date('Y-m-d H:i:s');
            $player->save();

        }

        return 'ok';
    }

    public function placeBet(Request $request)
    {
        $optionId = $request->input('optionId');
        $playerId = $request->input('playerId');
        $mybet = BetPlayers::find($playerId);


        $bet = Bet::find($mybet->bet_id);
        if($bet->status>=3){
            return '-1';
        }
        $bet->status = 2;
        $bet->save();

        $mybet->betting_option_id = $optionId;
        $mybet->betting_at = date('Y-m-d H:i:s');
        $mybet->save();

        return 'ok';
    }

}
