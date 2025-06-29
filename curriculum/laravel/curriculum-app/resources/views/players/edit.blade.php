<!DOCTYPE html>
<html>
<head>
    <title>選手情報編集</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="edit-container">
        <h1 class="edit-header">▪️選手データ</h1>
        <form method="POST" action="{{ route('players.update', $player->id) }}">
            @csrf
            @method('PUT')
            <table class="edit-table">
                <tr>
                    <th>背番号</th>
                    <td>
                        @error('uniform_num')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="number" name="uniform_num" value="{{ old('uniform_num', $player->uniform_num) }}">
                    </td>
                </tr>
                <tr>
                    <th>ポジション</th>
                    <td>
                        @error('position')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <select name="position">
                            <option value="">選択してください</option>
                            @foreach($positions as $key => $value)
                                <option value="{{ $key }}" {{ old('position', $player->position) == $key ? 'selected' : '' }}>
                                    {{ $key }} - {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>名前</th>
                    <td>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="text" name="name" value="{{ old('name', $player->name) }}">
                    </td>
                </tr>
                <tr>
                    <th>国</th>
                    <td>
                        @error('country_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <select name="country_id">
                            <option value="">選択してください</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $player->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>所属</th>
                    <td>
                        @error('club')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="text" name="club" value="{{ old('club', $player->club) }}">
                    </td>
                </tr>
                <tr>
                    <th>誕生日</th>
                    <td>
                        @error('birth')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="date" name="birth" value="{{ old('birth', $player->birth) }}">
                    </td>
                </tr>
                <tr>
                    <th>身長</th>
                    <td>
                        @error('height')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="number" name="height" value="{{ old('height', $player->height) }}">
                    </td>
                </tr>
                <tr>
                    <th>体重</th>
                    <td>
                        @error('weight')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        <input type="number" name="weight" value="{{ old('weight', $player->weight) }}">
                    </td>
                </tr>
            </table>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn">更新</button>
                <a href="{{ route('players.detail', $player->id) }}" class="cancel-link">選手データに戻る</a>
            </div>
        </form>
    </div>
</body>
</html>