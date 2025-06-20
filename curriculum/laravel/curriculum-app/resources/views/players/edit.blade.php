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

    @php
        // フォームフィールドの定義
        $fields = [
            ['label' => '背番号:', 'name' => 'uniform_num', 'type' => 'number'],
            ['label' => 'ポジション:', 'name' => 'position', 'type' => 'text'],
            ['label' => '名前:', 'name' => 'name', 'type' => 'text'],
            ['label' => '所属:', 'name' => 'club', 'type' => 'text'],
            ['label' => '誕生日:', 'name' => 'birth', 'type' => 'date'],
            ['label' => '身長 (cm):', 'name' => 'height', 'type' => 'number'],
            ['label' => '体重 (kg):', 'name' => 'weight', 'type' => 'number'],
        ];
    @endphp

    <!-- 編集フォーム -->
    <form method="POST" action="{{ route('players.update', $player->id) }}">
        @csrf
        @method('PUT')
        
        @foreach($fields as $field)
            <div class="player-edit-form">
                <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                <input
                    type="{{ $field['type'] }}"
                    id="{{ $field['name'] }}"
                    name="{{ $field['name'] }}"
                    value="{{ old($field['name'], $player->{$field['name']}) }}"
                    required
                >
            </div>
        @endforeach

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

        <div class="form-actions">
            <button type="submit">更新</button>
            <a href="{{ url('/') }}" class="cancel-link">キャンセル</a>
        </div>
    </form>
</body>
</html>