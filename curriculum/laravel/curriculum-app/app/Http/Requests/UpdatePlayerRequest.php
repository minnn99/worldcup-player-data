<?php

namespace App\Http\Requests;

use App\Rules\HalfWidthNumber;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlayerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'uniform_num' => ['required', 'numeric', new HalfWidthNumber],
            'position' => 'required|in:GK,DF,MF,FW',
            'name' => 'required|string|max:50',
            'country_id' => 'required|exists:countries,id',
            'club' => 'required|string|max:50',
            'birth' => 'required|date|date_format:Y-m-d',
            'height' => ['required', 'numeric', new HalfWidthNumber],
            'weight' => ['required', 'numeric', new HalfWidthNumber],
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'この項目は必須入力です。',
            'numeric' => ':attributeは数字で入力してください。',
            'date' => ':attributeは「YYYY-MM-DD」で入力してください。',
            'date_format' => ':attributeは「YYYY-MM-DD」で入力してください。',
            'in' => '選択された:attributeは正しくありません。',
            'exists' => '選択された:attributeは正しくありません。',
            'max' => ':attributeは:max文字以内で入力してください。'
        ];
    }

    public function attributes()
    {
        return [
            'uniform_num' => '背番号',
            'position' => 'ポジション',
            'name' => '名前',
            'country_id' => '国',
            'club' => '所属',
            'birth' => '誕生日',
            'height' => '身長',
            'weight' => '体重',
        ];
    }
}
