<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
  public function showRegistrationForm()
  {
    $countries = Country::all();
    return view('auth.register', compact('countries'));
  }

  public function register(Request $request)
  {
    // バリデーションを実行
    $validator = $this->validator($request->all());
    
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator)
        ->withInput();
    }

    // ユーザーを作成
    $user = User::create([
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => $request->role,
      'country_id' => $request->role == '1' ? $request->country_id : null,
    ]);

    return redirect()->route('login')->with('success', '登録が完了しました。');
  }

  protected function validator(array $data)
  {
    return Validator::make($data, [
      // 必須入力 - 全項目
      'email' => [
        'required',
        'string',
        'email',
        'max:255',
        'unique:users'
      ],
      'password' => [
        'required',
        'string',
        'min:8',
        'confirmed'
      ],
      'password_confirmation' => [
        'required'
      ],
      'role' => [
        'required',
        'in:0,1'
      ],
      'country_id' => [
        'required_if:role,1',
        'nullable',
        'exists:countries,id'
      ]
    ], [
      // バリデーションルールに基づくカスタムメッセージ
      
      // 必須入力 - 全体
      'email.required' => 'この項目は必須入力です。',
      'password.required' => 'この項目は必須入力です。',
      'password_confirmation.required' => 'この項目は必須入力です。',
      'role.required' => 'この項目は必須入力です。',
      'country_id.required_if' => 'この項目は必須入力です。',
      
      // メールアドレスの形式が正しくない
      'email.email' => 'emailの形式で入力してください。',
      
      // 入力されたメールアドレスはすでに登録されている
      'email.unique' => '入力されたメールアドレスはすでに登録されています。',
      
      // パスワードが8文字未満
      'password.min' => 'パスワードは8文字以上で入力してください。',
      
      // パスワード確認が一致しない
      'password.confirmed' => 'パスワードが確認用と一致していません。',
      
      // その他
      'role.in' => 'ユーザー種別を正しく選択してください。',
      'country_id.exists' => '有効な国を選択してください。'
    ]);
  }
}