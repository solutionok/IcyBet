<?php

function getFriendsList(){
    $user = auth()->user();
    if($user) {
        $mybet = DB::table('bet_players')->where('invited_email', $user->email)->pluck('bet_id');
        $mybet[] = -1;

        $list = DB::table('bet_players')->whereIn('bet_id', $mybet)->where('invited_email', '<>', $user->email)->groupBy('invited_email')->get();
        return $list;
    };
}

function IT2LT($IT){
    $s = preg_split("/[\.\/\-\,]/",$IT);
    if(count($s)!=3||$s[2]<1001)return $IT;
    return sprintf('%04d-%02d-%02d', $s[2], $s[0], $s[1]);
}
function LT2IT($LT){
    $s = preg_split("/[\.\/\-\,]/",$LT);
    if(count($s)!=3||$s[0]<1001)return $LT;
    return sprintf('%02d.%02d.%04d', $s[1], $s[2], $s[0]);
}
