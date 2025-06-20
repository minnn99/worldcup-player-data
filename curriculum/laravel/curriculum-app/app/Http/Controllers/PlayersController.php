<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Country;
use App\Models\Goal;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PlayersController extends Controller
{
    public function index(){
        // del_flgが0の選手のみを表示（論理削除済みは除外）
        // Countryとのリレーションも含めて取得
        $players = Player::with('country')->active()->paginate(20);
        
        // 時間ベースのトークンを生成（10分間有効）
        $accessToken = Str::random(40);
        $tokenExpiry = now()->addMinutes(10);
        
        // セッションにトークンと有効期限を保存
        session([
            'detail_access_token' => $accessToken,
            'token_expiry' => $tokenExpiry
        ]);
        
        return view('players.index', ['players' => $players, 'accessToken' => $accessToken]);
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
    public function edit($id) {
        // 指定されたIDの選手データを取得（論理削除されていないもののみ）
        $player = Player::with('country')->active()->find($id);
        
        // 選手が見つからない場合
        if (!$player) {
            return redirect('/')->with('message', '選手が見つかりません。');
        }
        
        // 全ての国を取得
        $countries = Country::all();
        
        // 編集画面を表示
        return view('players.edit', ['player' => $player, 'countries' => $countries]);
    }

    // 選手情報を更新（POST/PUT通信）
    public function update(Request $request, $id) {
        // バリデーション
        $request->validate([
            'uniform_num' => 'required|integer',
            'position' => 'required|string|max:10',
            'name' => 'required|string|max:50',
            'club' => 'required|string|max:100',
            'birth' => 'required|date',
            'height' => 'required|integer',
            'weight' => 'required|integer',
            'country_id' => 'required|exists:countries,id'
        ]);

        // 選手データを取得
        $player = Player::active()->find($id);
        
        if (!$player) {
            return redirect('/')->with('message', '選手が見つかりません。');
        }

        // データを更新
        $player->update($request->all());

        // 一覧画面にリダイレクト
        return redirect('/')->with('message', '選手情報を更新しました。');
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
}