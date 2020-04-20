<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
                 'adminUserUpdateName' => 'required|regex:/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,13}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,15})+$/',
                 'adminUserUpdateUsername' => 'required|unique:user,username|regex:/^[\.\_\-\w\d\@]{3,15}$/',
                 'adminUserUpdateEmail' => 'required|email|unique:user,email|max:60',
              //   'adminUserUpdatePass' => 'required|regex:/^[A-z0-9\.\-\*\_$\:\;\@\,]{6,15}$/',
                 'adminUserUpdateRole' => 'required|not_in:0',
                 'adminUserUpdateActive' => 'required'
             ];

    }

    public function messages()
    {
            return [
                'adminUserUpdateUsername.unique' => 'Update username exist.',
                'adminUserUpdateEmail.unique' => 'Update email exist.',
                'adminUserUpdateName.regex' => 'Update name is not valid.',
                'adminUserUpdateUsername.regex' => 'Update username is not valid.',
                'adminUserUpdateEmail.regex' => 'Update email is not valid.',
             //   'adminUserUpdatePass.regex' => 'Password is not valid.',
                'adminUserUpdateRole.required' => 'Update role is not valid.',
                'adminUserUpdateActive.required' => 'Update active is not valid.',
                'adminUserUpdateName.required' => 'Name for update user is empty.',
                'adminUserUpdateUsername.required' => 'Username for update user is empty.',
                'adminUserUpdateEmail.required' => 'Email for update user is empty.'
            ];
    }



}
