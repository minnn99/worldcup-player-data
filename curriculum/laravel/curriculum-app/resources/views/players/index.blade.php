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
                <th>国</th>
                <th>誕生日</th>
                <th>身長</th>
                <th>体重</th>
                <th></th>
                <th></th>
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
                <td>{{ $player->country ? $player->country->name : '未設定' }}</td>
                <td>{{ $player->birth }}</td>
                <td>{{ $player->height }}</td>
                <td>{{ $player->weight }}</td>
                <td><a href="{{ route('players.detail', ['id' => $player->id, 'token' => $accessToken]) }}" id="detailed-{{ $player->id }}" class=" btn detail-link">詳細</a></td>
                <td><a href="{{ route('players.edit', $player->id) }}" id="edit_button" class="btn edit-link">編集</a></td>
                <td>
                    <form method="POST" action="{{ route('players.destroy', $player->id) }}" style="display:inline;" onsubmit="return confirm('この選手データを削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="delete_button" class="btn delete-button">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $players->links() }}
    </div>
</body>
</html>