<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayersController extends Controller
{
    public function index(){
        // 페이지당 20명씩 표시
        $players = Player::paginate(20);
        return view('players.index', ['players' => $players]);
    }
    
    // 선수 상세 정보 표시
    public function detail($id){
        $player = Player::find($id);
        
        if (!$player) {
            abort(404, '選手が見つかりません');
        }

        return view('players.detail', ['player' => $player]);
    }
}