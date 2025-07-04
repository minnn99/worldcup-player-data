<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選手詳細</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <div class="detail-container">
    <h1 class="detail-header">▪️選手データ</h1>
    
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
                <th>国</th>
                <td>{{ $player->country->name }}</td>
            </tr>
            <tr>
                <th>所属</th>
                <td>{{ $player->club }}</td>
            </tr>
            <tr>
                <th>誕生日</th>
                <td>{{ $player->birth }}</td>
            </tr>
            <tr>
                <th>身長</th>
                <td>{{ $player->height }}</td>
            </tr>
            <tr>
                <th>体重</th>
                <td>{{ $player->weight }}</td>
            </tr>
            <tr>
                <th>総得点</th>
                <td>
                    @if($goals->count() > 0)
                        {{ $goals->count() }}点
                    @else
                        無得点です。
                    @endif
                </td>
            </tr>
            <tr>
                <th>得点履歴</th>
                <td>
                    @if($goals->count() > 0)
                        @foreach($goals as $goal)
                            • {{ Carbon\Carbon::parse($goal->kickoff)->format('Y-m-d H:i:s') }}開始 
                              {{ $goal->enemy_country_name }}戦 
                              {{ $goal->goal_time }}: {{ $loop->iteration }}点目<br>
                        @endforeach
                    @else
                        
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="actions">
        <a href="{{ url('/') }}" class="back-link">選手一覧に戻る</a>
    </div>
  </div>
</body>
</html>