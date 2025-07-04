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
    public function __construct()
    {
        // 모든 액션에 인증 확인
        $this->middleware('check.auth');
        // 편집, 업데이트, 삭제는 관리자만 가능
        $this->middleware('check.admin')->only(['edit', 'update', 'destroy']);
    }

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
        
        // 各選手ごとに個別のアクセストークンを生成
        $accessTokens = [];
        foreach ($players as $player) {
            $token = Str::random(32);
            $accessTokens[$player->id] = $token;
            session(["player_access_token_{$player->id}" => $token]);
        }
        
        return view('players.index', compact('players', 'accessTokens'));
    }

    public function detail($id, Request $request)
    {
        // トークン認証
        $expectedToken = session("player_access_token_{$id}");
        $providedToken = $request->query('token');
        
        if (!$expectedToken || $expectedToken !== $providedToken) {
            return redirect()->route('players.index')->with('error', '不正なアクセスです。');
        }
        
        // セッションからトークンを削除（一回限りの使用）
        session()->forget("player_access_token_{$id}");
        
        // del_flg = 0 （論理削除されていない）選手のみ表示
        $player = Player::with(['country'])->active()->find($id);
        
        if (!$player) {
            return redirect()->route('players.index')->with('error', '選手が見つかりません。');
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

    public function edit($id)
    {
        // del_flg = 0 （論理削除されていない）選手のみ編集可能
        $player = Player::active()->find($id);
        
        if (!$player) {
            return redirect()->route('players.index')->with('error', '選手が見つかりません。');
        }
        
        $countries = Country::all();
        $positions = [
            'GK' => 'ゴールキーパー',
            'DF' => 'ディフェンダー', 
            'MF' => 'ミッドフィールダー',
            'FW' => 'フォワード'
        ];
        
        return view('players.edit', compact('player', 'countries', 'positions'));
    }

    public function update(UpdatePlayerRequest $request, $id)
    {
        // del_flg = 0 （論理削除されていない）選手のみ更新可能
        $player = Player::active()->find($id);
        
        if (!$player) {
            return redirect()->route('players.index')->with('error', '選手が見つかりません。');
        }
        
        $player->update($request->validated());
        
        return redirect()->route('players.index')->with('success', '選手情報を更新しました。');
    }

    public function destroy($id)
    {
        // del_flg = 0 （論理削除されていない）選手のみ削除可能
        $player = Player::active()->find($id);
        
        if (!$player) {
            return redirect()->route('players.index')->with('error', '選手が見つかりません。');
        }
        
        // 論理削除（del_flgを1に設定）
        $player->update(['del_flg' => 1]);
        
        return redirect()->route('players.index')->with('success', '選手を削除しました。');
    }
}
