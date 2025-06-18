<!DOCTYPE html>
<html>
<head>
    <title>選手一覧</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- 直接アクセス時のメッセージ表示 -->
    @if(session('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>背番号</th>
                <th>ポジション</th>
                <th>所属</th>
                <th>名前</th>
                <th>誕生日</th>
                <th>身長</th>
                <th>体重</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($players as $index => $player)
            <tr>
                <td>{{ ($players->currentPage() - 1) * $players->perPage() + $index + 1 }}</td>
                <td>{{ $player->uniform_num }}</td>
                <td>{{ $player->position }}</td>
                <td>{{ $player->club }}</td>
                <td>{{ $player->name }}</td>
                <td>{{ $player->birth }}</td>
                <td>{{ $player->height }}</td>
                <td>{{ $player->weight }}</td>
                <td><a href="{{ route('players.detail', ['id' => $player->id, 'token' => $accessToken]) }}" id="detailed-{{ $player->id }}" class="detail-link">詳細</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>