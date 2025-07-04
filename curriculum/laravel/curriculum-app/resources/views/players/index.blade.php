<!DOCTYPE html>
<html>
<head>
    <title>選手一覧</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- ヘッダー部分 -->
    <div class="header">
        <div class="user-info">
            <div>
                @if(session('user_role') === 0)
                    <span class="user-role">管理者ユーザー</span>
                @else
                    <span class="user-role">一般ユーザー</span>
                @endif
            </div>
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">ログアウト</button>
                </form>
            </div>
        </div>
    </div>

    <!-- 直接アクセス時のメッセージ表示 -->
    @if(session('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
    @endif

    @if(session('error'))
        <div class="error-message" style="color: red; padding: 10px; margin-bottom: 20px; border: 1px solid red; border-radius: 4px;">
            {{ session('error') }}
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
                <th>체重</th>
                <th></th>
                @if(session('user_role') === 0)
                    <th></th>
                    <th></th>
                @endif
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
                <td>
                    <a href="{{ route('players.detail', ['id' => $player->id, 'token' => $accessTokens[$player->id]]) }}" 
                       id="detailed-{{ $player->id }}" 
                       class="btn detail-link">詳細</a>
                </td>
                @if(session('user_role') === 0)
                    <td><a href="{{ route('players.edit', $player->id) }}" id="edit_button" class="btn edit-link">編集</a></td>
                    <td>
                        <form method="POST" action="{{ route('players.destroy', $player->id) }}" style="display:inline;" onsubmit="return confirm('この選手データを削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="delete_button" class="btn delete-button">削除</button>
                        </form>
                    </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $players->links() }}
    </div>
</body>
</html>