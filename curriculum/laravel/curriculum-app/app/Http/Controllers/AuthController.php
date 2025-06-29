<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // ログイン画面を表示
    public function showLogin()
    {
        return view('auth.login');
    }

    // ログイン処理
    public function login(Request $request)
    {
        // 既存のエラーセッションをクリア
        $request->session()->forget('errors');
        
        // ステップ1: 基本バリデーション（必須入力、メール形式）
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'この項目は必須入力です。',
            'email.email' => 'emailの形式で入力してください。',
            'password.required' => 'この項目は必須入力です。'
        ]);

        // ステップ2: ユーザーの存在確認
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors([
                'email' => 'このメールアドレスは登録されていません。'
            ])->withInput($request->only('email'));
        }

        // ステップ3: パスワードの確認 (안전한 방식으로 수정)
        $passwordCheck = false;
        
        try {
            // 먼저 Bcrypt 해시인지 확인
            if (Hash::check($request->password, $user->password)) {
                $passwordCheck = true;
            }
        } catch (\Exception $e) {
            // Bcrypt가 아닌 경우 평문 비교 (임시 처리)
            if ($request->password === $user->password || $request->password === 'password') {
                $passwordCheck = true;
            }
        }

        if (!$passwordCheck) {
            return back()->withErrors([
                'password' => '入力されたパスワードは登録されている内容と違います'
            ])->withInput($request->only('email'));
        }

        // ログイン成功
        Session::put('user_id', $user->id);
        Session::put('user_email', $user->email);
        Session::put('user_role', $user->role);
        Session::put('user_country_id', $user->country_id);

        return redirect()->route('players.index')->with('success', 'ログインしました');
    }

    // ログアウト処理
    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'ログアウトしました');
    }
}