<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Country;
use App\Models\Goal;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdatePlayerRequest;

class PlayersController extends Controller
{
    public function index()
    {
        $players = Player::with('country')
            ->where('del_flg', 0)  // 論理削除されていない選手のみ表示
            ->paginate(20);
        
        // 各選手ごとに個別のアクセストークンを生成
        $accessTokens = [];
        foreach ($players as $player) {
            $token = Str::random(32);
            $accessTokens[$player->id] = $token;
            session(["player_access_token_{$player->id}" => $token]);
        }
        
        return view('players.index', compact('players', 'accessTokens'));
    }
    
    // 選手詳細情報を表示
    public function detail(Request $request, $id)
    {
        $player = Player::with(['country'])->find($id);
        
        if (!$player) {
            return redirect('/')->with('message', '選手が見つかりません。');
        }

        // 得点情報を取得
        $goals = DB::table('goals')
            ->join('pairings', 'goals.pairing_id', '=', 'pairings.id')
            ->join('countries as enemy', 'pairings.enemy_country_id', '=', 'enemy.id')
            ->where('goals.player_id', $id)
            ->select([
                'goals.goal_time',
                'pairings.kickoff',
                'enemy.name as enemy_country_name'
            ])
            ->orderBy('pairings.kickoff')
            ->orderBy('goals.goal_time')
            ->get();

        return view('players.detail', compact('player', 'goals'));
    }

    // 選手情報編集画面を表示（GET通信）
    public function edit($id)
    {
        $player = Player::findOrFail($id);
        $countries = Country::all();
        
        $positions = [
            'GK' => 'ゴールキーパー',
            'DF' => 'ディフェンダー',
            'MF' => 'ミッドフィールダー',
            'FW' => 'フォワード'
        ];
        
        // 編集ページから詳細ページに戻るためのトークンを生成
        $token = Str::random(32);
        session(["player_access_token_{$player->id}" => $token]);
        
        return view('players.edit', compact('player', 'countries', 'positions', 'token'));
    }

    // 選手情報を更新（POST/PUT通信）
    public function update(UpdatePlayerRequest $request, $id)
    {
        $player = Player::findOrFail($id);
        $player->update($request->validated());

        // 更新後、詳細ページにリダイレクトする際のトークンを生成
        $token = Str::random(32);
        session(["player_access_token_{$player->id}" => $token]);

        return redirect()->route('players.detail', ['id' => $player->id, 'token' => $token])
            ->with('message', '選手情報を更新しました。');
    }

    // 選手を論理削除（DELETE通信）
    public function destroy($id) {
        // 指定されたIDの選手データを取得（論理削除されていないもののみ）
        $player = Player::active()->find($id);
        
        // 選手が見つからない場合
        if (!$player) {
            return redirect('/')->with('message', '選手が見つかりません。');
        }

        // 物理削除ではなく論理削除（del_flgを1に設定）
        // 直接クエリを使用してupdated_atエラーを回避
        DB::table('players')
            ->where('id', $id)
            ->update(['del_flg' => 1]);

        // 一覧画面にリダイレクトとメッセージ表示
        return redirect('/')->with('message', '選手データを削除しました。');
    }
    
    public function show($id)
    {
        // 該当選手のアクセストークンがセッションにあるか確認
        $sessionToken = session("player_access_token_{$id}");
        $requestToken = request('token');
        
        // トークンがない、または一致しない場合はアクセスを拒否
        if (!$sessionToken || $sessionToken !== $requestToken) {
            return redirect('/')->with('error', '選手一覧から選手を選択してください。');
        }
        
        // トークン使用後に削除（使い捨て）
        session()->forget("player_access_token_{$id}");
        
        // del_flg = 0の選手のみ取得
        $player = Player::with('country')
            ->where('del_flg', 0)
            ->find($id);
        
        // 選手が存在しない、または論理削除されている場合
        if (!$player) {
            return redirect('/')->with('error', 'この選手データは削除されているか存在しません。');
        }
        
        // game -> pairingに変更
        $goals = Goal::with('pairing')->where('player_id', $id)->get();
        
        return view('players.detail', compact('player', 'goals'));
    }
}