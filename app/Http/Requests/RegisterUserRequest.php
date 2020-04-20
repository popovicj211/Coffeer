<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
                   'name' => 'required|regex:/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,13}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,15})+$/' ,
                   'username' => 'required|unique:user,username|regex:/^[\.\_\-\w\d\@]{3,15}$/',
                   'email' => 'required|email|unique:user,email|max:60',
                   'password' => 'required|regex:/^[A-z0-9\.\-\*\_$\:\;\@\,]{6,15}$/'
        ];
    }

    public function messages()
    {
        return [
            'username.unique' => 'Username exist.',
            'email.unique'  => 'Email exist.',
            'name.regex'  => 'Name is not valid.',
            'username.regex'  => 'Username is not valid.',
            'email.regex'  => 'Email is not valid.',
            'password.regex'  => 'Password is not valid.',
            'name.required'  => 'Name is empty.',
            'username.required'  => 'Username is empty.',
            'email.required'  => 'Email is empty.',
            'password.required'  => 'Password is empty.'
        ];
    }
}
