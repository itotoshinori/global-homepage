<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:20'],
            'body' => ['required'],
            'image' => ['max:1024'],
        ];
    }
    public function messages()
    {
        return [
            'title.required' => '全角20文字以下でタイトルを入力して下さい。',
            'body.required' => '本文を入力して下さい。',
            'image' => '1MB以上の画像ファイルをアップロードできません',
        ];
    }
}
