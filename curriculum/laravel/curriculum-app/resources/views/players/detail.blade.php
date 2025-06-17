<!DOCTYPE html>
<html>
<head>
    <title>選手詳細 - {{ $player->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>▪️選手データ</h1>
    <div class="player-detail">
        <table>
            <tr>
                <th>No</th>
                <td>{{ $player->id }}</td>
            </tr>
            <tr>
                <th>背番号</th>
                <td>{{ $player->uniform_num }}</td>
            </tr>
            <tr>
                <th>ポジション</th>
                <td>{{ $player->position }}</td>
            </tr>
            <tr>
                <th>名前</th>
                <td>{{ $player->name }}</td>
            </tr>
            <tr>
                <th>配属</th>
                <td>{{ $player->club }}</td>
            </tr>
            <tr>
                <th>誕生日</th>
                <td>{{ $player->birth }}</td>
            </tr>
            <tr>
                <th>身長</th>
                <td>{{ $player->height }}cm</td>
            </tr>
            <tr>
                <th>体重</th>
                <td>{{ $player->weight }}kg</td>
            </tr>
        </table>
    </div>
    
    <div class="actions">
        <a href="{{ url('/') }}" class="back-link">選手一覧に戻る</a>
    </div>
</body>
</html>