<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayersController extends Controller
{
    public function index(){
        // 1ページあたり20人の選手データを表示
        $players = Player::paginate(20);
        return view('players.index', ['players' => $players]);
    }
    
    // 選手詳細情報を表示
    public function detail($id){
        $player = Player::find($id);
        
        if (!$player) {
            abort(404, '選手が見つかりません');
        }
        
        // players.detail ビューに選手データを渡す
        return view('players.detail', ['player' => $player]);
    }
}