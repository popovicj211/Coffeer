<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserAddRequest extends FormRequest
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
            'adminUserAddName' => 'required|regex:/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,13}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,15})+$/',
            'adminUserAddUsername' => 'required|unique:user,username|regex:/^[\.\_\-\w\d\@]{3,15}$/',
            'adminUserAddEmail' => 'required|email|unique:user,email|max:60',
             'adminUserAddPass' => 'required|regex:/^[A-z0-9\.\-\*\_$\:\;\@\,]{6,15}$/',
            'adminUserAddRole' => 'required|not_in:0',
             'adminUserAddActive' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'adminUserAddUsername.unique' => 'Added username exist.',
            'adminUserAddEmail.unique'  => 'Added email exist.',
            'adminUserAddName.regex'  => 'Added name is not valid.',
            'adminUserAddUsername.regex'  => 'Added username is not valid.',
            'adminUserAddEmail.regex'  => 'Added email is not valid.',
            'adminUserAddPass.regex'  => 'Added password is not valid.',
            'adminUserAddRole.not_in'  => 'Role is not selected.',
            'adminUserAddActive.required'  => 'Added active is not valid.',
            'adminUserAddName.required'  => 'Name for add user is empty.',
            'adminUserAddUsername.required'  => 'Username for add user is empty.',
            'adminUserAddEmail.required'  => 'Email for add user is empty.',
            'adminUserAddPass.required'  => 'Password for add user is empty.'
        ];
    }

}
