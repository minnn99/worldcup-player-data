<!DOCTYPE html>
<html>
<head>
    <title>選手情報編集 - {{ $player->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>選手情報編集</h1>
    
    <!-- バリデーションエラー表示 -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 編集フォーム -->
    <form method="POST" action="{{ route('players.update', $player->id) }}">
        @csrf
        @method('PUT')
        
        <div class="player-edit-form">
            <label for="uniform_num">背番号:</label>
            <input type="number" id="uniform_num" name="uniform_num" value="{{ old('uniform_num', $player->uniform_num) }}" required>
        </div>

        <div class="player-edit-form">
            <label for="position">ポジション:</label>
            <input type="text" id="position" name="position" value="{{ old('position', $player->position) }}" required>
        </div>

        <div class="player-edit-form">
            <label for="name">名前:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $player->name) }}" required>
        </div>

        <div class="player-edit-form">
            <label for="club">所属:</label>
            <input type="text" id="club" name="club" value="{{ old('club', $player->club) }}" required>
        </div>

        <div class="player-edit-form">
            <label for="country_id">国:</label>
            <select id="country_id" name="country_id" required>
                <option value="">選択してください</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ old('country_id', $player->country_id) == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="player-edit-form">
            <label for="birth">誕生日:</label>
            <input type="date" id="birth" name="birth" value="{{ old('birth', $player->birth) }}" required>
        </div>

        <div class="player-edit-form">
            <label for="height">身長 (cm):</label>
            <input type="number" id="height" name="height" value="{{ old('height', $player->height) }}" required>
        </div>

        <div class="player-edit-form">
            <label for="weight">体重 (kg):</label>
            <input type="number" id="weight" name="weight" value="{{ old('weight', $player->weight) }}" required>
        </div>

        <div class="form-actions">
            <button type="submit">更新</button>
            <a href="{{ url('/') }}" class="cancel-link">キャンセル</a>
        </div>
    </form>
</body>
</html>