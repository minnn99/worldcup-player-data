<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use Illuminate\Support\Str;

class PlayersController extends Controller
{
    public function index(){
        // 1ページあたり20人の選手データを表示
        $players = Player::paginate(20);

        // アクセストークン生成
        $accessToken = Str::random(40);
        session(['detail_access_token' => $accessToken]);
        
        return view('players.index', ['players' => $players, 'accessToken' => $accessToken]);
    }
    
    // 選手詳細情報を表示
    public function detail(Request $request, $id){
        // トークン検証
        $token = $request->get('token');
        $sessionToken = session('detail_access_token');
        
        if (!$token || !$sessionToken || $token !== $sessionToken) {
            return redirect('/')->with('message', '選手一覧画面からアクセスしてください。');
        }

        // トークン使用後削除（1回のみ有効）
        session()->forget('detail_access_token');
        
        $player = Player::find($id);
        
        if (!$player) {
            return redirect('/')->with('message', '選手が見つかりません。');
        }
        
        return view('players.detail', ['player' => $player]);
    }
}