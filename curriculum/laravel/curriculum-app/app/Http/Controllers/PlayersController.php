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
    public function index(){
        // del_flgが0の選手のみを表示（論理削除済みは除外）
        // Countryとのリレーションも含めて取得
        $query = Player::with('country')->active();
        
        // ログインしているユーザーが一般ユーザー（role=1）の場合、
        // そのユーザーの国の選手を優先的に表示
        if (session('user_role') === 1 && session('user_country_id')) {
            $query->orderByRaw('CASE WHEN country_id = ? THEN 0 ELSE 1 END', [session('user_country_id')])
                  ->orderBy('id');
        }
        
        $players = $query->paginate(20);
        
        // 時間ベースのトークンを生成（10分間有効）
        $accessToken = Str::random(40);
        $tokenExpiry = now()->addMinutes(10);
        
        // セッションにトークンと有効期限を保存
        session([
            'detail_access_token' => $accessToken,
            'token_expiry' => $tokenExpiry
        ]);
        
        return view('players.index', [
            'players' => $players, 
            'accessToken' => $accessToken
        ]);
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
        
        return view('players.edit', compact('player', 'countries', 'positions'));
    }

    // 選手情報を更新（POST/PUT通信）
    public function update(UpdatePlayerRequest $request, $id)
    {
        $player = Player::findOrFail($id);
        $player->update($request->validated());

        return redirect()->route('players.detail', $player->id)
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
}