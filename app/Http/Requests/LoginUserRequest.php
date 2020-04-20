<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            'loginusername' => 'required|unique:user,username|regex:/^[\.\_\-\w\d\@]{3,15}$/',
            'loginpassword' => 'required|regex:/^[A-z0-9\.\-\*\_$\:\;\@\,]{6,15}$/'
        ];
    }

    public function messages()
    {
        return [
            'loginusername.unique' => 'Username exist.',
            'loginpassword.unique'  => 'Email exist.',
            'loginusername.regex'  => 'Username is not valid.',
            'loginpassword.regex'  => 'Password is not valid.',

        ];
    }
}
