<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . \Auth::id(),
            'email' => 'required|email|unique:users,email,' . \Auth::id(),
            'intro' => 'max:80',
        ];
    }

    public function messages()
    {
        return [
            'name.between' => '用户名必须在 3 ~ 25 个字符之间',
            'name.regex' => '用户名只能包含数字、字母、横杠和下划线',
            'name.unique' => '请重新输入，该用户名已存在',
        ];
    }
}
