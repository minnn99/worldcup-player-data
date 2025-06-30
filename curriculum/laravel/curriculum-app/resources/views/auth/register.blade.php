<!DOCTYPE html>
<html>
<head>
    <title>新規登録画面</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="login-page">
    
    <div class="login-container">
        <h1 class="login-title">新規登録画面</h1>
        
        @if(session('success'))
            <div class="login-success-message">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf
            
            <div class="login-form-group">
                <label for="email">ログインID:</label>
                @error('email')
                    <div class="login-error-message">{{ $message }}</div>
                @enderror
                <input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="メールアドレス">
            </div>

            <div class="login-form-group">
                <label for="password">パスワード:</label>
                @error('password')
                    <div class="login-error-message">{{ $message }}</div>
                @enderror
                <input type="password" id="password" name="password" placeholder="パスワード">
            </div>

            <div class="login-form-group">
                <label for="password_confirmation">パスワード確認:</label>
                @error('password_confirmation')
                    <div class="login-error-message">{{ $message }}</div>
                @enderror
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="パスワード">
            </div>

            <div class="login-form-group">
                <label>ユーザー種別選択:</label>
                @error('role')
                    <div class="login-error-message">{{ $message }}</div>
                @enderror
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="role" value="1" {{ old('role', '1') == '1' ? 'checked' : '' }}>
                        <span>一般ユーザー</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="role" value="0" {{ old('role') == '0' ? 'checked' : '' }}>
                        <span>管理ユーザー</span>
                    </label>
                </div>
            </div>

            <div class="login-form-group" id="country-group">
                <label for="country_id">所属国選択:</label>
                @error('country_id')
                    <div class="login-error-message">{{ $message }}</div>
                @enderror
                <select id="country_id" name="country_id">
                    <option value="">選択してください</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <style>
                .hidden { display: none !important; }
            </style>

            <button type="submit" class="btn-login">登録</button>
        </form>

        <div class="register-link">
            <a href="{{ route('login') }}">ログイン画面に戻る</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ブラウザのデフォルトバリデーションを無効化
            // 既にフォームに novalidate 属性があるため、ここで再設定する必要はありません。

            // 入力フィールドが変更された時、既存のエラーメッセージを非表示にする
            document.querySelectorAll('input, select').forEach(function(input) {
                input.addEventListener('input', function() {
                    var errorMessage = this.closest('.login-form-group').querySelector('.login-error-message');
                    if (errorMessage) {
                        errorMessage.style.display = 'none';
                    }
                });
            });

            // ユーザー種別によって所属国選択を表示・非表示にする
            document.querySelectorAll('input[name="role"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    var countryGroup = document.getElementById('country-group');
                    if (this.value === '1') {
                        countryGroup.classList.remove('hidden');
                    } else {
                        countryGroup.classList.add('hidden');
                    }
                });
            });

            // ページロード時の初期状態設定
            var selectedRole = document.querySelector('input[name="role"]:checked');
            var countryGroup = document.getElementById('country-group');
            if (selectedRole && selectedRole.value === '0') {
                countryGroup.classList.add('hidden');
            } else {
                countryGroup.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>