<?php

namespace App\Models;

class Position
{
    public static function getList()
    {
        return [
            'GK' => 'ゴールキーパー',
            'DF' => 'ディフェンダー',
            'MF' => 'ミッドフィールダー',
            'FW' => 'フォワード'
        ];
    }
}