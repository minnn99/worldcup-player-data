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
        
        // 時間ベースのトークンを生成（5分間有効）
        $accessToken = Str::random(40);
        $tokenExpiry = now()->addMinutes(5);
        
        // セッションにトークンと有効期限を保存
        session([
            'detail_access_token' => $accessToken,
            'token_expiry' => $tokenExpiry
        ]);
        
        return view('players.index', ['players' => $players, 'accessToken' => $accessToken]);
    }
    
    // 選手詳細情報を表示
    public function detail(Request $request, $id){
        // リクエストからトークンを取得
        $token = $request->get('token');
        // セッションからトークンと有効期限を取得
        $sessionToken = session('detail_access_token');
        $tokenExpiry = session('token_expiry');
        
        // トークンが存在しない、一致しない、または期限切れの場合
        if (!$token || !$sessionToken || $token !== $sessionToken || 
            !$tokenExpiry || now()->greaterThan($tokenExpiry)) {
            return redirect('/')->with('message', '選手一覧画面からアクセスしてください。');
        }
        
        // 指定されたIDの選手データを取得
        $player = Player::find($id);
        
        // 選手が見つからない場合
        if (!$player) {
            return redirect('/')->with('message', '選手が見つかりません。');
        }
        
        // 選手詳細ビューにデータを渡して表示
        return view('players.detail', ['player' => $player]);
    }
}