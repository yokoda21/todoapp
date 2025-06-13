<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 認証が必要な場合は true に変更してください
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name' => 'required|max:10|unique:categories,name|string',
        ];
    }
    //バリデーションルール
    public function messages()
    {
        return [
            'name.required' => 'カテゴリ名を入力してｗください。',
            'name.max' => 'カテゴリー名は最大10文字以下で入力してください。',
            'name.unique' => 'このカテゴリはすでに存在します。',
            'name.string' => 'カテゴリを文字列でで入力してください。',
        ];
    }

}
