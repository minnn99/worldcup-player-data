<!DOCTYPE html>
<html>
<head>
  <title>ログイン画面</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="login-page">
  
  <div class="login-container">
    <h1 class="login-title">ログイン</h1>
    
    @if(session('success'))
      <div class="login-success-message">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate>
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

      <button type="submit" class="btn-login">ログイン</button>
    </form>

    <div class="register-link">
      <a href="{{ route('register') }}">新規登録はこちら</a>
    </div>
  </div>

  <script>
    // ログインフォーム送信時にブラウザのデフォルトバリデーションを無効化
    document.querySelector('form').addEventListener('submit', function(e) {
      // ブラウザのデフォルトバリデーションを無効化
      this.setAttribute('novalidate', 'novalidate');
    });
    
    // 入力フィールドが変更された時、既存のエラーメッセージを非表示にする
    document.querySelectorAll('input').forEach(function(input) {
      input.addEventListener('input', function() {
        var errorMessage = this.parentNode.querySelector('.login-error-message');
        if (errorMessage) {
          errorMessage.style.display = 'none';
        }
      });
    });
  </script>
</body>
</html>