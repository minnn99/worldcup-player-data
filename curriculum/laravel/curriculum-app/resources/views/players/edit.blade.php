<!DOCTYPE html>
<html>
<head>
    <title>選手情報編集 - {{ $player->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="edit-container">
        <h1 class="edit-header">選手情報編集</h1>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('players.update', $player->id) }}">
            @csrf
            @method('PUT')
            
            <table class="edit-table">
                <tr>
                    <th>No</th>
                    <td>{{ $player->id }}</td>
                </tr>
                <tr>
                    <th>背番号</th>
                    <td>
                        <input placeholder="背番号を入力してください。" type="number" name="uniform_num" value="{{ old('uniform_num', $player->uniform_num) }}" required>
                    </td>
                </tr>
                <tr>
                    <th>ポジション</th>
                    <td>
                        <select name="position" required>
                            <option value="GK" {{ $player->position == 'GK' ? 'selected' : '' }}>GK</option>
                            <option value="DF" {{ $player->position == 'DF' ? 'selected' : '' }}>DF</option>
                            <option value="MF" {{ $player->position == 'MF' ? 'selected' : '' }}>MF</option>
                            <option value="FW" {{ $player->position == 'FW' ? 'selected' : '' }}>FW</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>名前</th>
                    <td>
                        <input placeholder="名前を入力してください。" type="text" name="name" value="{{ old('name', $player->name) }}" required>
                    </td>
                </tr>
                <tr>
                    <th>国</th>
                    <td>
                        <select name="country_id" required>
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
                        <input placeholder="所属を入力してください。" type="text" name="club" value="{{ old('club', $player->club) }}" required>
                    </td>
                </tr>
                <tr>
                    <th>誕生日</th>
                    <td>
                        <input type="date" name="birth" value="{{ old('birth', $player->birth) }}" required>
                    </td>
                </tr>
                <tr>
                    <th>身長</th>
                    <td>
                        <input placeholder="身長を入力してください。" type="number" name="height" value="{{ old('height', $player->height) }}" required>
                    </td>
                </tr>
                <tr>
                    <th>体重</th>
                    <td>
                        <input placeholder="体重を入力してください。" type="number" name="weight" value="{{ old('weight', $player->weight) }}" required>
                    </td>
                </tr>
            </table>

            <div class="form-actions">
                <button type="submit" class="submit-btn">編集</button>
                <a href="{{ url('/') }}" class="cancel-link">戻る</a>
            </div>
        </form>
    </div>
</body>
</html>