<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HalfWidthNumber implements Rule
{
    public function passes($attribute, $value)
    {
        // 全角数字のパターン
        return !preg_match('/[０-９]/u', $value);
    }

    public function message()
    {
        return 'この項目は半角数字で入力してください。';
    }
}
